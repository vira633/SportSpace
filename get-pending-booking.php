<?php

$queryPendingBooking = mysqli_query($conn, "
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

WHERE booking.status = 'tertunda'

ORDER BY booking.created_at ASC
");

if(!$queryPendingBooking){
    die(mysqli_error($conn));
}