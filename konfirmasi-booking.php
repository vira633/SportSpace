<?php
session_start();

include "config.php";

$id = $_GET['id'];

mysqli_query(
    $conn,
    "UPDATE booking
    SET status='terkonfirmasi'
    WHERE booking_id='$id'"
);

$_SESSION['open_section'] = "booking";
$_SESSION['toast'] = "Booking berhasil dikonfirmasi.";

header("Location: dashboard-owner.php");
exit;