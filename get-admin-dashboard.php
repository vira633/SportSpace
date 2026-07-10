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

$queryNotifLapangan = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM fields
WHERE verifikasi='pending'
");

$notifLapangan = mysqli_fetch_assoc($queryNotifLapangan)['total'];

$queryNotifBooking = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM booking
WHERE DATE(created_at)=CURDATE()
");

$notifBooking = mysqli_fetch_assoc($queryNotifBooking)['total'];

$queryNotifUser = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM users
WHERE MONTH(created_at)=MONTH(CURDATE())
AND YEAR(created_at)=YEAR(CURDATE())
");

$notifUser = mysqli_fetch_assoc($queryNotifUser)['total'];

$totalNotif =
$notifLapangan +
$notifBooking +
$notifUser;

// =========================
// NOTIFIKASI
// =========================

// Lapangan pending
$qNotifLapangan = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM fields
    WHERE verifikasi='pending'
");
$notifLapangan = mysqli_fetch_assoc($qNotifLapangan)['total'];

// Booking baru hari ini
$qNotifBooking = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM booking
    WHERE DATE(created_at)=CURDATE()
    AND status='terkonfirmasi'
");
$notifBooking = mysqli_fetch_assoc($qNotifBooking)['total'];

// User baru hari ini
$qNotifUser = mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM users
    WHERE DATE(created_at)=CURDATE()
");
$notifUser = mysqli_fetch_assoc($qNotifUser)['total'];

$totalNotif = $notifLapangan + $notifBooking + $notifUser;