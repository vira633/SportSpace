<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['total' => 0]);
    exit;
}

$user_id  = (int) $_SESSION['user_id'];
$field_id = (int) ($_GET['field_id'] ?? 0);

$q = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM chat
WHERE user_id = '$user_id'
AND field_id = '$field_id'
AND sender = 'admin'
AND status = 'belum'
");

$row = mysqli_fetch_assoc($q);

echo json_encode(['total' => (int) $row['total']]);