<?php

include "config.php";

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

    ORDER BY b.booking_id DESC
    "
);