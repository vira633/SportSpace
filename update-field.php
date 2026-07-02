<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $id = $_POST['field_id'];
    $nama = $_POST['nama_lapangan'];
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    $jenis_lantai = $_POST['jenis_lantai'];
    $lokasi = $_POST['lokasi'];
    $kapasitas = $_POST['kapasitas'];
    $jam_operasional = $_POST['jam_operasional'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar'];
    

    if($gambar['error'] == 4){
        $query = mysqli_query($conn,"
        UPDATE fields
        SET
            nama_lapangan = '$nama',
            jenis = '$jenis',
            lokasi = '$lokasi',
            harga = '$harga',
            kapasitas = '$kapasitas',
            jenis_lantai = '$jenis_lantai',
            jam_operasional = '$jam_operasional',
            deskripsi = '$deskripsi'
        WHERE field_id = '$id'
        ");

    if($query){
        $_SESSION['open_section'] = "lapangan";
        $_SESSION['toast'] = "Lapangan berhasil diperbarui.";
        header("Location: dashboard-owner.php");
        exit;
    }else{
        echo mysqli_error($conn);
    }
    
    }else{
        $dataLama = mysqli_query($conn,"
        SELECT gambar
        FROM fields
        WHERE field_id = '$id'
    ");
    
    $fieldLama = mysqli_fetch_assoc($dataLama);
    $namaGambar = time() . "_" . basename($gambar['name']);
    $folder = __DIR__ . "/uploads/fields/";
    $tujuan = $folder . $namaGambar;
    move_uploaded_file($gambar['tmp_name'], $tujuan);
    if (
        !empty($fieldLama['gambar']) &&
        file_exists($folder . $fieldLama['gambar'])
        ) {
            unlink($folder . $fieldLama['gambar']);
            }
    
    $query = mysqli_query($conn,"
    UPDATE fields
    SET
        nama_lapangan = '$nama',
        jenis = '$jenis',
        lokasi = '$lokasi',
        harga = '$harga',
        kapasitas = '$kapasitas',
        jenis_lantai = '$jenis_lantai',
        jam_operasional = '$jam_operasional',
        deskripsi = '$deskripsi',
        gambar = '$namaGambar'

    WHERE field_id = '$id'
    ");
    
    if($query){
        $_SESSION['open_section'] = "lapangan";
        $_SESSION['toast'] = "Lapangan berhasil diperbarui.";
        header("Location: dashboard-owner.php");
        exit;
    }else{
        echo mysqli_error($conn);
    }
    }

    exit;
}