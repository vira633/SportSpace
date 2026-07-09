<?php
require 'config.php';
session_start();

// Ambil semua lapangan dari database
$result = $conn->query("SELECT * FROM fields WHERE aktif='aktif' AND verifikasi='diterima' ORDER BY field_id ASC");
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
            <a href="logout.php" class="user-dropdown-item logout-danger">
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
      <a href="semua_lapangan.php" style="font-size:13px;color:var(--green);font-weight:600;">Lihat semua <i
          class="ti ti-arrow-right"></i></a>
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
        // Cek apakah lapangan lagi libur HARI INI (rentang tanggal dari dashboard owner)
        $isLiburHariIni = false;
        $hariIni = date('Y-m-d');

        if (!empty($lap['hari_libur'])) {
          $rentangLibur = explode(" s/d ", $lap['hari_libur']);
          $liburMulai = $rentangLibur[0] ?? '';
          $liburSelesai = $rentangLibur[1] ?? '';

          if (!empty($liburMulai) && !empty($liburSelesai) && $hariIni >= $liburMulai && $hariIni <= $liburSelesai) {
            $isLiburHariIni = true;
          }
        }

        // Cek apakah semua slot jadwal hari ini sudah penuh (dibooking) atau sudah lewat jam
        // Logikanya disamain persis sama detail.php: slot jam 06:00 - 22:00 per 1 jam,
        // dan booking yang ngeblok slot adalah semua yang statusnya BUKAN 'dibatalkan'
        $isPenuhHariIni = false;

        if (!$isLiburHariIni) {
          $jamSekarangInt = (int) date('H');

          $stmtBooking = $conn->prepare("SELECT jam_mulai, jam_selesai FROM booking WHERE field_id = ? AND tanggal = ? AND status != 'dibatalkan'");
          $stmtBooking->bind_param("is", $lap['field_id'], $hariIni);
          $stmtBooking->execute();
          $bookingHariIni = $stmtBooking->get_result()->fetch_all(MYSQLI_ASSOC);
          $stmtBooking->close();

          // Bikin daftar jam yang udah kebooking, misal ["06:00","07:00", ...]
          $jamPenuh = [];
          foreach ($bookingHariIni as $b) {
            $awal = (int) substr($b['jam_mulai'], 0, 2);
            $akhir = (int) substr($b['jam_selesai'], 0, 2);
            for ($i = $awal; $i < $akhir; $i++) {
              $jamPenuh[] = sprintf('%02d:00', $i);
            }
          }

          // Cek satu-satu slot dari jam 06:00 s/d 21:00 (sama kayak di halaman detail)
          $adaSlotKosong = false;
          for ($jam = 6; $jam < 22; $jam++) {
            $mulai = sprintf('%02d:00', $jam);
            $sudahDibooking = in_array($mulai, $jamPenuh);
            $sudahLewat = $jam <= $jamSekarangInt;

            if (!$sudahDibooking && !$sudahLewat) {
              $adaSlotKosong = true;
              break;
            }
          }

          if (!$adaSlotKosong) {
            $isPenuhHariIni = true;
          }
        }

        // Tentukan badge & status tampil berdasarkan prioritas: Libur > Penuh > Tersedia
        if ($isLiburHariIni) {
          $badge_class = 'badge-amber';
          $badge_text = 'Libur hari ini';
          $statusTampil = 'libur';
        } elseif ($lap['status'] === 'tersedia' && !$isPenuhHariIni) {
          $badge_class = 'badge-green';
          $badge_text = 'Tersedia';
          $statusTampil = 'tersedia';
        } else {
          $badge_class = 'badge-amber';
          $badge_text = 'Penuh hari ini';
          $statusTampil = 'penuh';
        }

        // Tentukan ikon jenis olahraga
        $icon = 'ti-ball-football';
        if ($lap['jenis'] === 'badminton')
          $icon = 'ti-feather';
        if ($lap['jenis'] === 'basket')
          $icon = 'ti-ball-basketball';
        if ($lap['jenis'] === 'renang')
          $icon = 'ti-swimming';

        // Foto lapangan
        $gambar = "uploads/fields/" . $lap['gambar'];
        ?>
        <div class="field-card" data-sport="<?= strtolower($lap['jenis']) ?>">
          <div class="field-img">
            <img src="<?= htmlspecialchars($gambar) ?>" alt="<?= htmlspecialchars($lap['nama_lapangan']) ?>">
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

              <?php if ($statusTampil === 'tersedia'): ?>
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
                  <button class="btn btn-warning btn-sm">Lihat</button>
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
          <div class="how-text">
            <h3>Daftar akun</h3>
            <p>Buat akun gratis dalam hitungan detik</p>
          </div>
        </div>
        <div class="how-step">
          <div class="how-num">2</div>
          <div class="how-text">
            <h3>Cari lapangan</h3>
            <p>Filter by olahraga, lokasi, dan harga</p>
          </div>
        </div>
        <div class="how-step">
          <div class="how-num">3</div>
          <div class="how-text">
            <h3>Pilih jadwal</h3>
            <p>Pilih tanggal dan slot waktu yang tersedia</p>
          </div>
        </div>
        <div class="how-step">
          <div class="how-num">4</div>
          <div class="how-text">
            <h3>Bayar & main!</h3>
            <p>Upload bukti bayar, konfirmasi, dan enjoy!</p>
          </div>
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
    <a href="login.html#register"><button class="btn btn-white btn-lg">Daftar sebagai pemilik GOR <i
          class="ti ti-arrow-right"></i></button></a>
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


  <script src="main.js"></script>

  <script>
    // 1. Fungsi Dropdown User Sakti (Udah digabung di sini biar langsung kenal)
    function toggleUserDropdown(event) {
      event.stopPropagation();
      const dropdown = document.getElementById('userMenuDropdown');
      if (dropdown) {
        dropdown.classList.toggle('show');
      }
    }

    // Klik di luar menu buat nutup otomatis dropdown-nya
    document.addEventListener('click', function (event) {
      const dropdown = document.getElementById('userMenuDropdown');
      const trigger = document.querySelector('.user-dropdown-trigger');

      if (dropdown && dropdown.classList.contains('show')) {
        if (trigger && !dropdown.contains(event.target) && !trigger.contains(event.target)) {
          dropdown.classList.remove('show');
        }
      }
    });

    // 2. Fungsi Bawaan Kelompokmu (Filter Kategori Olahraga)
    function filterSport(chip, sport) {
      document.querySelectorAll('.sport-chip').forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      document.querySelectorAll('.field-card').forEach(card => {
        card.style.display = (sport === 'semua' || card.dataset.sport === sport) ? 'block' : 'none';
      });
    }

    // 3. Fungsi Bawaan Kelompokmu (Scroll Efek Navbar)
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