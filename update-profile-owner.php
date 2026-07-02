<?php
session_start();

include "config.php";

$field_id = $_POST['field_id'];
$owner_id = $_POST['owner_id'];

$nama_lapangan = $_POST['nama_lapangan'];
$lokasi = $_POST['lokasi'];
$deskripsi = $_POST['deskripsi'];

$nama_owner = $_POST['nama'];
$telepon = $_POST['telepon'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];

$fasilitas = "";

if(isset($_POST['fasilitas'])){
    $fasilitas = implode(",", $_POST['fasilitas']);
}

$queryFields = mysqli_query($conn,"
UPDATE fields
SET
nama_lapangan='$nama_lapangan',
lokasi='$lokasi',
owner_name='$nama_owner',
owner_phone='$telepon',
owner_address='$alamat',
fasilitas='$fasilitas',
deskripsi='$deskripsi'
WHERE field_id='$field_id'
");

$queryOwner = mysqli_query($conn,"
UPDATE owners
SET
nama='$nama_owner',
telepon='$telepon',
alamat='$alamat',
email='$email'
WHERE owner_id='$owner_id'
");

if($queryFields && $queryOwner){

    $_SESSION['success'] = "Profil GOR berhasil diperbarui.";

    $_SESSION['open_section'] = "profil";

    header("Location: dashboard-owner.php");
    exit;

}else{

    echo mysqli_error($conn);

}