<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  die("Silakan login terlebih dahulu.");
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
  die("Lapangan tidak ditemukan");
}

$field_id = (int) $_GET['id'];

$query = mysqli_query($conn, "
SELECT *
FROM fields
WHERE field_id='$field_id'
");

$field = mysqli_fetch_assoc($query);


$qFav = mysqli_query($conn, "
SELECT *
FROM favorites
WHERE user_id='$user_id'
AND field_id='$field_id'
");

$isFavorite = mysqli_num_rows($qFav) > 0;

if (!$field) {
  die("Data lapangan tidak ditemukan");
}
$tanggal =
  $_GET['tanggal']
  ?? date('Y-m-d');

$bookings = mysqli_query($conn, "
SELECT jam_mulai,jam_selesai
FROM booking
WHERE field_id='$field_id'
AND tanggal='$tanggal'
AND status!='dibatalkan'
");
$booking_id =
  $_SESSION['booking_id']
  ?? null;
if ($booking_id) {

  $q = mysqli_query($conn, "
    SELECT *
    FROM booking
    WHERE booking_id='$booking_id'
    ");

  $booking =
    mysqli_fetch_assoc($q);
}

$jamPenuh = [];

while ($b = mysqli_fetch_assoc($bookings)) {

  $awal =
    (int) substr($b['jam_mulai'], 0, 2);

  $akhir =
    (int) substr($b['jam_selesai'], 0, 2);

  for ($i = $awal; $i < $akhir; $i++) {

    $jamPenuh[] =
      sprintf("%02d:00", $i);
  }
}

// CEK HARI LIBUR (sinkron sama format dari dashboard-owner: "2026-07-10 s/d 2026-07-15")
$isLibur = false;

if (!empty($field['hari_libur'])) {

  $rentangLibur = explode(" s/d ", $field['hari_libur']);

  $liburMulai = $rentangLibur[0] ?? "";
  $liburSelesai = $rentangLibur[1] ?? "";

  if (
    !empty($liburMulai) &&
    !empty($liburSelesai) &&
    $tanggal >= $liburMulai &&
    $tanggal <= $liburSelesai
  ) {
    $isLibur = true;
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Lapangan — SportSpace</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="detail.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap"
    rel="stylesheet">
</head>

<script>
  const slotPrice = <?= $field['harga']; ?>;

  const selectedSlots = [];

  // SLOT
  function toggleSlot(button) {
    if (button.disabled) return;
    if (button.classList.contains("penuh")) return;

    button.classList.toggle("selected");

    const semuaJam = [];

    document.querySelectorAll(".slot-btn.selected").forEach(btn => {

      semuaJam.push(parseInt(btn.dataset.start));

    });

    semuaJam.sort((a, b) => a - b);

    let urut = true;

    for (let i = 1; i < semuaJam.length; i++) {

      if (semuaJam[i] - semuaJam[i - 1] != 1) {

        urut = false;
        break;

      }

    }

    if (!urut) {

      alert("Jam booking harus berurutan!");

      button.classList.remove("selected");

      return;

    }

    const start = button.dataset.start;
    const end = button.dataset.end;

    const slot = `${start} - ${end}`;

    selectedSlots.length = 0;

    document.querySelectorAll(".slot-btn.selected").forEach(btn => {

      selectedSlots.push({

        start: btn.dataset.start,

        end: btn.dataset.end

      });

    });

    updateSummary();
  }

  // UPDATE RINGKASAN
  function updateSummary() {

    if (selectedSlots.length === 0) {

      document.getElementById("summary-time")
        .innerText = "-";

      document.getElementById("summary-duration")
        .innerText = "0 Jam";

      document.getElementById("summary-total")
        .innerText = "Rp0";

      return;
    }

    const sorted = [...selectedSlots].sort((a, b) => {

      return a.start.localeCompare(b.start);

    });

    const first = sorted[0].start;

    const last = sorted[sorted.length - 1].end;

    console.log(selectedSlots);
    console.log(first);
    console.log(last);

    document.getElementById("jam_mulai").value = first;

    document.getElementById("jam_selesai").value = last;

    console.log(first);
    console.log(last);

    document.getElementById("durasi").value =
      selectedSlots.length;

    document.getElementById("total").value =
      selectedSlots.length * slotPrice;


    document.getElementById("summary-time")
      .innerText = `${first} - ${last}`;

    document.getElementById("summary-duration")
      .innerText =
      `${selectedSlots.length} Jam`;

    const total =
      selectedSlots.length * slotPrice;

    document.getElementById("summary-total")
      .innerText =
      "Rp" + total.toLocaleString("id-ID");
  }


</script>

<body>

  <!-- NAVBAR -->
  <nav class="navbar">

    <a href="index.php" class="navbar-brand">
      <i class="ti ti-bowling"></i>
      <span>SportSpace</span>
      <div class="dot"></div>
    </a>

    <div class="navbar-links">
      <a href="index.php">Beranda</a>
      <a href="index.php#lapangan" class="active">Lapangan</a>
      <a href="index.php#tentang">Tentang</a>
    </div>

    <div class="navbar-actions">

      <a href="riwayat.php">
        <button class="btn btn-outline btn-sm">
          Riwayat
        </button>
      </a>

      <a href="login.html">
        <button class="btn btn-primary btn-sm">
          Akun
        </button>
      </a>

    </div>

  </nav>

  <?php

  $from = $_GET['from'] ?? 'index';

  if ($from == "favorite") {
    $backLink = "favorite.php";
  } elseif ($from == "riwayat") {
    $backLink = "riwayat.php";
  } else {
    $backLink = "index.php#lapangan";
  }

  ?>

  <div class="back-button">

    <a href="<?= $backLink ?>" class="back-link">

      <i class="ti ti-arrow-left"></i>

    </a>

  </div>

  <div class="detail-wrapper">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">

      <a href="index.php">Beranda</a>

      <i class="ti ti-chevron-right"></i>

      <a href=index.php#lapangan>Lapangan</a>

      <i class="ti ti-chevron-right"></i>

      <span style="color:var(--gray-700);">
        <?= $field['nama_lapangan']; ?>
      </span>

    </div>

    <div class="detail-grid">

      <!-- KIRI -->
      <div class="detail-main">

        <!-- HERO CARD -->
        <div class="detail-card">

          <div class="detail-image">


           <img src="uploads/fields/<?= $field['gambar']; ?>" alt="<?= $field['nama_lapangan']; ?>">

            <div class="detail-overlay"></div>

            <div class="detail-badge">
              <span class="badge badge-green">
                <?php echo ucfirst($field['status']); ?>
              </span>
            </div>

          </div>

          <div class="detail-content">

            <div class="detail-header">

              <div class="detail-title">

                <div class="title-row">

                  <h1>
                    <?= $field['nama_lapangan']; ?>
                  </h1>

                  <button class="favorite-btn <?= $isFavorite ? 'active' : '' ?>" id="favoriteBtn"
                    data-field="<?= $field['field_id']; ?>">

                    <i class="ti <?= $isFavorite ? 'ti-heart-filled' : 'ti-heart' ?>"></i>

                  </button>
                </div>

                <div class="detail-location">

                  <p>
                    <i class="ti ti-building"></i>
                    <?= $field['nama_lapangan']; ?>

                    &nbsp;&nbsp;

                    <i class="ti ti-map-pin"></i>
                    <?= $field['lokasi']; ?>
                  </p>

                </div>

                <div class="detail-rating">

                  <span class="stars">★★★★★</span>

                  <span class="rating-text">
                    4.8 (24 ulasan)
                  </span>

                  <span>
                    <i class="ti ti-ball-football"></i>
                    <?= $field['jenis']; ?>
                  </span>

                </div>

                <div class="price-row">

                  <strong>
                    Rp
                    <?= number_format($field['harga'], 0, ',', '.'); ?>
                  </strong>

                  <span>/jam</span>

                </div>

              </div>

            </div>

            <p style="color:var(--gray-500);line-height:1.8;margin-top:18px;">
            <p>
              <?php echo $field['deskripsi']; ?>
            </p>

            </p>

            <!-- MAP LOKASI -->
            <div class="section-card">

              <div class="map-header">

                <div>

                  <h2>Lokasi Lapangan</h2>

                  <p>
                    Jl. Kaliurang Km 7, Sleman, Yogyakarta
                  </p>

                </div>

                <div class="distance-badge">

                  <i class="ti ti-route"></i>
                  2.4 km

                </div>

              </div>

              <!-- MAP -->
              <div class="map-frame">
                <iframe src="<?= $field['maps_link']; ?>" loading="lazy" allowfullscreen>
                </iframe>
              </div>

              <!-- ACTION -->
              <div class="map-actions">

                <a href="<?= $field['google_maps_url']; ?>" target="_blank">

                  <button class="btn btn-primary">

                    <i class="ti ti-map-pin"></i>
                    Buka Google Maps

                  </button>

                </a>

                <button class="btn btn-outline">

                  <i class="ti ti-navigation"></i>
                  Petunjuk Arah

                </button>

              </div>

              <div class="info-grid">

                <div class="info-box">
                  <?php echo $field['jam_operasional']; ?>
                </div>

                <div class="info-box">
                  <?php echo $field['kapasitas']; ?> Pemain
                </div>

                <div class="info-box">
                  <?php echo $field['jenis_lantai']; ?>

                </div>

                <div class="info-box">
                  <?php echo $field['fasilitas']; ?>
                </div>

              </div>

            </div>

          </div>

          <!-- BOOKING -->
          <div class="section-card">

            <h2>Pilih Jadwal Booking</h2>

            <div style="margin-bottom:24px;">

              <label style="display:block;font-size:14px;font-weight:600;margin-bottom:10px;color:var(--gray-700);">

                Pilih Tanggal Booking

              </label>

              <div class="calendar-input">
                <input type="date" id="booking-date-display" min="<?= date('Y-m-d'); ?>" value="<?= htmlspecialchars($tanggal) ?>">
              </div>

            </div>

            <!-- NOTICE HARI LIBUR -->
            <div id="liburNotice" class="libur-notice" style="<?= $isLibur ? 'display:flex;' : 'display:none;' ?>">
              <i class="ti ti-calendar-off"></i>
              Lapangan tutup/libur pada tanggal ini. Silakan pilih tanggal lain.
            </div>

            <div class="slots-grid">

              <?php

              for ($jam = 6; $jam < 22; $jam++) {

                $mulai =
                  sprintf('%02d:00', $jam);

                $selesai =
                  sprintf('%02d:00', $jam + 1);

                $penuh =
                  in_array(
                    $mulai,
                    $jamPenuh
                  ) || $isLibur;

                ?>

                <button class="slot-btn <?= $penuh ? 'penuh' : '' ?>" id="slot-<?= $mulai ?>" <?= $penuh ? 'disabled' : '' ?> onclick="toggleSlot(this)" data-start="<?= $mulai ?>" data-end="<?= $selesai ?>">

                  <?= str_replace(':', '.', $mulai) ?>
                  -
                  <?= str_replace(':', '.', $selesai) ?>

                </button>
              <?php } ?>
            </div>
            <!-- REVIEW -->
            <div class="section-card">

              <div style="display:flex;justify-content:space-between;align-items:center;">

                <h2>Ulasan Pengguna</h2>

                <div class="detail-rating">

                  <span class="stars">

                    <i class="ti ti-star-filled active"></i>
                    <i class="ti ti-star-filled active"></i>
                    <i class="ti ti-star-filled active"></i>
                    <i class="ti ti-star-filled active"></i>
                    <i class="ti ti-star-filled half"></i>

                  </span>

                  <div class="rating-text">

                    <strong>4.8</strong>
                    <span>/5</span>

                  </div>

                  <span class="review-count">
                    (24 ulasan)
                  </span>

                </div>

              </div>

              <div class="review-item">

                <div class="review-header">

                  <div class="review-user">

                    <div class="avatar green">AR</div>

                    <div>

                      <strong>Andi Ramadhan</strong>

                      <span class="stars">

                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>

                      </span>

                    </div>

                  </div>

                  <span style="font-size:13px;color:var(--gray-400);">
                    2 hari lalu
                  </span>

                </div>

                <p style="color:var(--gray-500);line-height:1.7;">

                  Lapangannya bersih, nyaman, dan pencahayaan bagus banget buat main malam.

                </p>

              </div>

              <div class="review-item">

                <div class="review-header">

                  <div class="review-user">

                    <div class="avatar blue">DW</div>

                    <div>

                      <strong>Dewi Wulan</strong>

                      <span class="stars">

                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>

                      </span>

                    </div>

                  </div>

                  <span style="font-size:13px;color:var(--gray-400);">
                    1 minggu lalu
                  </span>

                </div>

                <p style="color:var(--gray-500);line-height:1.7;">

                  Parkiran luas, tempatnya strategis. Harga segini udah worth banget, pasti balik lagi!

                </p>

              </div>

              <div class="review-item">

                <div class="review-header">

                  <div class="review-user">

                    <div class="avatar pink">RF</div>

                    <div>

                      <strong>Rizki F.</strong>

                      <span class="stars">

                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>
                        <i class="ti ti-star-filled active"></i>

                      </span>

                    </div>

                  </div>

                  <span style="font-size:13px;color:var(--gray-400);">
                    2 minggu lalu
                  </span>

                </div>

                <p style="color:var(--gray-500);line-height:1.7;">

                  Fasilitas lengkap, ada kantin juga. Proses booking lewat app gampang banget. GG!

                </p>

              </div>

              <div class="more-review">

                <button class="btn-more" onclick="showMoreReviews()">

                  Lihat lebih banyak

                  <i class="ti ti-chevron-down"></i>

                </button>

              </div>

            </div>

          </div>

          <script>
            const bookingDate =
              document.getElementById("booking-date-display");

            bookingDate.addEventListener("change", function () {

              document.getElementById("booking-date").value =
                this.value;

              const tanggalFormat =
                new Date(this.value);

              document.getElementById("summary-date").innerText =
                tanggalFormat.toLocaleDateString(
                  "id-ID", {
                  weekday: "long",
                  day: "numeric",
                  month: "long",
                  year: "numeric"
                }
                );

              fetch(
                "cek-jadwal.php?field_id=<?= $field_id ?>&tanggal=" + this.value
              )

                .then(res => res.json())

                .then(data => {
                  console.log(data);

                  const liburNotice = document.getElementById("liburNotice");

                  document.querySelectorAll(".slot-btn").forEach(btn => {

                    btn.classList.remove("selected");
                    btn.classList.remove("penuh");
                    btn.classList.remove("booked");

                    btn.disabled = false;

                  });

                  selectedSlots.length = 0;

                  updateSummary();

                  if (data.libur) {

                    // Hari libur: semua slot diblok, tampilin notice
                    liburNotice.style.display = "flex";

                    document.querySelectorAll(".slot-btn").forEach(btn => {
                      btn.classList.add("penuh");
                      btn.disabled = true;
                    });

                  } else {

                    liburNotice.style.display = "none";

                    data.penuh.forEach(jam => {

                      const btn =
                        document.getElementById("slot-" + jam);

                      if (btn) {

                        btn.classList.add("penuh");
                        btn.classList.add("booked");

                        btn.disabled = true;

                      }

                    });

                  }

                  disablePastTime();

                });

            });
          </script>
          <div class="owner-card">

            <h3 style="font-size:16px;margin-bottom:18px;">

              <i class="ti ti-building-store"></i>
              Info GOR

            </h3>

            <div class="owner-profile">

              <?php
              $inisial = "";

              if (!empty($field['owner_name'])) {

                $kata = explode(" ", trim($field['owner_name']));

                foreach ($kata as $k) {
                  $inisial .= strtoupper(substr($k, 0, 1));
                }

                $inisial = substr($inisial, 0, 2);

              } else {

                $inisial = "PG";

              }
              ?>

              <div class="avatar green">
                <?= $inisial ?>
              </div>

              <div class="owner-text">

                <h4>
                  <?= $field['owner_name']; ?>
                </h4>
                <span>Pemilik GOR</span>

              </div>

            </div>

            <div class="summary-divider"></div>

            <div class="owner-info">
              <i class="ti ti-phone"></i>
              <?= htmlspecialchars($field['owner_phone']); ?>
            </div>

            <div class="owner-info">
              <i class="ti ti-map-pin"></i>
              <?= htmlspecialchars($field['owner_address']); ?>
            </div>

            <a href="chat.php?field_id=<?= $field['field_id']; ?>" class="btn btn-primary btn-full">
              <i class="ti ti-message-circle"></i>
              Chat Owner
            </a>
          </div>
        </div>
      </div>
      <!-- KANAN -->
      <div class="detail-sidebar">

        <div class="booking-card">

          <h2 style="font-size:22px;margin-bottom:24px;">
            Ringkasan Booking
          </h2>

          <div class="summary-row">
            <span>Lapangan</span>
            <strong>
              <?php echo $field['nama_lapangan']; ?>
            </strong>
          </div>

          <div class="summary-row">
            <span>Tanggal</span>
            <strong id="summary-date">Pilih tanggal</strong>
          </div>

          <div class="summary-row">
            <span>Jam</span>
            <strong id="summary-time">-</strong>
          </div>

          <div class="summary-row">
            <span>Durasi</span>
            <strong id="summary-duration">0 Jam</strong>
          </div>

          <div class="summary-divider"></div>

          <div class="summary-row" style="font-size:18px;">
            <span>Total</span>
            <strong id="summary-total">Rp0</strong>
          </div>

          <div class="summary-divider"></div>

          <form action="pembayaran.php" method="POST" onsubmit="return cekBooking();">

            <input type="hidden" name="field_id" value="<?= $field['field_id']; ?>">

            <input type="hidden" name="harga" value="<?= $field['harga']; ?>">

            <input type="hidden" id="jam_mulai" name="jam_mulai">

            <input type="hidden" id="jam_selesai" name="jam_selesai">

            <input type="hidden" id="durasi" name="durasi">

            <input type="hidden" id="total" name="total">

            <input type="hidden" id="booking-date" name="tanggal">

            <button type="submit" class="btn btn-primary btn-lg btn-full">

              Lanjut Pembayaran

            </button>

          </form>

          <div class="alert alert-info" style="margin-top:18px;">

            <i class="ti ti-info-circle"></i>

            Booking akan dikonfirmasi setelah pembayaran diverifikasi.

          </div>

        </div>

      </div>

    </div>

  </div>

  </div>
  <footer class="footer">

    <strong>SportSpace</strong>

    &nbsp;·&nbsp;

    Booking lapangan olahraga mudah & cepat

    &nbsp;·&nbsp;

    &copy; <?= date('Y'); ?>

  </footer>

  <script src="js/main.js"></script>
  <script>
    const favBtn = document.getElementById("favoriteBtn");

    if (favBtn) {

      favBtn.addEventListener("click", function () {

        const field_id = this.dataset.field;

        fetch("toggle_favorite.php", {

          method: "POST",

          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },

          body: "field_id=" + encodeURIComponent(field_id)

        })

          .then(res => res.json())

          .then(data => {

            if (!data.success) return;

            const icon = favBtn.querySelector("i");

            if (data.favorite) {

              favBtn.classList.add("active");

              icon.classList.remove("ti-heart");
              icon.classList.add("ti-heart-filled");

            } else {

              favBtn.classList.remove("active");

              icon.classList.remove("ti-heart-filled");
              icon.classList.add("ti-heart");

            }

          })

      })

        .catch(err => console.log(err));

    }


    function cekBooking() {

      const tanggal =
        document.getElementById("booking-date").value;
      const jam = document.getElementById("jam_mulai").value;

      if (tanggal === "" || jam === "") {
        alert("Silakan pilih tanggal dan jam booking terlebih dahulu!");
        return false;
      }

      return true;
    }

    function disablePastTime() {

      const tanggal =
        document.getElementById("booking-date-display").value;

      if (tanggal == "") return;

      const today = new Date();

      const selected = new Date(tanggal);

      document.querySelectorAll(".slot-btn").forEach(btn => {

        if (!btn.classList.contains("booked")) {

          btn.disabled = false;

          btn.classList.remove("penuh");

        }

      });

      if (selected.toDateString() != today.toDateString())
        return;

      const nowHour = today.getHours();

      document.querySelectorAll(".slot-btn").forEach(btn => {

        const start = parseInt(btn.dataset.start);

        if (start <= nowHour) {

          btn.disabled = true;

          btn.classList.add("penuh");

        }

      });

    }

    window.onload = function () {

      disablePastTime();

    }
  </script>

</body>

</html>