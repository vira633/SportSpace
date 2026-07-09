<?php
include "config.php";

$field_id = $_GET['field_id'];
$tanggal = $_GET['tanggal'];

$booking = [];
$libur = false;

// CEK HARI LIBUR (format tersimpan: "2026-07-10 s/d 2026-07-15")
$qField = mysqli_query($conn, "SELECT hari_libur FROM fields WHERE field_id='$field_id'");
$fieldInfo = mysqli_fetch_assoc($qField);

if (!empty($fieldInfo['hari_libur'])) {

    $rentang = explode(" s/d ", $fieldInfo['hari_libur']);

    $liburMulai = $rentang[0] ?? "";
    $liburSelesai = $rentang[1] ?? "";

    if (
        !empty($liburMulai) &&
        !empty($liburSelesai) &&
        $tanggal >= $liburMulai &&
        $tanggal <= $liburSelesai
    ) {
        $libur = true;
    }
}

// Kalau bukan hari libur, baru cek jam yang udah dibooking
if (!$libur) {

    $q = mysqli_query($conn,"
    SELECT jam_mulai, jam_selesai
    FROM booking
    WHERE field_id='$field_id'
    AND tanggal='$tanggal'
    AND status!='dibatalkan'
    ");

    while($r = mysqli_fetch_assoc($q)){

        $awal = (int)substr($r['jam_mulai'], 0, 2);
        $akhir = (int)substr($r['jam_selesai'], 0, 2);

        for($i = $awal; $i < $akhir; $i++){

            $booking[] = sprintf("%02d:00", $i);

        }

    }

}

echo json_encode([
    "libur" => $libur,
    "penuh" => $booking
]);
?>