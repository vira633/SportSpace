<?php
header('Content-Type: application/json');

session_start();
include "config.php";

if (!isset($_GET['id'])) {
    header("Location: dashboard-owner.php?section=lapangan");
    exit;
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "SELECT aktif FROM fields WHERE field_id = $id");

if (mysqli_num_rows($query) > 0) {

    $field = mysqli_fetch_assoc($query);

    $statusBaru = ($field['aktif'] == 'aktif') ? 'nonaktif' : 'aktif';

    mysqli_query($conn, "UPDATE fields SET aktif='$statusBaru' WHERE field_id=$id");

    echo json_encode([
        "success" => true,
        "status" => $statusBaru
    ]);

    exit;
}

echo json_encode([
    "success" => false
]);