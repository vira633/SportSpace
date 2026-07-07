<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

/* ===========================
   DATA USER
=========================== */

$user = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT *
FROM users
WHERE user_id='$user_id'
"));

/* ===========================
   STATISTIK
=========================== */

$totalBooking = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM booking
WHERE user_id='$user_id'
"))['total'];

$totalMenunggu = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM booking
WHERE user_id='$user_id'
AND (
status='menunggu konfirmasi'
OR status='tertunda'
)
"))['total'];

$totalKonfirmasi = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM booking
WHERE user_id='$user_id'
AND status='terkonfirmasi'
"))['total'];

$totalSelesai = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM booking
WHERE user_id='$user_id'
AND status='selesai'
"))['total'];

$totalBatal = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM booking
WHERE user_id='$user_id'
AND status='dibatalkan'
"))['total'];


$now = date("Y-m-d H:i:s");

mysqli_query($conn, "
UPDATE booking
SET status='selesai'
WHERE status='terkonfirmasi'
AND CONCAT(tanggal,' ',jam_selesai) <= '$now'
");
/* ===========================
   RIWAYAT BOOKING
=========================== */

$query = mysqli_query($conn, "
SELECT

b.*,

f.nama_lapangan,
f.jenis,
f.gambar,
f.lokasi,
f.owner_name,
f.owner_phone

FROM booking b

JOIN fields f
ON b.field_id=f.field_id

WHERE b.user_id='$user_id'

ORDER BY b.booking_id DESC

");
?>

<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Riwayat Booking</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">

  <link rel="stylesheet" href="riwayat.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="index.css?v=<?= time(); ?>">

</head>

<body>

  <nav class="navbar">

    <div class="navbar-brand">
      <i class="ti ti-bowling"></i>
      <span>SportSpace</span>
      <div class="dot"></div>
    </div>

  </nav>

  <div class="container">

    <div class="history-header">

      <div class="left-header">

        <a href="index.php" class="back-btn">

          <i class="ti ti-arrow-left"></i>

        </a>

        <div class="title-area">

          <h1>Riwayat Booking</h1>

          <p>
            Lihat semua aktivitas booking kamu
          </p>

        </div>

      </div>

      <a href="index.php" class="booking-btn">

        <i class="ti ti-plus"></i>

        Booking Baru

      </a>

    </div>


    <div class="toolbar">

      <div class="filter">

        <button class="active" data-filter="semua">
          Semua (<?= $totalBooking ?>)
        </button>

        <button data-filter="menunggu">
          Menunggu (<?= $totalMenunggu ?>)
        </button>

        <button data-filter="terkonfirmasi">
          Terkonfirmasi (<?= $totalKonfirmasi ?>)
        </button>

        <button data-filter="selesai">
          Selesai (<?= $totalSelesai ?>)
        </button>

        <button data-filter="dibatalkan">
          Dibatalkan (<?= $totalBatal ?>)
        </button>

      </div>

    </div>

    <div class="booking-list">

      <?php
      if (mysqli_num_rows($query) == 0) {
        ?>

        <div class="empty">

          <i class="ti ti-calendar-off"></i>

          <h2>Belum Ada Booking</h2>

          <p>Yuk booking lapangan favoritmu.</p>

          <a href="index.php">Booking Sekarang</a>

        </div>

        <?php
      } else {
        while ($row = mysqli_fetch_assoc($query)) {
          $status = strtolower($row['status']);

          $durasi = (strtotime($row['jam_selesai']) - strtotime($row['jam_mulai'])) / 3600;

          if ($status == "menunggu konfirmasi" || $status == "tertunda") {

            $badge = "warning";

          } elseif ($status == "terkonfirmasi") {

            $badge = "success";

          } elseif ($status == "selesai") {

            $badge = "primary";

          } else {

            $badge = "danger";

          }

          ?>

          <div class="booking-card" data-id="<?= $row['booking_id']; ?>" data-status="<?= $status ?>"
            data-name="<?= strtolower($row['nama_lapangan']); ?>" data-date="<?= $row['tanggal']; ?>"
            data-start="<?= $row['jam_mulai']; ?>" data-end="<?= $row['jam_selesai']; ?>">

            <!-- FOTO -->

            <div class="booking-image">

              <img src="<?= $row['gambar']; ?>" alt="<?= $row['nama_lapangan']; ?>">

            </div>

            <!-- KONTEN -->

            <div class="booking-content">

              <!-- HEADER -->

              <div class="booking-top">

                <div>

                  <h2><?= $row['nama_lapangan']; ?></h2>

                  <span class="jenis">

                    <?= $row['jenis']; ?>

                  </span>

                </div>

                <div class="right">

                  <span class="badge <?= $badge ?>">

                    <?= ucfirst($row['status']); ?>

                  </span>

                </div>

              </div>

              <!-- INFO -->

              <div class="booking-info">

                <div>

                  <i class="ti ti-calendar"></i>

                  <?= date("d F Y", strtotime($row['tanggal'])) ?>

                </div>

                <div>

                  <i class="ti ti-clock"></i>

                  <?= substr($row['jam_mulai'], 0, 5) ?>

                  -

                  <?= substr($row['jam_selesai'], 0, 5) ?>

                </div>

                <div>

                  <i class="ti ti-map-pin"></i>

                  <?= $row['lokasi']; ?>

                </div>

                <div>

                  <i class="ti ti-user"></i>

                  <?= $row['owner_name']; ?>

                </div>

                <div>

                  <i class="ti ti-phone"></i>

                  <?= $row['owner_phone']; ?>

                </div>

                <div>

                  <i class="ti ti-ticket"></i>

                  <?= $row['booking_code']; ?>

                </div>

                <div>

                  <i class="ti ti-credit-card"></i>

                  <?= strtoupper($row['metode_pembayaran']); ?>

                </div>

                <div>

                  <i class="ti ti-time-duration-45"></i>

                  <?= $durasi ?> Jam

                </div>

              </div>

              <div class="divider"></div>

              <!-- FOOTER -->

              <div class="booking-footer">

                <div class="footer-price">

                  <small>Total Pembayaran</small>

                  <h4>

                    Rp<?= number_format($row['total'], 0, ',', '.') ?>

                  </h4>

                </div>

                <div class="footer-action">

                  <?php if ($status == "menunggu konfirmasi" || $status == "tertunda") { ?>

                    <a href="reschedule.php?id=<?= $row['booking_id']; ?>" class="btn btn-reschedule">
                      Reschedule
                    </a>
                    <a href="batalkan_booking.php?id=<?= $row['booking_id']; ?>" class="btn btn-cancel"
                      onclick="return confirm('Yakin ingin membatalkan booking?')">

                      Batalkan

                    </a>

                  <?php } ?>


                  <?php if ($status == "selesai") { ?>

                    <a href="ulasan.php?id=<?= $row['booking_id']; ?>" class="btn btn-review">

                      Ulas

                    </a>

                  <?php } ?>

                  <a href="invoice.php?id=<?= $row['booking_id']; ?>&from=riwayat" class="btn btn-detail">

                    Detail Booking

                  </a>

                </div>

              </div>

            </div>

          </div>

          <?php
        } // akhir while
      } // akhir else
      ?>
    </div> <!-- booking-list -->

  </div> <!-- container -->
  <script>

    const buttons = document.querySelectorAll(".filter button");

    const bookingList = document.querySelector(".booking-list");
    const cards = [...document.querySelectorAll(".booking-card")];

    buttons.forEach(btn => {

      btn.onclick = function () {

        buttons.forEach(b => b.classList.remove("active"));
        this.classList.add("active");

        let filter = this.dataset.filter;

        let result = [...cards];

        if (filter == "semua") {

          result.sort((a, b) => {

            return Number(b.dataset.id) - Number(a.dataset.id);

          });

        }

        else if (filter == "menunggu") {

          result = result.filter(card =>

            card.dataset.status == "menunggu konfirmasi"

            ||

            card.dataset.status == "tertunda"

          );

          result.sort((a, b) => {

            let t1 = new Date(a.dataset.date + " " + a.dataset.start);

            let t2 = new Date(b.dataset.date + " " + b.dataset.start);

            return t1 - t2;

          });

        }

        else if (filter == "terkonfirmasi") {

          result = result.filter(card =>

            card.dataset.status == "terkonfirmasi"

          );

          result.sort((a, b) => {

            let t1 = new Date(a.dataset.date + " " + a.dataset.start);

            let t2 = new Date(b.dataset.date + " " + b.dataset.start);

            return t1 - t2;

          });

        }

        else if (filter == "dibatalkan") {

          result = result.filter(card =>

            card.dataset.status == "dibatalkan"

          );

          result.sort((a, b) => {

            let t1 = new Date(a.dataset.date + " " + a.dataset.start);

            let t2 = new Date(b.dataset.date + " " + b.dataset.start);

            return t1 - t2;

          });

        }

        else if (filter == "selesai") {

          result = result.filter(card =>

            card.dataset.status == "selesai"

          );

          result.sort((a, b) => {

            let t1 = new Date(a.dataset.date + " " + a.dataset.end);

            let t2 = new Date(b.dataset.date + " " + b.dataset.end);

            return t2 - t1;

          });

        }

        cards.forEach(card => card.style.display = "none");

        result.forEach(card => {

          card.style.display = "flex";

          bookingList.appendChild(card);

        });

      }

    });
    document.querySelector('.filter button.active').click();
  </script>
</body>

</html>