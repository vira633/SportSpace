<?php
session_start();
include "config.php";

if(isset($_GET['id']) && isset($_GET['status'])){

    $booking_id = (int) $_GET['id'];
    $status     = mysqli_real_escape_string($conn, $_GET['status']);

    $query = mysqli_query($conn, "
    UPDATE booking
    SET
        status='$status',
        created_at=NOW()
    WHERE booking_id='$booking_id'
    ");

    if($status == "terkonfirmasi"){
        $_SESSION['success'] = "Booking berhasil dikonfirmasi.";
    }
    elseif($status == "dibatalkan"){
        $_SESSION['success'] = "Booking berhasil ditolak.";
    }
}

header("Location: dashboard-owner.php");
exit;