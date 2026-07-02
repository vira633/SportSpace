<?php
include "config.php";

$field_id = $_POST['field_id'];

$jam_buka = $_POST['jam_buka'];
$jam_tutup = $_POST['jam_tutup'];
$durasi_slot = $_POST['durasi_slot'];

$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];

$jam_operasional = $jam_buka . " - " . $jam_tutup;

$hari_libur = "";

if (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
    $hari_libur = $tanggal_mulai . " s/d " . $tanggal_selesai;
}

$query = mysqli_query($conn,"
UPDATE fields
SET
jam_operasional='$jam_operasional',
durasi_slot='$durasi_slot',
hari_libur='$hari_libur'
WHERE field_id='$field_id'
");

if($query){

    session_start();

    $_SESSION['success'] = "Jadwal berhasil diperbarui.";

    $_SESSION['open_section'] = "jadwal";

    header("Location: dashboard-owner.php");

    exit;

}else{

    echo mysqli_error($conn);

}