<?php

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

ORDER BY booking.created_at DESC

LIMIT 5
");

if(!$queryActivity){
    die(mysqli_error($conn));
}