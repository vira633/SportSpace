<?php

include "config.php";

$queryVerifikasi = mysqli_query(
    $conn,
    "SELECT *
     FROM fields
     WHERE verifikasi='pending'
     ORDER BY field_id DESC"
);