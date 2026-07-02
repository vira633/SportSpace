<?php

include "config.php";

$id = $_GET['id'];

mysqli_query(
    $conn,
    "UPDATE booking
    SET status='dibatalkan'
    WHERE booking_id='$id'"
);

$_SESSION['open_section'] = "booking";
$_SESSION['toast'] = "Booking berhasil ditolak.";

header("Location: dashboard-owner.php");
exit;