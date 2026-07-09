<?php
include "config.php";

header("Content-Type: application/json");

if(isset($_POST['id'])){

    $id = (int) $_POST['id'];

    $query = mysqli_query($conn,"
        UPDATE fields
        SET
            verifikasi='ditolak',
            aktif='nonaktif'
        WHERE field_id='$id'
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