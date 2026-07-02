<?php

include "config.php";

/* Ambil data lapangan milik owner */

$queryField = mysqli_query($conn, "
SELECT *
FROM fields
LIMIT 1
");

$field = mysqli_fetch_assoc($queryField);
$field_id = $field['field_id'];

/* Booking Hari Ini */

$queryBookingHariIni = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM booking
WHERE tanggal = CURDATE()
");

$bookingHariIni = mysqli_fetch_assoc($queryBookingHariIni);

/* Booking Kemarin */

$queryBookingKemarin = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM booking
WHERE tanggal = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
");

$bookingKemarin = mysqli_fetch_assoc($queryBookingKemarin);

$selisihBooking =
$bookingHariIni['total'] - $bookingKemarin['total'];


/* Booking Pending */

$queryPending = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM booking
WHERE status='tertunda'
");

$pending = mysqli_fetch_assoc($queryPending);

/* Booking Terkonfirmasi */

$queryKonfirmasi = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking
WHERE status='terkonfirmasi'
");

$konfirmasi = mysqli_fetch_assoc($queryKonfirmasi);

/* Booking Selesai */

$querySelesai = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking
WHERE status='selesai'
");

$selesai = mysqli_fetch_assoc($querySelesai);

/* Booking Dibatalkan */

$queryDibatalkan = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking
WHERE status='dibatalkan'
");

$dibatalkan = mysqli_fetch_assoc($queryDibatalkan);

/* Lapangan Aktif */

$queryLapanganAktif = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM fields
WHERE aktif='aktif'
");

$lapanganAktif = mysqli_fetch_assoc($queryLapanganAktif);

/* Lapangan Non Aktif */

$queryLapanganNonaktif = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM fields
WHERE aktif='nonaktif'
");

$lapanganNonaktif = mysqli_fetch_assoc($queryLapanganNonaktif);

/* Total Lapangan */

$queryTotalLapangan = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM fields
");

$totalLapangan = mysqli_fetch_assoc($queryTotalLapangan);

/* Pendapatan Bulan Ini */

$queryPendapatan = mysqli_query($conn,"
SELECT SUM(f.harga) AS total
FROM booking b
JOIN fields f ON b.field_id = f.field_id
WHERE b.status='terkonfirmasi'
AND MONTH(b.tanggal)=MONTH(CURDATE())
AND YEAR(b.tanggal)=YEAR(CURDATE())
");

$pendapatan = mysqli_fetch_assoc($queryPendapatan);

if($pendapatan['total'] == NULL){
    $pendapatan['total'] = 0;
}

$queryPendapatanLalu = mysqli_query($conn,"
SELECT SUM(f.harga) AS total
FROM booking b
JOIN fields f
ON b.field_id = f.field_id
WHERE b.status='terkonfirmasi'
AND MONTH(b.tanggal)=MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
AND YEAR(b.tanggal)=YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
");

$pendapatanLalu = mysqli_fetch_assoc($queryPendapatanLalu);

if($pendapatanLalu['total'] == NULL){
    $pendapatanLalu['total'] = 0;
}

/* Target Pendapatan */

$targetPendapatan = 2000000;

$persenTarget = ($pendapatan['total'] / $targetPendapatan) * 100;

if($persenTarget > 100){
    $persenTarget = 100;
}

/* Persentase Pendapatan */

if($pendapatanLalu['total'] > 0){

    $persentasePendapatan =
    (($pendapatan['total'] - $pendapatanLalu['total'])
    / $pendapatanLalu['total']) * 100;

}else{

    $persentasePendapatan = 0;

}

/* Persentase Pendapatan */

if($pendapatanLalu['total'] > 0){

    $persentasePendapatan =
    (($pendapatan['total'] - $pendapatanLalu['total'])
    / $pendapatanLalu['total']) * 100;

}else{

    $persentasePendapatan = 0;

}

/* Booking 7 Hari Terakhir */

$booking7Hari = [];

for($i = 6; $i >= 0; $i--){

    $tanggal = date("Y-m-d", strtotime("-$i day"));

    $query = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM booking
    WHERE tanggal='$tanggal'
    ");

    $data = mysqli_fetch_assoc($query);

    $booking7Hari[] = $data['total'];

    $maxBooking = max($booking7Hari);
    
    if($maxBooking == 0){
        $maxBooking = 1;
        }
}

/* Tarif Rata-rata */

$queryRataHarga = mysqli_query($conn, "
SELECT ROUND(AVG(harga)) AS rata
FROM fields
WHERE aktif='aktif'
");

$rataHarga = mysqli_fetch_assoc($queryRataHarga);

/* Jumlah Lapangan per Jenis */

$queryJenis = mysqli_query($conn,"
SELECT jenis, COUNT(*) AS total
FROM fields
GROUP BY jenis
");

$jumlahJenis = [];

while($row = mysqli_fetch_assoc($queryJenis)){

    $jumlahJenis[$row['jenis']] = $row['total'];
}

?>