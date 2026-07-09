<?php
session_start();
include "config.php";

$user_id = $_SESSION['user_id'];

$queryOwner = mysqli_query($conn,"
SELECT owner_id
FROM owners
WHERE user_id='$user_id'
LIMIT 1
");

$owner = mysqli_fetch_assoc($queryOwner);

if(!$owner){
    die("Owner tidak ditemukan.");
}

$owner_id = $owner['owner_id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nama = $_POST['nama_lapangan'];
    $jenis = $_POST['jenis'];
    $lokasi = $_POST['lokasi'];
    $harga = str_replace(".", "", $_POST['harga']);
    $kapasitas = $_POST['kapasitas'];
    $jenis_lantai = $_POST['jenis_lantai'];
    $jam = $_POST['jam_operasional'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar'];
    $namaGambar = time() . "_" . basename($gambar["name"]);
    $folder = __DIR__ . "/uploads/fields/";
    $tujuan = $folder . $namaGambar;
    move_uploaded_file($gambar["tmp_name"], $tujuan);

    $query = mysqli_query($conn,"
    INSERT INTO fields
    (
    owner_id,
    nama_lapangan,
    jenis,
    harga,
    status,
    lokasi,
    gambar,
    deskripsi,
    jam_operasional,
    kapasitas,
    jenis_lantai,
    verifikasi,
    aktif
    )
    
    VALUES
    (
    '$owner_id',
    '$nama',
    '$jenis',
    '$harga',
    'tersedia',
    '$lokasi',
    '$namaGambar',
    '$deskripsi',
    '$jam',
    '$kapasitas',
    '$jenis_lantai',
    'pending',
    'nonaktif'
    )
    ");

    if($query){
        $_SESSION['open_section'] = "lapangan";
        $_SESSION['toast'] = "Lapangan berhasil ditambahkan.";
        
        header("Location: dashboard-owner.php");
        exit;
    }else{
        echo mysqli_error($conn);
        }
}