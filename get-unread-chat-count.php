<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['owner_id'])) {
    echo json_encode(['total' => 0]);
    exit;
}

$owner_id = (int) $_SESSION['owner_id'];

$q = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM chat c
JOIN fields f ON c.field_id = f.field_id
WHERE f.owner_id = '$owner_id'
AND c.sender = 'user'
AND c.status = 'belum'
");

$row = mysqli_fetch_assoc($q);

echo json_encode(['total' => (int) $row['total']]);