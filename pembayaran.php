<?php
include 'config.php';

$field_id = $_POST['field_id'];

$tanggal = $_POST['tanggal'];

$jam_mulai = $_POST['jam_mulai'];

$jam_selesai = $_POST['jam_selesai'];

$durasi = $_POST['durasi'];

$field = mysqli_fetch_assoc(
  mysqli_query($conn, "
SELECT *
FROM fields
WHERE field_id='$field_id'
")
);

$biaya_admin = 2500;

$total =
  ($durasi * $field['harga'])
  +
  $biaya_admin;
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Pembayaran Booking — SportSpace</title>

  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="detail.css">
  <link rel="stylesheet" href="pembayaran.css">

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
      <a href="#" class="active">Pembayaran</a>
    </div>

    <div class="navbar-actions">

      <a href="riwayat.html">
        <button class="btn btn-outline btn-sm">
          Riwayat
        </button>
      </a>

    </div>

  </nav>

  <!-- BACK -->
  <div class="back-button">

    <a href="detail.php?id=<?= $field['field_id'] ?>">
      <i class="ti ti-arrow-left"></i>
    </a>

  </div>

  <!-- WRAPPER -->
  <div class="payment-wrapper">

    <div class="payment-grid">

      <!-- LEFT -->
      <div>

        <!-- DETAIL BOOKING -->
        <div class="payment-card">

          <div class="payment-header">

            <h2>Detail Booking</h2>

            <span class="badge badge-green">
              Menunggu Pembayaran
            </span>

          </div>

          <div class="field-info">

            <img src="<?= $field['gambar']; ?>">

            <div>

              <h3><?= $field['nama_lapangan']; ?></h3>

              <p>
                <i class="ti ti-map-pin"></i>
                <?= $field['lokasi']; ?>
              </p>

            </div>

          </div>

          <div class="summary-list">

            <div class="summary-item">
              <span>Tanggal</span>
              <strong>
                <?= date('d F Y', strtotime($tanggal)); ?>
              </strong>
            </div>

            <div class="summary-item">
              <span>Jam Main</span>
              <strong>
                <?= substr($jam_mulai, 0, 5); ?>
                -
                <?= substr($jam_selesai, 0, 5); ?>
              </strong>
            </div>

            <div class="summary-item">
              <span>Durasi</span>
              <strong><?= $durasi ?> Jam</strong>
            </div>

            <div class="summary-item">
              <span>Harga / Jam</span>
              <strong>
                Rp<?= number_format($field['harga'], 0, ',', '.'); ?>
              </strong>
            </div>

            <div class="summary-item">
              <span>Biaya Admin</span>
              <strong>Rp2.500</strong>
            </div>

            <div class="summary-item total">
              <span>Total Pembayaran</span>
              <strong>
                Rp<?= number_format($total, 0, ',', '.'); ?>
              </strong>
            </div>

          </div>

        </div>

        <!-- METODE -->
        <div class="payment-card">

          <div class="payment-header">
            <h2>Pilih Metode Pembayaran</h2>
          </div>

          <div class="method-list">

            <!-- QRIS -->
            <div class="method-card active" onclick="selectPayment('qris', this)">

              <div class="method-left">

                <i class="ti ti-qrcode"></i>

                <div>
                  <strong>QRIS</strong>
                  <p>Scan QR dengan semua e-wallet</p>
                </div>

              </div>

            </div>

            <!-- TRANSFER -->
            <div class="method-card" onclick="selectPayment('transfer', this)">

              <div class="method-left">

                <i class="ti ti-building-bank"></i>

                <div>
                  <strong>Transfer Bank</strong>
                  <p>BCA, BRI, Mandiri, BNI</p>
                </div>

              </div>

            </div>

            <!-- GOPAY -->
            <div class="method-card" onclick="selectPayment('gopay', this)">

              <div class="method-left">

                <i class="ti ti-wallet"></i>

                <div>
                  <strong>GoPay</strong>
                  <p>Pembayaran instant GoPay</p>
                </div>

              </div>

            </div>

            <!-- DANA -->
            <div class="method-card" onclick="selectPayment('dana', this)">

              <div class="method-left">

                <i class="ti ti-wallet"></i>

                <div>
                  <strong>DANA</strong>
                  <p>Bayar menggunakan DANA</p>
                </div>

              </div>

            </div>

            <!-- SHOPEEPAY -->
            <div class="method-card" onclick="selectPayment('shopeepay', this)">

              <div class="method-left">

                <i class="ti ti-wallet"></i>

                <div>
                  <strong>ShopeePay</strong>
                  <p>Pembayaran via ShopeePay</p>
                </div>

              </div>

            </div>

            <!-- CASH -->
            <div class="method-card" onclick="selectPayment('cash', this)">

              <div class="method-left">

                <i class="ti ti-cash"></i>

                <div>
                  <strong>Bayar di Tempat</strong>
                  <p>Pembayaran langsung ke pemilik</p>
                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

      <!-- RIGHT -->
      <div class="sticky-card">

        <div class="payment-card">

          <div class="payment-header">
            <h2>Instruksi Pembayaran</h2>
          </div>

          <!-- TIMER -->
          <div class="payment-timer">

            <span>Selesaikan pembayaran dalam</span>

            <strong id="countdown">
              15:00
            </strong>

          </div>

          <!-- QRIS -->
          <div id="payment-qris" class="payment-content active">
            <div class="pay-banner">

              <i class="ti ti-shield-check"></i>

              <span>
                Pembayaran aman & terenkripsi
              </span>

            </div>
            <div class="qr-box">

              <img id="qris-image" src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=SPORTSPACE-QRIS"
                alt="QRIS">

            </div>

            <div class="pay-info">

              <span>Total Bayar</span>

              <strong>Rp162.500</strong>

            </div>

            <p class="pay-note">
              Scan QR menggunakan aplikasi e-wallet atau mobile banking.
            </p>

            <div class="qr-actions">

              <button type="button" class="pay-action-btn" onclick="downloadQR()">

                <i class="ti ti-download"></i>
                Download QR

              </button>


            </div>

          </div>

          <!-- TRANSFER -->
          <div id="payment-transfer" class="payment-content">

            <div class="bank-box">

              <div class="bank-item">

                <span>Bank</span>

                <strong>BCA</strong>

              </div>

              <div class="bank-item">

                <span>No Rekening</span>

                <strong>

                  1234567890

                  <button class="copy-btn" onclick="copyText('1234567890')">

                    Salin

                  </button>

                </strong>

              </div>

              <div class="bank-item">

                <span>Atas Nama</span>

                <strong>Bapak Suharto</strong>

              </div>

            </div>

          </div>

          <!-- GOPAY -->
          <div id="payment-gopay" class="payment-content">

            <div class="wallet-box">

              <h3>No GoPay</h3>

              <strong>

                0812-3456-7890

              </strong>

              <button class="copy-btn" onclick="copyText('081234567890')">

                Salin Nomor

              </button>

            </div>

          </div>

          <!-- DANA -->
          <div id="payment-dana" class="payment-content">

            <div class="wallet-box">

              <h3>No DANA</h3>

              <strong>

                0812-3456-7890

              </strong>

              <button class="copy-btn" onclick="copyText('081234567890')">

                Salin Nomor

              </button>

            </div>

          </div>

          <!-- SHOPEEPAY -->
          <div id="payment-shopeepay" class="payment-content">

            <div class="wallet-box">

              <h3>No ShopeePay</h3>

              <strong>

                0812-3456-7890

              </strong>

              <button class="copy-btn" onclick="copyText('081234567890')">

                Salin Nomor

              </button>

            </div>

          </div>

          <!-- CASH -->
          <div id="payment-cash" class="payment-content">

            <div class="cash-box">

              <i class="ti ti-info-circle"></i>

              <p>
                Pembayaran dilakukan langsung saat datang ke lokasi GOR.
              </p>

            </div>

          </div>

          <!-- BUTTON -->
          <form action="proses-pembayaran.php" method="POST">

            <input type="hidden" name="field_id" value="<?= $field_id ?>">

            <input type="hidden" name="tanggal" value="<?= $tanggal ?>">

            <input type="hidden" name="jam_mulai" value="<?= $jam_mulai ?>">

            <input type="hidden" name="jam_selesai" value="<?= $jam_selesai ?>">

            <input type="hidden" name="durasi" value="<?= $durasi ?>">

            <input type="hidden" name="total" value="<?= $total ?>">

            <input type="hidden" id="metode" name="metode" value="qris">

            <button id="pay-button" type="submit" class="btn btn-primary btn-lg btn-full">

              Saya Sudah Bayar

            </button>

          </form>

          </form>

        </div>

      </div>

    </div>

  </div>

  <!-- TOAST -->
  <div id="toast" class="toast">
    Berhasil disalin
  </div>

  <!-- SUCCESS MODAL -->
  <div id="success-modal" class="success-modal">

    <div class="success-box">

      <div class="success-icon">
        <i class="ti ti-check"></i>
      </div>

      <h2>Pembayaran Berhasil</h2>

      <p>
        Booking kamu berhasil dikonfirmasi.
      </p>

      <a href="booking-success.html" class="btn btn-primary btn-full">

        Lihat Detail Booking

      </a>

      <button onclick="closeModal()" class="btn btn-outline btn-full">

        Tutup

      </button>

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

    // SELECT PAYMENT
    function selectPayment(type, element) {


      document.getElementById("metode").value = type;
      document
        .querySelectorAll('.method-card')
        .forEach(card => {
          card.classList.remove('active');
        });

      element.classList.add('active');

      document
        .querySelectorAll('.payment-content')
        .forEach(content => {
          content.classList.remove('active');
        });

      document
        .getElementById('payment-' + type)
        .classList.add('active');

      // BUTTON TEXT
      const btn =
        document.getElementById('pay-button');

      if (type === 'cash') {

        btn.innerHTML =
          'Konfirmasi Booking';

      } else {

        btn.innerHTML =
          'Saya Sudah Bayar';

      }

    }

    // COPY
    function copyText(text) {

      navigator.clipboard.writeText(text);

      showToast("Berhasil disalin");

    }

    // DOWNLOAD QR
    function downloadQR() {

      const qr =
        document.getElementById("qris-image").src;

      const link =
        document.createElement("a");

      link.href = qr;

      link.download =
        "QRIS-SportSpace.png";

      link.click();

    }

    // TOAST
    function showToast(message) {

      const toast =
        document.getElementById("toast");

      toast.innerText = message;

      toast.classList.add("show");

      setTimeout(() => {

        toast.classList.remove("show");

      }, 2200);

    }

    // SUCCESS MODAL
    function confirmPayment() {

      document
        .getElementById("success-modal")
        .classList.add("active");

    }

    // CLOSE MODAL
    function closeModal() {

      document
        .getElementById("success-modal")
        .classList.remove("active");

    }

    // COUNTDOWN
    let time = 900;

    const countdown =
      document.getElementById("countdown");

    setInterval(() => {

      let minutes =
        Math.floor(time / 60);

      let seconds =
        time % 60;

      seconds =
        seconds < 10
          ? "0" + seconds
          : seconds;

      countdown.innerText =
        `${minutes}:${seconds}`;

      if (time > 0) {
        time--;
      }

    }, 1000);

    function downloadQR() {

      const qr =
        document.getElementById('qrisImage');

      const imageUrl = qr.src;

      fetch(imageUrl)
        .then(response => response.blob())
        .then(blob => {

          const blobUrl =
            window.URL.createObjectURL(blob);

          const link =
            document.createElement('a');

          link.href = blobUrl;

          link.download = 'QRIS-SportSpace.png';

          document.body.appendChild(link);

          link.click();

          document.body.removeChild(link);

          window.URL.revokeObjectURL(blobUrl);

          showToast('QR berhasil diunduh');

        });

    }

  </script>

</body>

</html>