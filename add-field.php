<?php
session_start();
include "config.php";

$user_id = $_SESSION['user_id'];

$queryOwner = mysqli_query($conn,"
SELECT owner_id, nama, telepon, alamat
FROM owners
WHERE user_id='$user_id'
LIMIT 1
");

$owner = mysqli_fetch_assoc($queryOwner);

if(!$owner){
    die("Owner tidak ditemukan.");
}

$owner_id = $owner['owner_id'];

// Data owner buat auto-fill (biar owner ga perlu ngetik ulang tiap tambah lapangan)
$owner_name = $owner['nama'] ?? '';
$owner_phone = $owner['telepon'] ?? '';
$owner_address = $owner['alamat'] ?? '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nama = $_POST['nama_lapangan'];
    $jenis = $_POST['jenis'];
    $lokasi = $_POST['lokasi'];
    $harga = str_replace(".", "", $_POST['harga']);
    $kapasitas = $_POST['kapasitas'];
    $jenis_lantai = $_POST['jenis_lantai'];
    $jam = $_POST['jam_operasional'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas'] ?? '';

    // Auto-generate link Google Maps dari alamat lokasi
    $lokasiEncoded = urlencode($lokasi);
    $maps_link = "https://www.google.com/maps?q=" . $lokasiEncoded . "&output=embed";
    $google_maps_url = "https://maps.google.com/?q=" . $lokasiEncoded;

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
    owner_name,
    owner_phone,
    owner_address,
    jam_operasional,
    kapasitas,
    jenis_lantai,
    fasilitas,
    maps_link,
    google_maps_url,
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
    '$owner_name',
    '$owner_phone',
    '$owner_address',
    '$jam',
    '$kapasitas',
    '$jenis_lantai',
    '$fasilitas',
    '$maps_link',
    '$google_maps_url',
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