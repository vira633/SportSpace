<?php
include "config.php";

header("Content-Type: application/json");

if(isset($_POST['id'])){

    $id = (int) $_POST['id'];

    $query = mysqli_query($conn,"
        UPDATE users
        SET aktif='aktif'
        WHERE user_id='$id'
    ");

    if($query){

        echo json_encode([
            "success" => true
        ]);

    }else{

        echo json_encode([
            "success" => false
        ]);

    }

}