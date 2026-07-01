<?php
require 'config.php';
session_start();

// Ambil semua lapangan dari database
$result = $conn->query("SELECT * FROM fields ORDER BY field_id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SportSpace — Booking Lapangan Olahraga</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
</head>
<body>

  <nav class="navbar">
    <div class="navbar-brand">
      <i class="ti ti-bowling"></i>
      <span>SportSpace</span>
      <div class="dot"></div>
    </div>
    <div class="navbar-links">
      <a href="#beranda">Beranda</a>
      <a href="#lapangan">Lapangan</a>
      <a href="#tentang">Tentang</a>
    </div>
    <div class="navbar-actions">
      <?php if (isset($_SESSION['user_id'])): ?>
        <span style="font-size:14px;color:var(--green);font-weight:600;">
          Halo, <?= htmlspecialchars($_SESSION['nama']) ?>!
        </span>
        <a href="logout.php"><button class="btn btn-outline btn-sm">Keluar</button></a>
      <?php else: ?>
        <a href="login.html"><button class="btn btn-outline btn-sm">Masuk</button></a>
        <a href="login.html"><button class="btn btn-primary btn-sm">Daftar</button></a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero" id="beranda">
    <div class="hero-badge"><i class="ti ti-bolt"></i> Booking lapangan jadi lebih mudah</div>
    <h1>Cari & Booking Lapangan<br>Olahraga Favoritmu</h1>
    <p>Futsal, padel, basket, dan lainnya yang tersedia di kotamu. Booking dalam hitungan menit!</p>
    <div class="search-box">
      <i class="ti ti-map-pin" style="color:var(--gray-400);font-size:18px;margin-top:2px;"></i>
      <input type="text" id="searchInput" placeholder="Cari Cabang Olahraga atau Lapangan...">
      <button class="btn btn-primary" onclick="jalankanCari()">Cari Lapangan</button>
    </div>
    <div class="hero-stats">
      <div class="hero-stat">
        <div class="num">1.2rb+</div>
        <div class="lbl">Pengguna aktif</div>
      </div>
      <div class="hero-stat">
        <div class="num">85+</div>
        <div class="lbl">GOR terdaftar</div>
      </div>
      <div class="hero-stat">
        <div class="num">400+</div>
        <div class="lbl">Booking bulan ini</div>
      </div>
      <div class="hero-stat">
        <div class="num">4.8★</div>
        <div class="lbl">Rating rata-rata</div>
      </div>
    </div>
  </section>

  <!-- LAPANGAN -->
  <div class="section" id="lapangan">
    <div class="section-header">
      <div>
        <h2 class="section-title">Lapangan tersedia</h2>
        <p class="section-subtitle">Pilih lapangan terbaik di sekitarmu</p>
      </div>
      <a href="#" style="font-size:13px;color:var(--green);font-weight:600;">Lihat semua <i class="ti ti-arrow-right"></i></a>
    </div>

    <div class="sport-chips" style="margin-bottom:20px;">
      <div class="sport-chip active" onclick="filterSport(this,'semua')"><i class="ti ti-category"></i> Semua</div>
      <div class="sport-chip" onclick="filterSport(this,'futsal')"><i class="ti ti-ball-football"></i> Futsal</div>
      <div class="sport-chip" onclick="filterSport(this,'badminton')"><i class="ti ti-feather"></i> Badminton</div>
      <div class="sport-chip" onclick="filterSport(this,'basket')"><i class="ti ti-ball-basketball"></i> Basket</div>
      <div class="sport-chip" onclick="filterSport(this,'renang')"><i class="ti ti-swimming"></i> Renang</div>
    </div>

    <div class="fields-grid">
      <?php while ($lap = $result->fetch_assoc()): ?>
        <?php
          // Tentukan badge berdasarkan status
          $badge_class = $lap['status'] === 'tersedia' ? 'badge-green' : 'badge-amber';
          $badge_text  = $lap['status'] === 'tersedia' ? 'Tersedia' : 'Penuh hari ini';

          // Tentukan ikon jenis olahraga
          $icon = 'ti-ball-football';
          if ($lap['jenis'] === 'badminton') $icon = 'ti-feather';
          if ($lap['jenis'] === 'basket')    $icon = 'ti-ball-basketball';
          if ($lap['jenis'] === 'renang')    $icon = 'ti-swimming';

          // Foto lapangan
          $foto = !empty($lap['gambar']) ? 'uploads/' . $lap['gambar'] : 'lapangan-futsal.jpg';
        ?>
        <div class="field-card" data-sport="<?= strtolower($lap['jenis']) ?>">
          <div class="field-img">
            <img src="<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($lap['nama_lapangan']) ?>">
            <span class="badge <?= $badge_class ?>"><?= $badge_text ?></span>
          </div>
          <div class="field-body">
            <div class="field-header-info">
              <div class="field-name"><?= htmlspecialchars($lap['nama_lapangan']) ?></div>
            </div>
            <div class="field-meta">
              <span><i class="ti ti-map-pin"></i> Yogyakarta</span>
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
                <a href="detail.php?id=<?= $lap['field_id'] ?>" class="btn-link">
                  <button class="btn btn-primary btn-sm">Booking <i class="ti ti-arrow-right"></i></button>
                </a>
              <?php else: ?>
                <a href="detail.php?id=<?= $lap['field_id'] ?>" class="btn-link">
                  <button class="btn btn-outline btn-sm">Lihat</button>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- CARA KERJA -->
  <div class="cara-kerja">
    <div class="section" id="tentang">
      <h2 class="section-title" style="text-align:center;">Cara pakai SportSpace</h2>
      <p class="section-subtitle" style="text-align:center;">Booking lapangan dalam 4 langkah mudah</p>
      <div class="how-steps-grid">
        <div class="how-step">
          <div class="how-num">1</div>
          <div class="how-text"><h3>Daftar akun</h3><p>Buat akun gratis dalam hitungan detik</p></div>
        </div>
        <div class="how-step">
          <div class="how-num">2</div>
          <div class="how-text"><h3>Cari lapangan</h3><p>Filter by olahraga, lokasi, dan harga</p></div>
        </div>
        <div class="how-step">
          <div class="how-num">3</div>
          <div class="how-text"><h3>Pilih jadwal</h3><p>Pilih tanggal dan slot waktu yang tersedia</p></div>
        </div>
        <div class="how-step">
          <div class="how-num">4</div>
          <div class="how-text"><h3>Bayar & main!</h3><p>Upload bukti bayar, konfirmasi, dan enjoy!</p></div>
        </div>
      </div>
    </div>
  </div>

  <!-- OWNER BANNER -->
  <div class="owner-banner">
    <div>
      <h2>Punya GOR atau lapangan?</h2>
      <p>Daftarkan venumu dan mulai terima booking online. Gratis, mudah, dan transparan.</p>
    </div>
    <a href="login.html"><button class="btn btn-white btn-lg">Daftar sebagai pemilik GOR <i class="ti ti-arrow-right"></i></button></a>
  </div>

  <footer class="footer">
    <strong>SportSpace</strong> &nbsp;·&nbsp; Booking lapangan olahraga mudah & cepat &nbsp;·&nbsp; &copy; 2025
  </footer>

  <script src="main.js"></script>
  <script>
    function filterSport(chip, sport) {
      document.querySelectorAll('.sport-chip').forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      document.querySelectorAll('.field-card').forEach(card => {
        card.style.display = (sport === 'semua' || card.dataset.sport === sport) ? 'block' : 'none';
      });
    }

    window.addEventListener('scroll', () => {
      let current = "";
      const sections = document.querySelectorAll("section[id], div[id].section");
      sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        if (pageYOffset >= sectionTop - 150) {
          current = section.getAttribute("id");
        }
      });
      const navLinks = document.querySelectorAll(".navbar-links a");
      navLinks.forEach((link) => {
        link.classList.remove("active");
        const href = link.getAttribute("href");
        if (href === `#${current}`) {
          link.classList.add("active");
        }
      });
    });
  </script>

</body>
</html>