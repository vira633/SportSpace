<?php
include "config.php";

header("Content-Type: application/json");

// Lapangan pending
$qLapangan = mysqli_query($conn,"
SELECT COUNT(*) total
FROM fields
WHERE verifikasi='pending'
");
$lapangan = mysqli_fetch_assoc($qLapangan)['total'];

// Booking hari ini
$qBooking = mysqli_query($conn,"
SELECT COUNT(*) total
FROM booking
WHERE DATE(created_at)=CURDATE()
");
$booking = mysqli_fetch_assoc($qBooking)['total'];

// User baru hari ini
$qUser = mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
WHERE DATE(created_at)=CURDATE()
");
$user = mysqli_fetch_assoc($qUser)['total'];

echo json_encode([
    "lapangan"=>$lapangan,
    "booking"=>$booking,
    "user"=>$user,
    "total"=>$lapangan+$booking+$user
]);