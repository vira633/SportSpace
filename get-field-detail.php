<?php
include "config.php";

if (!isset($_GET['id'])) {
    exit;
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "
    SELECT *
    FROM fields
    WHERE field_id = $id
");

$data = mysqli_fetch_assoc($query);

echo json_encode($data);