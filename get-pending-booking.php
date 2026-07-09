<?php

$qOwner = mysqli_query($conn,"
SELECT owner_id
FROM owners
WHERE user_id='{$_SESSION['user_id']}'
LIMIT 1
");

$owner = mysqli_fetch_assoc($qOwner);
$owner_id = $owner['owner_id'] ?? 0;

$queryPendingBooking = mysqli_query($conn,"
SELECT
    booking.booking_id,
    booking.tanggal,
    booking.jam_mulai,
    booking.jam_selesai,
    booking.status,
    users.nama,
    fields.nama_lapangan,
    fields.harga
FROM booking
JOIN users
ON booking.user_id = users.user_id
JOIN fields
ON booking.field_id = fields.field_id
WHERE
    booking.status='tertunda'
AND fields.owner_id='$owner_id'
ORDER BY booking.created_at ASC
");

if(!$queryPendingBooking){
    die(mysqli_error($conn));
}