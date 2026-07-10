<?php

include "config.php";

$id = $_GET['id'];

mysqli_query(
    $conn,
    "UPDATE booking
    SET status='dibatalkan'
    WHERE booking_id='$id'"
);

/* ambil data booking */
$q = mysqli_query($conn, "
SELECT user_id, field_id
FROM booking
WHERE booking_id='$id'
");

$data = mysqli_fetch_assoc($q);

$user_id = $data['user_id'];
$field_id = $data['field_id'];

$_SESSION['open_section'] = "booking";
$_SESSION['toast'] = "Booking berhasil dibatalkan.";

mysqli_query($conn, "
INSERT INTO user_notifications
(
    user_id,
    booking_id,
    field_id,
    jenis,
    judul,
    isi
)
VALUES
(
    '$user_id',
    '$id',
    '$field_id',
    'booking_dibatalkan',
    'Booking Dibatalkan',
    'Maaf, booking Anda dibatalkan oleh owner.'
)
");

header("Location: dashboard-owner.php");
exit;