<?php
include "config.php";

$query = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking
WHERE status='tertunda'
");

$data = mysqli_fetch_assoc($query);

echo json_encode([
    "total" => (int)$data['total']
]);