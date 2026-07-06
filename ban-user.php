<?php
session_start();
include "config.php";

// Pastikan ada ID
if (!isset($_GET['id'])) {
    header("Location: dashboard-admin.php#section-user");
    exit;
}

$user_id = (int) $_GET['id'];

// Jangan sampai admin memban dirinya sendiri
if ($user_id == $_SESSION['user_id']) {
    header("Location: dashboard-admin.php?error=selfban#section-user");
    exit;
}

// Ubah status menjadi nonaktif
$query = mysqli_query($conn, "
    UPDATE users
    SET aktif='nonaktif'
    WHERE user_id='$user_id'
");

header("Location: dashboard-admin.php?notif=user_banned#section-user");
exit;
?>