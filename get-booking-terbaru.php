<?php

include "config.php";

$queryBookingTerbaru = mysqli_query(
    $conn,
    "
    SELECT
        booking.booking_code,
        users.nama,
        fields.nama_lapangan,
        booking.tanggal,
        booking.jam_mulai,
        booking.jam_selesai,
        payment.total,
        booking.status
    FROM booking

    JOIN users
    ON booking.user_id = users.user_id

    JOIN fields
    ON booking.field_id = fields.field_id

    LEFT JOIN payment
    ON booking.booking_id = payment.booking_id

    ORDER BY booking.booking_id DESC

    LIMIT 5
    "
);