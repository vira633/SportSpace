<?php
session_start();
include 'config.php';

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
   TOTAL FAVORITE
=========================== */

$totalFavorite = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM favorites
WHERE user_id='$user_id'
"))['total'];

/* ===========================
   DATA FAVORITE
=========================== */

$query = mysqli_query($conn, "
SELECT

fav.favorite_id,

f.*

FROM favorites fav

JOIN fields f
ON fav.field_id=f.field_id

WHERE fav.user_id='$user_id'

ORDER BY fav.favorite_id DESC
");

$from = $_GET['from'] ?? 'index';
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lapangan Favorit</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.31.0/dist/tabler-icons.min.css">
    
    <link rel="stylesheet" href="index.css?v=<?= time(); ?>">

    <link rel="stylesheet" href="favorite.css?v=<?= time(); ?>">

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
        <div class="history-header">

            <div class="left-header">

                <?php
                if ($from == "favorite") {

                    $backLink = "favorite.php";

                } elseif ($from == "riwayat") {

                    $backLink = "riwayat.php";

                } else {

                    $backLink = "index.php";

                }
                ?>

                <a href="<?= $backLink ?>" class="back-btn">
                    <i class="ti ti-arrow-left"></i>
                </a>

                <div class="title-area">

                    <h1>Lapangan Favorit</h1>

                    <p>

                        Semua lapangan yang sudah kamu simpan.

                    </p>

                </div>

            </div>

        </div>

        <div class="summary-card">

            <div class="summary-item">

                <i class="ti ti-heart-filled"></i>

                <h3><?= $totalFavorite ?></h3>

                <span>Lapangan Favorit</span>

            </div>

            <div class="summary-item">

                <i class="ti ti-map-2"></i>

                <h3>SportSpace</h3>

                <span>Wishlist Saya</span>

            </div>

        </div>
        <div class="favorite-list">

            <?php

            if (mysqli_num_rows($query) == 0) {

                ?>

                <div class="empty">

                    <i class="ti ti-heart-off"></i>

                    <h2>

                        Belum Ada Favorit

                    </h2>

                    <p>

                        Tambahkan lapangan favoritmu.

                    </p>

                    <a href="index.php">

                        Cari Lapangan

                    </a>

                </div>

                <?php

            } else {

                while ($row = mysqli_fetch_assoc($query)) {

                    ?>

                    <div class="favorite-card" data-name="<?= strtolower($row['nama_lapangan']); ?>">

                        <div class="favorite-image">

                            <img src="<?= $row['gambar']; ?>" alt="<?= $row['nama_lapangan']; ?>">

                            <button class="love active" data-id="<?= $row['field_id']; ?>">

                                <i class="ti ti-heart-filled"></i>

                            </button>

                        </div>

                        <div class="favorite-content">

                            <div class="favorite-top">

                                <div>

                                    <h2><?= $row['nama_lapangan']; ?></h2>

                                    <span><?= $row['jenis']; ?></span>

                                </div>

                                <h3>

                                    Rp<?= number_format($row['harga'], 0, ',', '.'); ?>

                                    <small>/jam</small>

                                </h3>

                            </div>

                            <div class="favorite-info">

                                <div>

                                    <i class="ti ti-map-pin"></i>

                                    <?= $row['lokasi']; ?>

                                </div>

                                <div>

                                    <i class="ti ti-user"></i>

                                    <?= $row['owner_name']; ?>

                                </div>

                                <div>

                                    <i class="ti ti-clock"></i>

                                    <?= $row['jam_operasional']; ?>

                                </div>

                            </div>

                            <div class="favorite-action">

                                <a href="detail.php?id=<?= $row['field_id']; ?>&from=favorite" class="btn-detail">
                                    Detail
                                </a>

                            </div>
                        </div>

                    </div>

                    <?php
                }
            } // akhir else
            ?>

        </div> <!-- favorite-list -->

    </div> <!-- container -->

    <!-- CARD DIMULAI DISINI -->
</body>

</html>