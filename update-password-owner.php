<?php
session_start();

include "config.php";

$userId = $_SESSION['user_id'];

$passwordLama = $_POST['password_lama'];
$passwordBaru = $_POST['password_baru'];
$konfirmasi   = $_POST['konfirmasi_password'];

/* Ambil password lama dari tabel users */
$query = mysqli_query($conn,"
    SELECT password
    FROM users
    WHERE user_id='$userId'
    LIMIT 1
");

$user = mysqli_fetch_assoc($query);

/* Cek password lama */
if(!password_verify($passwordLama, $user['password'])){

    $_SESSION['error'] = "Password lama salah.";
    $_SESSION['open_section'] = "profil";

    header("Location: dashboard-owner.php");
    exit;

}

/* Cek konfirmasi password */
if($passwordBaru != $konfirmasi){

    $_SESSION['error'] = "Konfirmasi password tidak sesuai.";
    $_SESSION['open_section'] = "profil";

    header("Location: dashboard-owner.php");
    exit;

}

/* Hash password baru */
$passwordHash = password_hash($passwordBaru, PASSWORD_DEFAULT);

/* Update password */
mysqli_query($conn,"
    UPDATE users
    SET password='$passwordHash'
    WHERE user_id='$userId'
");

$_SESSION['toast'] = "Password berhasil diperbarui.";
$_SESSION['open_section'] = "profil";

header("Location: dashboard-owner.php");
exit;