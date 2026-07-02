<?php

include "config.php";

$queryUsers = mysqli_query(
    $conn,
    "SELECT * FROM users
     ORDER BY user_id DESC"
);