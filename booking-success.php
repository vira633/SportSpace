<?php

include 'config.php';

$booking_id = $_GET['id'];

$query = mysqli_query($conn, "
SELECT
    b.*,
    f.*,
    p.total,
    p.metode,
    p.tanggal_bayar,

    o.nama AS owner_nama,
    o.telepon,
    o.alamat

FROM booking b

JOIN fields f
ON b.field_id = f.field_id

JOIN payment p
ON b.booking_id = p.booking_id

LEFT JOIN owners o
ON f.field_id = o.field_id

WHERE b.booking_id = '$booking_id'
");
$data = mysqli_fetch_assoc($query);

if (!$data) {
  die("Booking tidak ditemukan");
}

$durasi =
  (
    strtotime($data['jam_selesai'])
    -
    strtotime($data['jam_mulai'])
  )
  /
  3600;

$kode_booking =
  "SS-" .
  date('Y') .
  "-" .
  str_pad(
    $data['booking_id'],
    5,
    "0",
    STR_PAD_LEFT
  );
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Booking Berhasil — SportSpace</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="detail.css">
  <link rel="stylesheet" href="booking-success.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap"
    rel="stylesheet">
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar">

    <div class="navbar-brand">
      <i class="ti ti-bowling"></i>
      <span>SportSpace</span>
      <div class="dot"></div>
    </div>

    <div class="navbar-links">
      <a href="index.php">Beranda</a>
      <a href="index.php#lapangan">Lapangan</a>
      <a href="index.php#tentang">Tentang</a>
    </div>

    <div class="navbar-actions">

      <a href="riwayat.html">
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

  <!-- CONTENT -->
  <div class="success-wrapper">

    <div class="success-grid">

      <!-- KIRI -->
      <div class="success-card">

        <!-- BANNER -->
        <div class="success-banner">

          <img src="<?= $data['gambar']; ?>">

          <div class="success-overlay"></div>

          <div class="success-badge">
            <span class="badge badge-green">
              Booking Berhasil
            </span>
          </div>

          <div class="success-content">

            <h1>Booking Terkonfirmasi 🎉</h1>

            <div class="success-meta">

              <span>
                <i class="ti ti-building"></i>
                <?= $data['nama_lapangan']; ?>
              </span>

              <span>
                <i class="ti ti-ball-football"></i>
                <?= $data['jenis']; ?>
              </span>

              <span>
                <i class="ti ti-map-pin"></i>
                <?= $data['lokasi']; ?>
              </span>

            </div>

          </div>

        </div>

        <!-- BODY -->
        <div class="success-body">

          <div class="success-icon">
            <i class="ti ti-check"></i>
          </div>

          <h2 style="font-size:28px;margin-bottom:10px;">
            Pembayaran Berhasil
          </h2>

          <p style="color:var(--gray-500);line-height:1.8;">

            Booking lapangan kamu sudah berhasil dikonfirmasi.
            Silakan datang sesuai jadwal yang sudah dipilih dan tunjukkan
            kode booking kepada pemilik GOR saat check-in.

          </p>

          <!-- BOOKING CODE -->
          <div class="booking-code">

            <div>

              <span style="font-size:13px;color:var(--gray-400);display:block;">
                Kode Booking
              </span>

              <strong>
                <?= $kode_booking ?>
              </strong>

            </div>

            <button class="btn btn-outline btn-sm" onclick="copyCode()">

              <i class="ti ti-copy"></i>
              Salin

            </button>

          </div>

          <!-- DETAIL -->
          <div class="detail-list">

            <div class="detail-item">
              <span>Lapangan</span>
              <strong>
                <?= $data['nama_lapangan']; ?>
              </strong>
            </div>

            <div class="detail-item">
              <span>Tanggal</span>
              <strong>
                <?= date(
                  'l, d F Y',
                  strtotime($data['tanggal'])
                ); ?>
              </strong>
            </div>

            <div class="detail-item">
              <span>Jam</span>
              <strong>
                <?= substr($data['jam_mulai'], 0, 5); ?>
                -
                <?= substr($data['jam_selesai'], 0, 5); ?>
              </strong>
            </div>

            <div class="detail-item">
              <span>Durasi</span>
              <strong>
                <?= $durasi ?> Jam
              </strong>
            </div>

            <div class="detail-item">
              <span>Total Pembayaran</span>

              <strong style="color:var(--green);font-size:18px;">
                Rp
                <?= number_format(
                  $data['total'],
                  0,
                  ',',
                  '.'
                ); ?>
              </strong>
            </div>

          </div>

          <!-- BUTTON -->
          <div class="btn-group">

            <a href="riwayat.html">

              <button class="btn btn-primary btn-lg">

                <i class="ti ti-history"></i>
                Lihat Riwayat

              </button>

            </a>

            <a href="index.php">

              <button class="btn btn-outline btn-lg">

                <i class="ti ti-home"></i>
                Kembali ke Beranda

              </button>

            </a>

          </div>

        </div>

      </div>

      <!-- KANAN -->
      <div class="side-card">

        <h3 style="font-size:18px;margin-bottom:18px;">
          Status Booking
        </h3>

        <div class="status-box">

          <i class="ti ti-info-circle"></i>

          <strong style="display:block;margin-bottom:6px;color:var(--blue);">
            Booking Aktif
          </strong>

          <p style="font-size:13px;color:var(--blue);line-height:1.7;margin:0;">

            Datang 15 menit sebelum jadwal bermain dimulai
            untuk proses check-in.

          </p>

        </div>

        <!-- TIMELINE -->
        <div class="timeline">

          <div class="timeline-item">

            <div class="timeline-dot"></div>

            <div>

              <strong>Booking Dibuat</strong>

              <p>
                <?= date(
                  'd M Y H:i',
                  strtotime($data['created_at'])
                ); ?>
                WIB
              </p>

            </div>

          </div>

          <div class="timeline-item">

            <div class="timeline-dot"></div>

            <div>

              <strong>Pembayaran Diverifikasi</strong>

              <p>
                Pembayaran <?= ucfirst($data['metode']); ?>
                berhasil diterima.
              </p>

            </div>

          </div>

          <div class="timeline-item">

            <div class="timeline-dot"></div>

            <div>

              <strong>Siap Digunakan</strong>

              <p>
                Lapangan siap digunakan sesuai jadwal booking.
              </p>

            </div>

          </div>

        </div>

        <div class="summary-divider"></div>

        <!-- OWNER -->
        <h3 style="font-size:16px;margin-bottom:14px;">
          Info Pemilik GOR
        </h3>

        <div class="owner-profile">

          <div class="avatar green">
            <?= strtoupper(substr($data['owner_nama'], 0, 1)); ?>
          </div>

          <div>

            <strong>
              <?= $data['owner_nama']; ?>
            </strong>
            <span style="font-size:13px;color:var(--gray-400);">
              Pemilik GOR
            </span>

          </div>

        </div>

        <div class="summary-divider"></div>

        <div class="owner-info">
          <i class="ti ti-phone"></i>
          <?= $data['telepon']; ?>
        </div>

        <div class="owner-info">
          <i class="ti ti-map-pin"></i>
          <?= $data['alamat']; ?>
        </div>

      </div>

    </div>

  </div>

  <!-- FOOTER -->
  <footer class="footer">

    <strong>SportSpace</strong>

    &nbsp;·&nbsp;

    Booking lapangan olahraga mudah & cepat

    &nbsp;·&nbsp;

    &copy; 2025

  </footer>

  <!-- SCRIPT -->
  <script>

    function copyCode() {

      navigator.clipboard.writeText(
        "<?= $kode_booking ?>"
      );

      alert("Kode booking berhasil disalin!");

    }

  </script>

</body>

</html>