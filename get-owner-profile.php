<?php

include "config.php";

$userId = $_SESSION['user_id'] ?? 0;

$queryProfil = mysqli_query($conn,"
    SELECT *
    FROM owners
    WHERE user_id='$userId'
    LIMIT 1
");

$profil = mysqli_fetch_assoc($queryProfil);

?>