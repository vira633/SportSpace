<?php
include "config.php";

$field_id = $_GET['field_id'];
$tanggal = $_GET['tanggal'];

$booking = [];

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

echo json_encode($booking);
?>