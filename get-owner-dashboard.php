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

/* Ambil data lapangan milik owner */

$queryField = mysqli_query($conn, "
SELECT *
FROM fields
WHERE owner_id = '$owner_id'
LIMIT 1
");

$field = mysqli_fetch_assoc($queryField);

$field_id = $field['field_id'] ?? 0;

/* Booking Hari Ini */

$queryBookingHariIni = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking b
JOIN fields f
ON b.field_id = f.field_id
WHERE f.owner_id='$owner_id'
AND b.tanggal = CURDATE()
AND b.status='terkonfirmasi'
");

$bookingHariIni = mysqli_fetch_assoc($queryBookingHariIni);

/* Booking Kemarin */

$queryBookingKemarin = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM booking b
JOIN fields f
ON b.field_id = f.field_id
WHERE f.owner_id='$owner_id'
AND b.tanggal = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
AND b.status='terkonfirmasi'
");

$bookingKemarin = mysqli_fetch_assoc($queryBookingKemarin);

$selisihBooking = $bookingHariIni['total'] - $bookingKemarin['total'];

/* Booking Pending */

$queryPending = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking b
JOIN fields f ON b.field_id = f.field_id
WHERE f.owner_id='$owner_id'
AND b.status='tertunda'
");

$pending = mysqli_fetch_assoc($queryPending);

/* Booking Terkonfirmasi */

$queryKonfirmasi = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking b
JOIN fields f ON b.field_id = f.field_id
WHERE f.owner_id='$owner_id'
AND b.status='terkonfirmasi'
");

$konfirmasi = mysqli_fetch_assoc($queryKonfirmasi);

/* Booking Selesai */

$querySelesai = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking b
JOIN fields f ON b.field_id = f.field_id
WHERE f.owner_id='$owner_id'
AND b.status='selesai'
");

$selesai = mysqli_fetch_assoc($querySelesai);

/* Booking Dibatalkan */

$queryDibatalkan = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking b
JOIN fields f ON b.field_id = f.field_id
WHERE f.owner_id='$owner_id'
AND b.status='dibatalkan'
");

$dibatalkan = mysqli_fetch_assoc($queryDibatalkan);

/* Lapangan Aktif */

$queryLapanganAktif = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM fields
WHERE owner_id='$owner_id'
AND aktif='aktif'
");

$lapanganAktif = mysqli_fetch_assoc($queryLapanganAktif);

/* Lapangan Non Aktif */

$queryLapanganNonaktif = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM fields
WHERE owner_id='$owner_id'
AND aktif='nonaktif'
");

$lapanganNonaktif = mysqli_fetch_assoc($queryLapanganNonaktif);

/* Total Lapangan */

$queryTotalLapangan = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM fields
WHERE owner_id='$owner_id'
");

$totalLapangan = mysqli_fetch_assoc($queryTotalLapangan);

/* Pendapatan Bulan Ini */

$queryPendapatan = mysqli_query($conn,"
SELECT SUM(f.harga) AS total
FROM booking b
JOIN fields f ON b.field_id = f.field_id
WHERE f.owner_id='$owner_id'
AND b.status='terkonfirmasi'
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
WHERE f.owner_id='$owner_id'
AND b.status='terkonfirmasi'
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

}
elseif($pendapatan['total'] > 0){

    $persentasePendapatan = 100;

}
else{

    $persentasePendapatan = 0;

}

/* Booking 7 Hari Terakhir */
/* Booking Minggu Ini (Senin - Minggu) */

$booking7Hari = [];
$maxBooking = 0;

$senin = strtotime("monday this week");

for($i = 0; $i < 7; $i++){

    $tanggal = date("Y-m-d", strtotime("+$i day", $senin));

    $query = mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM booking b
        JOIN fields f
        ON b.field_id = f.field_id
        WHERE f.owner_id='$owner_id'
        AND b.tanggal='$tanggal'
        AND b.status='terkonfirmasi'
    ");

    $data = mysqli_fetch_assoc($query);

    $booking7Hari[] = $data['total'];

    if($data['total'] > $maxBooking){
        $maxBooking = $data['total'];
    }
}

if($maxBooking == 0){
    $maxBooking = 1;
}

/* Tarif Rata-rata */

$queryRataHarga = mysqli_query($conn, "
SELECT ROUND(AVG(harga)) AS rata
FROM fields
WHERE owner_id='$owner_id'
AND aktif='aktif'
");

$rataHarga = mysqli_fetch_assoc($queryRataHarga);

/* Jumlah Lapangan per Jenis */

$queryJenis = mysqli_query($conn,"
SELECT jenis, COUNT(*) AS total
FROM fields
WHERE owner_id='$owner_id'
GROUP BY jenis
");

$jumlahJenis = [];

while($row = mysqli_fetch_assoc($queryJenis)){

    $jumlahJenis[$row['jenis']] = $row['total'];
}

?>