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

$queryActivity = mysqli_query($conn,"
SELECT
    booking.booking_id,
    booking.status,
    booking.created_at,

    users.nama,

    fields.nama_lapangan

FROM booking

JOIN users
ON booking.user_id = users.user_id

JOIN fields
ON booking.field_id = fields.field_id

WHERE fields.owner_id = '$owner_id'

ORDER BY booking.created_at DESC

LIMIT 5
");

if(!$queryActivity){
    die(mysqli_error($conn));
}