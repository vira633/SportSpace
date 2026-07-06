<?php

include "config.php";

$id = $_GET['id'];

mysqli_query(
    $conn,
    "UPDATE fields
    SET verifikasi='diterima'
    WHERE field_id='$id'"
);

header("Location: dashboard-admin.php?notif=approve#section-venue");
exit;