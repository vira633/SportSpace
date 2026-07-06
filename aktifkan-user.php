<?php
session_start();
include "config.php";

if(!isset($_GET['id'])){
    header("Location: dashboard-admin.php#section-user");
    exit;
}

$user_id = (int)$_GET['id'];

mysqli_query($conn,"
UPDATE users
SET aktif='aktif'
WHERE user_id='$user_id'
");

header("Location: dashboard-admin.php?notif=user_active#section-user");
exit;
?>