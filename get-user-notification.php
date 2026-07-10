<?php
session_start();
include "config.php";

header("Content-Type: application/json");

if(!isset($_SESSION['user_id'])){
    echo json_encode(["total"=>0]);
    exit;
}

$user_id=$_SESSION['user_id'];

$q=mysqli_query($conn,"
SELECT COUNT(*) total
FROM user_notifications
WHERE user_id='$user_id'
AND status='belum'
");

$row=mysqli_fetch_assoc($q);

echo json_encode([
"total"=>(int)$row['total']
]);