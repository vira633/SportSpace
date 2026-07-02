<?php

include "config.php";

$filter = $_GET['filter'] ?? 'pending';

$where = "";

if($filter != "semua"){
    $where = "WHERE fields.verifikasi='$filter'";
}

$queryVerifikasi = mysqli_query($conn,"
SELECT
    fields.*,
    owners.nama AS owner_name,
    owners.telepon,
    owners.alamat

FROM fields

LEFT JOIN owners
ON owners.field_id = fields.field_id

$where

ORDER BY fields.field_id DESC
");

if(!$queryVerifikasi){
    die(mysqli_error($conn));
}