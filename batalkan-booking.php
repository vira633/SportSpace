<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    die("Booking tidak ditemukan.");
}

$booking_id = (int) $_GET['id'];

/* Pastikan booking milik user */
$cek = mysqli_query($conn, "
SELECT *
FROM booking
WHERE booking_id='$booking_id'
AND user_id='$user_id'
");

if (mysqli_num_rows($cek) == 0) {
    die("Akses ditolak.");
}

/* Update status booking */
mysqli_query($conn, "
UPDATE booking
SET status='dibatalkan'
WHERE booking_id='$booking_id'
");

/* Update payment jika ada */
mysqli_query($conn, "
UPDATE payment
SET status='dibatalkan'
WHERE booking_id='$booking_id'
");

/* Notifikasi */
mysqli_query($conn, "
INSERT INTO notifications
(
    user_id,
    booking_id,
    judul,
    isi
)
VALUES
(
    '$user_id',
    '$booking_id',
    'Booking Dibatalkan',
    'Booking telah berhasil dibatalkan.'
)
");

header("Location: riwayat.php");
exit;