<?php
session_start();

include "config.php";

$id = (int) $_GET['id'];

/* Update status booking */
mysqli_query($conn,"
UPDATE booking
SET status='terkonfirmasi'
WHERE booking_id='$id'
");

/* Ambil data booking */
$q = mysqli_query($conn,"
SELECT user_id, field_id
FROM booking
WHERE booking_id='$id'
");

$data = mysqli_fetch_assoc($q);

if($data){

    $user_id = $data['user_id'];
    $field_id = $data['field_id'];

    /* Simpan notifikasi */
    mysqli_query($conn,"
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
        'booking_diterima',
        'Booking Diterima',
        'Booking Anda telah diterima oleh owner.'
    )
    ");

}

$_SESSION['open_section'] = "booking";
$_SESSION['toast'] = "Booking berhasil dikonfirmasi.";

header("Location: dashboard-owner.php");
exit;