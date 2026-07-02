<?php
include "config.php";

$queryFields = mysqli_query(
    $conn,
    "SELECT *
    FROM fields
    ORDER BY field_id ASC"
);

$queryInfo = mysqli_query(
    $conn,
    "SELECT *
    FROM fields
    ORDER BY field_id ASC
    LIMIT 1"
);

$queryTotal = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM fields
");

$dataTotal = mysqli_fetch_assoc($queryTotal);

$queryAktif = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM fields
WHERE aktif='aktif'
");

$dataAktif = mysqli_fetch_assoc($queryAktif);

$queryNonaktif = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM fields
WHERE aktif='nonaktif'
");

$dataNonaktif = mysqli_fetch_assoc($queryNonaktif);

$queryHarga = mysqli_query($conn,"
SELECT IFNULL(AVG(harga),0) AS rata
FROM fields
WHERE aktif='aktif'
");

$dataHarga = mysqli_fetch_assoc($queryHarga);

$info = mysqli_fetch_assoc($queryInfo);
?>