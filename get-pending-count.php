<?php
session_start();
include "config.php";

$user_id = $_SESSION['user_id'];

// Ambil owner_id dari user yang login
$qOwner = mysqli_query($conn, "
    SELECT owner_id
    FROM owners
    WHERE user_id='$user_id'
    LIMIT 1
");

$owner = mysqli_fetch_assoc($qOwner);
$owner_id = $owner['owner_id'] ?? 0;

// Hitung booking pending milik owner tersebut
$query = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM booking b
    JOIN fields f ON b.field_id = f.field_id
    WHERE b.status='tertunda'
    AND f.owner_id='$owner_id'
");

$data = mysqli_fetch_assoc($query);

echo json_encode([
    "total" => (int)$data['total']
]);