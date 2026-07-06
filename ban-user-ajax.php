<?php
include "config.php";

if(isset($_POST['id'])){

    $id = (int) $_POST['id'];

    $query = mysqli_query($conn,"
        UPDATE users
        SET aktif='nonaktif'
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