<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  die("Silakan login terlebih dahulu.");
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
  die("Booking tidak ditemukan");
}

$booking_id = (int) $_GET['id'];

// Ambil data booking + info lapangan, sekalian pastiin booking ini emang punya user yang login
$stmt = $conn->prepare("
  SELECT b.*, f.field_id, f.nama_lapangan, f.jenis, f.lokasi, f.gambar, f.harga, f.hari_libur
  FROM booking b
  JOIN fields f ON b.field_id = f.field_id
  WHERE b.booking_id = ? AND b.user_id = ?
");
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$booking) {
  die("Booking tidak ditemukan.");
}

// Reschedule cuma boleh buat booking yang statusnya masih menunggu konfirmasi
$statusBoleh = ['tertunda', 'menunggu konfirmasi'];

if (!in_array(strtolower($booking['status']), $statusBoleh)) {
  die("Booking ini sudah tidak bisa diubah jadwal (status saat ini: " . htmlspecialchars($booking['status']) . ").");
}

$field_id = $booking['field_id'];
$errorMsg = "";

// ================================
// PROSES SUBMIT RESCHEDULE
// ================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $tanggalBaru = $_POST['tanggal'] ?? '';
  $jamMulaiBaru = $_POST['jam_mulai'] ?? '';
  $jamSelesaiBaru = $_POST['jam_selesai'] ?? '';
  $durasiBaru = (int) ($_POST['durasi'] ?? 0);

  if (empty($tanggalBaru) || empty($jamMulaiBaru) || empty($jamSelesaiBaru) || $durasiBaru < 1) {

    $errorMsg = "Silakan pilih tanggal dan jam booking terlebih dahulu.";

  } elseif ($tanggalBaru < date('Y-m-d')) {

    $errorMsg = "Tanggal booking tidak boleh di masa lalu.";

  } else {

    // Cek hari libur di tanggal baru
    $isLiburBaru = false;

    if (!empty($booking['hari_libur'])) {
      $rentang = explode(" s/d ", $booking['hari_libur']);
      $liburMulai = $rentang[0] ?? '';
      $liburSelesai = $rentang[1] ?? '';

      if (!empty($liburMulai) && !empty($liburSelesai) && $tanggalBaru >= $liburMulai && $tanggalBaru <= $liburSelesai) {
        $isLiburBaru = true;
      }
    }

    if ($isLiburBaru) {

      $errorMsg = "Lapangan libur pada tanggal yang dipilih. Silakan pilih tanggal lain.";

    } else {

      // Cek bentrok sama booking lain di lapangan yang sama (kecuali booking ini sendiri)
      $stmtCek = $conn->prepare("
        SELECT booking_id FROM booking
        WHERE field_id = ?
        AND tanggal = ?
        AND status != 'dibatalkan'
        AND booking_id != ?
        AND jam_mulai < ?
        AND jam_selesai > ?
      ");
      $stmtCek->bind_param("issss", $field_id, $tanggalBaru, $booking_id, $jamSelesaiBaru, $jamMulaiBaru);
      $stmtCek->execute();
      $bentrok = $stmtCek->get_result()->num_rows > 0;
      $stmtCek->close();

      if ($bentrok) {

        $errorMsg = "Jam yang dipilih sudah dibooking orang lain. Silakan pilih jam lain.";

      } else {

        $totalBaru = ($durasiBaru * $booking['harga']) + 2500;

        $stmtUpdate = $conn->prepare("
          UPDATE booking
          SET tanggal = ?, jam_mulai = ?, jam_selesai = ?, total = ?
          WHERE booking_id = ? AND user_id = ?
        ");
        $stmtUpdate->bind_param("sssdii", $tanggalBaru, $jamMulaiBaru, $jamSelesaiBaru, $totalBaru, $booking_id, $user_id);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        header("Location: riwayat.php?reschedule=success");
        exit;
      }
    }
  }
}

// ================================
// DATA BUAT RENDER SLOT
// (tanggal yang ditampilkan = tanggal booking sekarang, atau tanggal yang barusan gagal disubmit)
// ================================
$tanggalTampil = $_POST['tanggal'] ?? $booking['tanggal'];

$qBookingLain = $conn->prepare("
  SELECT jam_mulai, jam_selesai FROM booking
  WHERE field_id = ? AND tanggal = ? AND status != 'dibatalkan' AND booking_id != ?
");
$qBookingLain->bind_param("isi", $field_id, $tanggalTampil, $booking_id);
$qBookingLain->execute();
$bookingLainResult = $qBookingLain->get_result()->fetch_all(MYSQLI_ASSOC);
$qBookingLain->close();

$jamPenuh = [];
foreach ($bookingLainResult as $b) {
  $awal = (int) substr($b['jam_mulai'], 0, 2);
  $akhir = (int) substr($b['jam_selesai'], 0, 2);
  for ($i = $awal; $i < $akhir; $i++) {
    $jamPenuh[] = sprintf('%02d:00', $i);
  }
}

// Cek libur buat tanggal yang lagi ditampilkan
$isLiburTampil = false;

if (!empty($booking['hari_libur'])) {
  $rentang = explode(" s/d ", $booking['hari_libur']);
  $liburMulai = $rentang[0] ?? '';
  $liburSelesai = $rentang[1] ?? '';

  if (!empty($liburMulai) && !empty($liburSelesai) && $tanggalTampil >= $liburMulai && $tanggalTampil <= $liburSelesai) {
    $isLiburTampil = true;
  }
}

$durasiSekarang = (int) ((strtotime($booking['jam_selesai']) - strtotime($booking['jam_mulai'])) / 3600);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ubah Jadwal Booking — SportSpace</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="detail.css">
  <link rel="stylesheet" href="reschedule.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap"
    rel="stylesheet">
</head>

<script>
  const slotPrice = <?= $booking['harga']; ?>;
  const selectedSlots = [];

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

    selectedSlots.length = 0;
    document.querySelectorAll(".slot-btn.selected").forEach(btn => {
      selectedSlots.push({ start: btn.dataset.start, end: btn.dataset.end });
    });

    updateSummary();
  }

  function updateSummary() {
    if (selectedSlots.length === 0) {
      document.getElementById("summary-time").innerText = "-";
      document.getElementById("summary-duration").innerText = "0 Jam";
      document.getElementById("summary-total").innerText = "Rp0";
      return;
    }

    const sorted = [...selectedSlots].sort((a, b) => a.start.localeCompare(b.start));
    const first = sorted[0].start;
    const last = sorted[sorted.length - 1].end;

    document.getElementById("jam_mulai").value = first;
    document.getElementById("jam_selesai").value = last;
    document.getElementById("durasi").value = selectedSlots.length;

    document.getElementById("summary-time").innerText = `${first} - ${last}`;
    document.getElementById("summary-duration").innerText = `${selectedSlots.length} Jam`;

    const total = (selectedSlots.length * slotPrice) + 2500;
    document.getElementById("summary-total").innerText = "Rp" + total.toLocaleString("id-ID");
  }

  function disablePastTime() {
    const tanggal = document.getElementById("booking-date-display").value;
    if (tanggal == "") return;

    const today = new Date();
    const selected = new Date(tanggal);

    document.querySelectorAll(".slot-btn").forEach(btn => {
      if (!btn.classList.contains("booked")) {
        btn.disabled = false;
        btn.classList.remove("penuh");
      }
    });

    if (selected.toDateString() != today.toDateString()) return;

    const nowHour = today.getHours();

    document.querySelectorAll(".slot-btn").forEach(btn => {
      const start = parseInt(btn.dataset.start);
      if (start <= nowHour) {
        btn.disabled = true;
        btn.classList.add("penuh");
      }
    });
  }

  window.addEventListener('DOMContentLoaded', function () {
    disablePastTime();
  });
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
      <a href="index.php#lapangan">Lapangan</a>
      <a href="index.php#tentang">Tentang</a>
    </div>
    <div class="navbar-actions">
      <a href="riwayat.php">
        <button class="btn btn-outline btn-sm">Riwayat</button>
      </a>
    </div>
  </nav>

  <div class="back-button">
    <a href="riwayat.php" class="back-link">
      <i class="ti ti-arrow-left"></i>
    </a>
  </div>

  <div class="detail-wrapper">

    <div class="breadcrumb">
      <a href="index.php">Beranda</a>
      <i class="ti ti-chevron-right"></i>
      <a href="riwayat.php">Riwayat</a>
      <i class="ti ti-chevron-right"></i>
      <span style="color:var(--gray-700);">Reschedule</span>
    </div>

    <div class="detail-grid">

      <!-- KIRI -->
      <div class="detail-main">

        <div class="detail-card">
          <div class="detail-image">
            <img src="uploads/fields/<?= $booking['gambar']; ?>" alt="<?= $booking['nama_lapangan']; ?>">
            <div class="detail-overlay"></div>
            <div class="detail-badge">
              <span class="badge badge-amber">Menunggu Konfirmasi</span>
            </div>
          </div>

          <div class="detail-content">
            <div class="detail-title">
              <h1><?= $booking['nama_lapangan']; ?></h1>
              <div class="detail-location">
                <span><i class="ti ti-ball-football"></i> <?= $booking['jenis']; ?></span>
                <span><i class="ti ti-map-pin"></i> <?= $booking['lokasi']; ?></span>
              </div>
            </div>

            <!-- JADWAL SEKARANG -->
            <div class="current-schedule-box">
              <i class="ti ti-calendar-time"></i>
              <div>
                <span class="label">Jadwal saat ini</span>
                <strong>
                  <?= date('l, d F Y', strtotime($booking['tanggal'])); ?>,
                  <?= substr($booking['jam_mulai'], 0, 5); ?> - <?= substr($booking['jam_selesai'], 0, 5); ?>
                  (<?= $durasiSekarang; ?> Jam)
                </strong>
              </div>
            </div>

            <?php if (!empty($errorMsg)): ?>
              <div class="libur-notice" style="background:#fef2f2;color:#dc2626;border-color:#fecaca;">
                <i class="ti ti-alert-circle"></i>
                <?= htmlspecialchars($errorMsg) ?>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- PILIH JADWAL BARU -->
        <div class="section-card">
          <h2>Pilih Jadwal Baru</h2>

          <div style="margin-bottom:24px;">
            <label style="display:block;font-size:14px;font-weight:600;margin-bottom:10px;color:var(--gray-700);">
              Pilih Tanggal Booking
            </label>
            <div class="calendar-input">
              <input type="date" id="booking-date-display" min="<?= date('Y-m-d'); ?>"
                value="<?= htmlspecialchars($tanggalTampil) ?>">
            </div>
          </div>

          <div id="liburNotice" class="libur-notice" style="<?= $isLiburTampil ? 'display:flex;' : 'display:none;' ?>">
            <i class="ti ti-calendar-off"></i>
            Lapangan tutup/libur pada tanggal ini. Silakan pilih tanggal lain.
          </div>

          <div class="slots-grid">
            <?php for ($jam = 6; $jam < 22; $jam++):
              $mulai = sprintf('%02d:00', $jam);
              $selesai = sprintf('%02d:00', $jam + 1);
              $penuh = in_array($mulai, $jamPenuh) || $isLiburTampil;
              ?>
              <button class="slot-btn <?= $penuh ? 'penuh' : '' ?>" id="slot-<?= $mulai ?>"
                <?= $penuh ? 'disabled' : '' ?> onclick="toggleSlot(this)" data-start="<?= $mulai ?>"
                data-end="<?= $selesai ?>">
                <?= str_replace(':', '.', $mulai) ?> - <?= str_replace(':', '.', $selesai) ?>
              </button>
            <?php endfor; ?>
          </div>
        </div>
      </div>

      <!-- KANAN -->
      <div class="detail-sidebar">
        <div class="booking-card">
          <h2 style="font-size:22px;margin-bottom:24px;">Ringkasan Reschedule</h2>

          <div class="summary-row">
            <span>Lapangan</span>
            <strong><?= $booking['nama_lapangan']; ?></strong>
          </div>

          <div class="summary-row">
            <span>Jam Baru</span>
            <strong id="summary-time">-</strong>
          </div>

          <div class="summary-row">
            <span>Durasi</span>
            <strong id="summary-duration">0 Jam</strong>
          </div>

          <div class="summary-divider"></div>

          <div class="summary-row" style="font-size:18px;">
            <span>Total Baru</span>
            <strong id="summary-total">Rp0</strong>
          </div>

          <div class="summary-divider"></div>

          <form method="POST" onsubmit="return cekReschedule();">
            <input type="hidden" id="jam_mulai" name="jam_mulai">
            <input type="hidden" id="jam_selesai" name="jam_selesai">
            <input type="hidden" id="durasi" name="durasi">
            <input type="hidden" id="booking-date" name="tanggal" value="<?= htmlspecialchars($tanggalTampil) ?>">

            <button type="submit" class="btn btn-primary btn-lg btn-full">
              Ubah Jadwal
            </button>
          </form>

          <a href="riwayat.php" style="display:block;margin-top:12px;">
            <button type="button" class="btn btn-outline btn-lg btn-full">Batal</button>
          </a>

          <div class="alert alert-info" style="margin-top:18px;">
            <i class="ti ti-info-circle"></i>
            Jadwal baru akan menggantikan jadwal lama, statusnya tetap menunggu konfirmasi.
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

  <script>
    const bookingDate = document.getElementById("booking-date-display");

    bookingDate.addEventListener("change", function () {

      document.getElementById("booking-date").value = this.value;

      fetch("cek-jadwal.php?field_id=<?= $field_id ?>&tanggal=" + this.value + "&exclude_id=<?= $booking_id ?>")
        .then(res => res.json())
        .then(data => {

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

            liburNotice.style.display = "flex";

            document.querySelectorAll(".slot-btn").forEach(btn => {
              btn.classList.add("penuh");
              btn.disabled = true;
            });

          } else {

            liburNotice.style.display = "none";

            data.penuh.forEach(jam => {
              const btn = document.getElementById("slot-" + jam);
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

    function cekReschedule() {
      const tanggal = document.getElementById("booking-date").value;
      const jam = document.getElementById("jam_mulai").value;

      if (tanggal === "" || jam === "") {
        alert("Silakan pilih tanggal dan jam booking terlebih dahulu!");
        return false;
      }

      return confirm("Yakin ingin mengubah jadwal booking ini?");
    }
  </script>

</body>

</html>