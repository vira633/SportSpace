<?php

include "config.php";

$queryAllBooking = mysqli_query(
    $conn,
    "
    SELECT
        booking.*,
        users.nama,
        fields.nama_lapangan,
        fields.harga

    FROM booking

    JOIN users
    ON booking.user_id = users.user_id

    JOIN fields
    ON booking.field_id = fields.field_id

    ORDER BY booking.booking_id DESC
    "
);