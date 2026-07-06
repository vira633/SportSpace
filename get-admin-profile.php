<?php
include "config.php";

$idAdmin = $_SESSION['user_id'];

$queryAdmin = mysqli_query($conn,"
SELECT *
FROM users
WHERE user_id = '$idAdmin'
");

$admin = mysqli_fetch_assoc($queryAdmin);
?>