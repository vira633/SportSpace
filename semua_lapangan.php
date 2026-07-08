<?php
require 'config.php';
session_start();

$result = $conn->query("SELECT * FROM fields ORDER BY field_id ASC");

// Ambil daftar lokasi unik buat isi dropdown Lokasi
$lokasiList = [];
$lokasiResult = $conn->query("SELECT DISTINCT lokasi FROM fields WHERE lokasi IS NOT NULL AND lokasi != '' ORDER BY lokasi ASC");
if ($lokasiResult) {
  while ($row = $lokasiResult->fetch_assoc()) {
    $lokasiList[] = $row['lokasi'];
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semua Lapangan — SportSpace</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="semua_lapangan.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
</head>

<body>

  <!-- NAVBAR (Pleketiplek dari index.php) -->
  <nav class="navbar">
    <div class="navbar-brand" onclick="window.location.href='index.php'" style="cursor:pointer;">
      <i class="ti ti-bowling"></i>
      <span>SportSpace</span>
      <div class="dot"></div>
    </div>
    <div class="navbar-links">
      <a href="index.php#beranda">Beranda</a>
      <a href="index.php#lapangan" class="active">Lapangan</a>
      <a href="index.php#tentang">Tentang</a>
    </div>
    <div class="navbar-actions">
      <?php if (isset($_SESSION['user_id'])): ?>

        <div class="user-dropdown-container">
          <button type="button" class="user-dropdown-trigger" onclick="toggleUserDropdown(event)">
            <i class="ti ti-user-circle" style="font-size: 20px;"></i>
            <span>Halo, <?= htmlspecialchars($_SESSION['nama']) ?>!</span>
            <i class="ti ti-chevron-down arrow-icon"></i>
          </button>

          <div class="user-dropdown-menu" id="userMenuDropdown">
            <a href="profile.php" class="user-dropdown-item">
              <i class="ti ti-user"></i> Profile
            </a>
            <a href="riwayat.php" class="user-dropdown-item">
              <i class="ti ti-history"></i> Riwayat
            </a>
            <a href="favorite.php" class="user-dropdown-item">
              <i class="ti ti-heart"></i> Favorit
            </a>
            <div class="user-dropdown-divider"></div>
            <a href="logout.php" class="user-dropdown-item logout-danger"
              onclick="return confirm('Yakin ingin keluar dari akun Anda?');">
              <i class="ti ti-logout"></i> Keluar
            </a>
          </div>
        </div>

      <?php else: ?>
        <a href="login.html"><button class="btn btn-outline btn-sm">Masuk</button></a>
        <a href="login.html#register"><button class="btn btn-primary btn-sm">Daftar</button></a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- KONTEN UTAMA -->
  <div class="section" id="lapangan" style="min-height: 70vh;">
    <div class="section-header" style="margin-bottom: 20px;">
      <div>
        <a href="index.php" class="btn-back">
          <i class="ti ti-arrow-left"></i>
        </a>
      </div>
    </div>

    <div class="filter-search-wrapper">

      <!-- SISI KIRI: Dropdowns -->
      <div class="filter-dropdown-group">
        <div class="filter-select-box">
          <i class="ti ti-git-fork"></i>
          <select id="filterKategori" class="filter-select-field" onchange="handleKategoriChange()">
            <option value="semua">Kategori ▾</option>
            <option value="futsal">Futsal</option>
            <option value="badminton">Badminton</option>
            <option value="basket">Basket</option>
            <option value="renang">Renang</option>
            <option value="lainnya">Lainnya...</option>
          </select>
          <input type="text" id="filterKategoriLainnya" class="filter-kategori-lainnya-input"
            placeholder="cth: voli" style="display:none;" onkeyup="jalankanFilterFasilitas()">
        </div>

        <div class="filter-select-box">
          <i class="ti ti-map-pin"></i>
          <select id="filterLokasi" class="filter-select-field" onchange="jalankanFilterFasilitas()">
            <option value="semua">Lokasi ▾</option>
            <?php foreach ($lokasiList as $lok): ?>
              <?php $slug = strtolower(trim(preg_replace('/\s+/', '-', $lok))); ?>
              <option value="<?= htmlspecialchars($slug) ?>"><?= htmlspecialchars($lok) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- SISI KANAN: Search Input -->
      <div class="search-input-group">
        <div class="search-bar-box">
          <i class="ti ti-search"></i>
          <input type="text" id="filterNama" class="search-input-field" placeholder="Cari nama atau lokasi lapangan..."
            onkeyup="jalankanFilterFasilitas()">
        </div>
      </div>

    </div>

    <div class="fields-grid">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($lap = $result->fetch_assoc()): ?>
          <?php
          $badge_class = $lap['status'] === 'tersedia' ? 'badge-green' : 'badge-amber';
          $badge_text = $lap['status'] === 'tersedia' ? 'Tersedia' : 'Penuh hari ini';

          $icon = 'ti-ball-football';
          if ($lap['jenis'] === 'badminton')
            $icon = 'ti-feather';
          if ($lap['jenis'] === 'basket')
            $icon = 'ti-ball-basketball';
          if ($lap['jenis'] === 'renang')
            $icon = 'ti-swimming';

          $foto = !empty($lap['gambar']) ? $lap['gambar'] : 'lapangan-futsal.jpg';
          $lokasiAsli = !empty($lap['lokasi']) ? $lap['lokasi'] : 'Yogyakarta';
          $lokasiSlug = strtolower(trim(preg_replace('/\s+/', '-', $lokasiAsli)));
          ?>
          <div class="field-card" data-sport="<?= strtolower($lap['jenis']) ?>" data-lokasi="<?= htmlspecialchars($lokasiSlug) ?>">
            <div class="field-img">
              <img src="<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($lap['nama_lapangan']) ?>">
              <span class="badge <?= $badge_class ?>"><?= $badge_text ?></span>
            </div>
            <div class="field-body">
              <div class="field-header-info">
                <div class="field-name"><?= htmlspecialchars($lap['nama_lapangan']) ?></div>
              </div>
              <div class="field-meta">
                <span class="field-lokasi-text" title="<?= htmlspecialchars($lokasiAsli) ?>"><i class="ti ti-map-pin"></i> <?= htmlspecialchars($lokasiAsli) ?></span>
                <span><i class="ti <?= $icon ?>"></i> <?= htmlspecialchars($lap['jenis']) ?></span>
              </div>
              <div class="field-rating">
                <span class="stars">★★★★★</span>
                <span class="rating-text">4.8 (24 ulasan)</span>
              </div>
              <div class="field-footer">
                <div class="field-price">
                  Rp<?= number_format($lap['harga'], 0, ',', '.') ?> <span>/jam</span>
                </div>

                <?php if ($lap['status'] === 'tersedia'): ?>
                  <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="detail.php?id=<?= $lap['field_id'] ?>" class="btn-link">
                      <button class="btn btn-primary btn-sm">Booking <i class="ti ti-arrow-right"></i></button>
                    </a>
                  <?php else: ?>
                    <a href="login.html" class="btn-link">
                      <button class="btn btn-outline btn-sm" style="white-space: nowrap;">Booking</button>
                    </a>
                  <?php endif; ?>
                <?php else: ?>
                  <a href="detail.php?id=<?= $lap['field_id'] ?>" class="btn-link">
                    <button class="btn btn-outline btn-sm">Lihat</button>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="color:var(--gray-400); grid-column: 1/-1; text-align:center; padding: 40px 0;">Belum ada data lapangan
          di dalam database.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-inner">
      <div class="footer-left">
        <div class="footer-info">
          <div class="footer-brand">
            <strong>
              <i class="ti ti-bowling"></i>
              SportSpace
            </strong>
          </div>
          <p>&copy; 2026 SportSpace. All Rights Reserved.</p>
        </div>
        <div class="footer-links">
          <a href="#">Terms of Service</a>
          <a href="#">Privacy Policy</a>
        </div>
      </div>
      <div class="footer-right">
        <div class="footer-social">
          <a href="https://wa.me/6285184736633" target="_blank" rel="noopener noreferrer">
            <i class="ti ti-brand-whatsapp"></i> Chat on WhatsApp
          </a>
          <a href="https://www.instagram.com/vierreverie?igsh=bmV0Ymk3Z20ybGVv" target="_blank"
            rel="noopener noreferrer">
            <i class="ti ti-brand-instagram"></i> Follow us on Instagram
          </a>
        </div>
      </div>
    </div>
  </footer>

  <!-- SCRIPT REAL-TIME FILTER -->
  <script>
    // Dropdown User (biar sinkron sama index.php)
    function toggleUserDropdown(event) {
      event.stopPropagation();
      const dropdown = document.getElementById('userMenuDropdown');
      if (dropdown) {
        dropdown.classList.toggle('show');
      }
    }

    document.addEventListener('click', function (event) {
      const dropdown = document.getElementById('userMenuDropdown');
      const trigger = document.querySelector('.user-dropdown-trigger');

      if (dropdown && dropdown.classList.contains('show')) {
        if (trigger && !dropdown.contains(event.target) && !trigger.contains(event.target)) {
          dropdown.classList.remove('show');
        }
      }
    });

    // Muncul/sembunyi input "Lainnya" pas dropdown kategori diganti
    function handleKategoriChange() {
      const select = document.getElementById('filterKategori');
      const inputLainnya = document.getElementById('filterKategoriLainnya');
      const box = select.closest('.filter-select-box');

      if (select.value === 'lainnya') {
        inputLainnya.style.display = 'inline-block';
        inputLainnya.focus();
        if (box) box.classList.add('is-expanded');
      } else {
        inputLainnya.style.display = 'none';
        inputLainnya.value = '';
        if (box) box.classList.remove('is-expanded');
      }
      jalankanFilterFasilitas();
    }

    function jalankanFilterFasilitas() {
      const kategoriPilihan = document.getElementById('filterKategori').value.toLowerCase();
      const kategoriLainnya = document.getElementById('filterKategoriLainnya').value.toLowerCase().trim();
      const lokasiPilihan = document.getElementById('filterLokasi').value.toLowerCase();
      const namaPilihan = document.getElementById('filterNama').value.toLowerCase();

      const cards = document.querySelectorAll('.field-card');

      cards.forEach(card => {
        const sportType = card.dataset.sport;
        const lokasiType = card.dataset.lokasi;
        const namaLapangan = card.querySelector('.field-name').textContent.toLowerCase();
        const lokasiText = card.querySelector('.field-lokasi-text').textContent.toLowerCase();

        let matchKategori;
        if (kategoriPilihan === 'semua') {
          matchKategori = true;
        } else if (kategoriPilihan === 'lainnya') {
          // Kalau belum ngetik apa-apa, tampilkan semua dulu
          matchKategori = kategoriLainnya === '' ? true : sportType.includes(kategoriLainnya);
        } else {
          matchKategori = sportType === kategoriPilihan;
        }

        const matchLokasi = (lokasiPilihan === 'semua' || lokasiType === lokasiPilihan);
        const matchNama = namaLapangan.includes(namaPilihan) || lokasiText.includes(namaPilihan);

        if (matchKategori && matchLokasi && matchNama) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    }
  </script>

</body>

</html>