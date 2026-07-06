<?php
session_start();
include "config.php";

if(isset($_POST['nama']) && isset($_POST['email'])){

    $id = $_SESSION['user_id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = mysqli_query($conn,"
        UPDATE users
        SET
            nama = '$nama',
            email = '$email'
        WHERE user_id = '$id'
    ");

    if($query){

        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;

        header("Location: dashboard-admin.php?notif=profil");
        exit;

    }else{

        echo "Gagal memperbarui profil.";

    }

}
?>