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

$queryOwnerBooking = mysqli_query(
    $conn,
    "
    SELECT
    b.*,
    u.nama,
    f.nama_lapangan,
    f.harga

FROM booking b

JOIN users u
ON b.user_id = u.user_id

JOIN fields f
ON b.field_id = f.field_id

WHERE f.owner_id='$owner_id'

ORDER BY b.booking_id DESC
    "
);