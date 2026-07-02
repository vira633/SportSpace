<?php

include "config.php";

/* =========================
   TOTAL USER
========================= */

$result = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM users
");

$totalUser = mysqli_fetch_assoc($result)['total'];


/* =========================
   TOTAL LAPANGAN
========================= */

$result = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM fields
");

$totalLapangan = mysqli_fetch_assoc($result)['total'];


/* =========================
   TOTAL BOOKING
========================= */

$result = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM booking
");

$totalBooking = mysqli_fetch_assoc($result)['total'];


/* =========================
   BOOKING PENDING
========================= */

$result = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM booking
WHERE status='tertunda'
");

$totalPending = mysqli_fetch_assoc($result)['total'];

/* =========================
   TOTAL OWNER
========================= */

$result = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM users
WHERE role='owner'
");

$totalOwner = mysqli_fetch_assoc($result)['total'];


/* =========================
   BOOKING HARI INI
========================= */

$result = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking
WHERE tanggal = CURDATE()
");

$totalBookingHariIni = mysqli_fetch_assoc($result)['total'];


/* =========================
   BOOKING SELESAI
========================= */

$result = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking
WHERE status='terkonfirmasi'
");

$totalBookingSelesai = mysqli_fetch_assoc($result)['total'];