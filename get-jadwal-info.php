<?php

include "config.php";

$user_id = $_SESSION['user_id'];

$queryOwner = mysqli_query($conn,"
SELECT owner_id
FROM owners
WHERE user_id='$user_id'
LIMIT 1
");

$owner = mysqli_fetch_assoc($queryOwner);

$owner_id = $owner['owner_id'] ?? 0;

if(isset($_GET['field'])){

    $field_id = (int)$_GET['field'];

}else{

    $cek = mysqli_query($conn,"
    SELECT field_id
    FROM fields
    WHERE owner_id='$owner_id'
    ORDER BY field_id ASC
    LIMIT 1
    ");

    $fieldPertama = mysqli_fetch_assoc($cek);
    
    $field_id = $fieldPertama['field_id'] ?? 0;

}

$queryInfo = mysqli_query($conn,"
SELECT *
FROM fields
WHERE field_id='$field_id'
AND owner_id='$owner_id'
");

$info = mysqli_fetch_assoc($queryInfo);

if(!$info){

    $info = [
        "field_id" => 0,
        "nama_lapangan" => "",
        "hari_libur" => "",
        "jam_operasional" => "",
        "kapasitas" => "",
        "jenis_lantai" => "",
        "lokasi" => ""
    ];

    $dataBooking = ["total"=>0];
    $dataBookingKemarin = ["total"=>0];

    $selisihBooking = 0;

    $totalPendapatanBulan = 0;

    $targetPendapatan = 2000000;

    $persentaseTarget = 0;

    $queryJadwalBooking = false;

    return;
}


$tanggal_mulai = "";
$tanggal_selesai = "";

if (!empty($info['hari_libur'])) {

    $hari = explode(" s/d ", $info['hari_libur']);

    $tanggal_mulai = $hari[0] ?? "";

    $tanggal_selesai = $hari[1] ?? "";

}

$queryBookingHariIni = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
    FROM booking
    WHERE field_id = '".$info['field_id']."'
    AND tanggal = CURDATE()
    AND status='terkonfirmasi'"
);

$queryJadwalBooking = mysqli_query($conn,"
SELECT
    tanggal,
    jam_mulai,
    jam_selesai,
    status
FROM booking
WHERE field_id='".$info['field_id']."'
AND status='terkonfirmasi'
");

$dataBooking = mysqli_fetch_assoc($queryBookingHariIni);

$queryBookingKemarin = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking
WHERE field_id='".$info['field_id']."'
AND tanggal = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
AND status='terkonfirmasi'
");

$dataBookingKemarin = mysqli_fetch_assoc($queryBookingKemarin);

$selisihBooking =
$dataBooking['total'] - $dataBookingKemarin['total'];

// TOTAL PENDAPATAN BULAN INI //

$bulan = date('m');
$tahun = date('Y');

$queryPendapatanBesar = mysqli_query($conn,"
SELECT IFNULL(SUM(total),0) AS total
FROM payment
WHERE status='diverifikasi'
AND MONTH(tanggal_bayar)='$bulan'
AND YEAR(tanggal_bayar)='$tahun'
");

$dataPendapatanBesar = mysqli_fetch_assoc($queryPendapatanBesar);

$totalPendapatanBulan = $dataPendapatanBesar['total'];

$targetPendapatan = 2000000;

$persentaseTarget = 0;

if($targetPendapatan > 0){

    $persentaseTarget = round(
        ($totalPendapatanBulan / $targetPendapatan) * 100
    );

    if($persentaseTarget > 100){
        $persentaseTarget = 100;
    }
}

?>