<?php
include "config.php";

if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    $query = mysqli_query($conn,"
        SELECT
            user_id,
            nama,
            email,
            telepon,
            role,
            created_at
        FROM users
        WHERE user_id='$id'
    ");

    $user = mysqli_fetch_assoc($query);

    echo json_encode($user);
}