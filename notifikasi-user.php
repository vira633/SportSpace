<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* tandai semua sudah dibaca */
mysqli_query($conn, "
UPDATE user_notifications
SET status='dibaca'
WHERE user_id='$user_id'
");

$query = mysqli_query($conn, "
SELECT *
FROM user_notifications
WHERE user_id='$user_id'
ORDER BY notification_id DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Pemberitahuan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <link rel="stylesheet" href="notif.css">

</head>



<body>

    <nav class="navbar">

        <a href="index.php" class="navbar-brand">
            <i class="ti ti-bowling"></i>
            <span>SportSpace</span>
            <div class="dot"></div>
        </a>

    </nav>

    <div class="container">
        <div class="header">

            <a href="index.php" class="back">

                <i class="ti ti-arrow-left"></i>

            </a>

            <h2>Pemberitahuan</h2>

        </div>

        <?php

        if (mysqli_num_rows($query) == 0) {

            ?>

            <div class="empty">

                <i class="ti ti-bell-off"></i>

                <h3>Belum ada pemberitahuan</h3>

                <p>Notifikasi akan muncul di sini.</p>

            </div>

            <?php

        } else {

            while ($n = mysqli_fetch_assoc($query)) {

                $icon = "ti ti-bell";
                $warna = "green";
                $link = "#";
        

                switch ($n['jenis']) {

                    case "chat":
                        $icon = "ti ti-message-circle";
                        $warna = "blue";
                       $link = "chat.php?field_id=" . $n['field_id'] . "&from=notif";
                        break;

                    case "booking_dibuat":
                        $icon = "ti ti-calendar-event";
                        $link = "riwayat.php?booking=" . $n['booking_id'] . "&from=notif";
                        break;

                    case "booking_diterima":

                        $icon = "ti ti-circle-check";
                        $warna = "green";
                       $link = "riwayat.php?booking=" . $n['booking_id'] . "&from=notif";

                        break;

                    case "booking_dibatalkan":

                        $icon = "ti ti-circle-x";
                        $warna = "red";
                        $link = "riwayat.php?booking=" . $n['booking_id'] . "&from=notif";

                        break;

                    case "pembayaran_diterima":
                        $icon = "ti ti-credit-card";
                        $link = "invoice.php?field_id=" . $n['field_id'] . "&booking_id=" . $n['booking_id'];
                        break;

                    case "pembayaran_ditolak":
                        $icon = "ti ti-alert-circle";
                        $warna = "red";
                        $link = "invoice.php?field_id=" . $n['field_id'] . "&booking_id=" . $n['booking_id'];
                        break;
                }

                ?>

                <a href="<?= $link ?>" class="card">

                    <div class="icon <?= $warna ?>">

                        <i class="<?= $icon ?>"></i>

                    </div>

                    <div class="content">

                        <h4><?= $n['judul']; ?></h4>

                        <p><?= $n['isi']; ?></p>

                        <span><?= date("d M Y H:i", strtotime($n['created_at'])); ?></span>

                    </div>

                </a>

                <?php

            }

        }

        ?>
</body>

</html>