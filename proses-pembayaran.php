<?php

session_start();

include 'config.php';

$user_id = $_SESSION['user_id'];

$field_id = $_POST['field_id'];
$tanggal = $_POST['tanggal'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];
$total = $_POST['total'];
$metode = $_POST['metode'];

$cek = mysqli_query($conn, "
SELECT *
FROM booking
WHERE field_id='$field_id'
AND tanggal='$tanggal'
AND status!='dibatalkan'
AND (
    ('$jam_mulai' >= jam_mulai AND '$jam_mulai' < jam_selesai)
    OR
    ('$jam_selesai' > jam_mulai AND '$jam_selesai' <= jam_selesai)
    OR
    (jam_mulai >= '$jam_mulai' AND jam_selesai <= '$jam_selesai')
)
");


$status_booking = ($metode == "cash")
    ? "terkonfirmasi"
    : "menunggu_verifikasi";

$sql = "
INSERT INTO booking
(
    user_id,
    field_id,
    tanggal,
    jam_mulai,
    jam_selesai,
    status
)
VALUES
(
    '$user_id',
    '$field_id',
    '$tanggal',
    '$jam_mulai',
    '$jam_selesai',
    '$status_booking'
)
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Booking Error: ' . mysqli_error($conn));
}

/* AMBIL ID BOOKING BARU */
$booking_id = mysqli_insert_id($conn);
$booking_code =
    "SS-" .
    date('Y') .
    "-" .
    str_pad(
        $booking_id,
        5,
        "0",
        STR_PAD_LEFT
    );
mysqli_query($conn, "
UPDATE booking
SET booking_code='$booking_code'
WHERE booking_id='$booking_id'
");
$sqlPayment = "
INSERT INTO payment
(
booking_id,
metode,
total,
status
)
VALUES
(
'$booking_id',
'$metode',
'$total',
'tertunda'
)
";

$result2 = mysqli_query($conn, $sqlPayment);


if (!$result2) {
    die('Payment Error: ' . mysqli_error($conn));
}
/* ===========================
   SIMPAN NOTIFIKASI
=========================== */

if ($metode == "cash") {

    $judul = "Booking Berhasil Dibuat";

    $isi = "Booking berhasil dibuat. Silakan lakukan pembayaran saat tiba di lokasi sesuai jadwal.";

} else {

    $judul = "Konfirmasi Pembayaran Diterima";

    $isi = "Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.";

}

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
    '$judul',
    '$isi'
)
");
header('Location: booking-success.php?id=' . $booking_id);
exit;