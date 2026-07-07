<?php
session_start();

include "config.php";

$userId   = $_SESSION['user_id'];

$nama     = $_POST['nama'];
$email    = $_POST['email'];
$telepon  = $_POST['telepon'];

$query = mysqli_query($conn,"
UPDATE owners
SET
nama='$nama',
email='$email',
telepon='$telepon'
WHERE user_id='$userId'
");

if($query){

    $_SESSION['toast'] = "Profil berhasil diperbarui.";
    $_SESSION['open_section']="profil";

    header("Location: dashboard-owner.php");
    exit;

}else{

    echo mysqli_error($conn);

}