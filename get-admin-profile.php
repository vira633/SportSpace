<?php
include "config.php";

$queryAdmin = mysqli_query($conn, "
SELECT *
FROM users
WHERE role = 'admin'
LIMIT 1
");

$admin = mysqli_fetch_assoc($queryAdmin);
?>