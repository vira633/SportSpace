<?php

include "config.php";

$filter = $_GET['filter'] ?? 'pending';

$where = "";

if($filter != "semua"){
    $where = "WHERE f.verifikasi='$filter'";
}

$totalSemua = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) total FROM fields")
)['total'];

$totalPending = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) total FROM fields WHERE verifikasi='pending'")
)['total'];

$totalDiterima = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) total FROM fields WHERE verifikasi='diterima'")
)['total'];

$totalDitolak = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) total FROM fields WHERE verifikasi='ditolak'")
)['total'];

$queryVerifikasi = mysqli_query($conn,"
SELECT
    f.*,
    u.nama AS nama_owner
FROM fields f
LEFT JOIN users u
ON f.owner_id = u.user_id

$where

ORDER BY f.field_id DESC
");

if(!$queryVerifikasi){
    die(mysqli_error($conn));
}