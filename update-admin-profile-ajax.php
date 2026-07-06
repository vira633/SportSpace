<?php
session_start();
include "config.php";

header("Content-Type: application/json");

if(isset($_POST['nama']) && isset($_POST['email'])){

    $id = $_SESSION['user_id'];

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = mysqli_query($conn,"
        UPDATE users
        SET
            nama='$nama',
            email='$email'
        WHERE user_id='$id'
    ");

    if($query){

        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;

        echo json_encode([
            "success" => true,
            "nama" => $nama,
            "email" => $email
        ]);

    }else{

        echo json_encode([
            "success" => false
        ]);

    }

}