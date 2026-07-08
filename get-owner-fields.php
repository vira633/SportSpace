<?php
include "config.php";

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$owner_id = $_SESSION['owner_id'] ?? 0;

$queryFields = mysqli_query(
    $conn,
    "SELECT *
    FROM fields
    WHERE owner_id='$owner_id'
    ORDER BY field_id ASC"
);

$queryInfo = mysqli_query(
    $conn,
    "SELECT *
    FROM fields
    WHERE owner_id='$owner_id'
    ORDER BY field_id ASC
    LIMIT 1"
);

$queryTotal = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM fields
WHERE owner_id='$owner_id'
");

$dataTotal = mysqli_fetch_assoc($queryTotal);

$queryAktif = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM fields
WHERE owner_id='$owner_id'
AND aktif='aktif'
");

$dataAktif = mysqli_fetch_assoc($queryAktif);

$queryNonaktif = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM fields
WHERE owner_id='$owner_id'
AND aktif='nonaktif'
");

$dataNonaktif = mysqli_fetch_assoc($queryNonaktif);

$queryHarga = mysqli_query($conn,"
SELECT IFNULL(AVG(harga),0) AS rata
FROM fields
WHERE owner_id='$owner_id'
AND aktif='aktif'
");

$dataHarga = mysqli_fetch_assoc($queryHarga);

$info = mysqli_fetch_assoc($queryInfo);
?>