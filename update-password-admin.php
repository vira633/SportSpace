<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];

    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi    = $_POST['konfirmasi_password'];

    // Ambil password admin dari database
    $query = mysqli_query($conn,
        "SELECT password
         FROM users
         WHERE user_id='$user_id'");

    $admin = mysqli_fetch_assoc($query);

    // Cek password lama
    if(!password_verify($password_lama, $admin['password'])){

        header("Location: dashboard-admin.php?notif=passwordlama#section-setting");
        exit;
    }

    // Password baru minimal 8 karakter
    if(strlen($password_baru) < 8){

        header("Location: dashboard-admin.php?notif=passwordpendek#section-setting");
        exit;
    }

    // Konfirmasi password
    if($password_baru != $konfirmasi){

        header("Location: dashboard-admin.php?notif=passwordbeda#section-setting");
        exit;
    }

    // Hash password baru
    $hash = password_hash($password_baru, PASSWORD_DEFAULT);

    mysqli_query($conn,
        "UPDATE users
         SET password='$hash'
         WHERE user_id='$user_id'");

    header("Location: dashboard-admin.php?notif=passwordberhasil");
    exit;
}
?>