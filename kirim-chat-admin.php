<?php
session_start();
include 'config.php';

if (!isset($_SESSION['owner_id'])) {
    exit;
}

$owner_id = (int) $_SESSION['owner_id'];
$field_id = (int) ($_POST['field_id'] ?? 0);
$user_id  = (int) ($_POST['user_id'] ?? 0);
$pesan    = trim($_POST['pesan'] ?? '');

if ($pesan === "" || $field_id === 0 || $user_id === 0) {
    exit;
}

// pastikan owner cuma bisa balas chat di lapangan miliknya sendiri
$cekOwner = mysqli_query($conn, "
SELECT field_id FROM fields
WHERE field_id = '$field_id' AND owner_id = '$owner_id'
");

if (mysqli_num_rows($cekOwner) === 0) {
    exit;
}

mysqli_query($conn, "
INSERT INTO chat
(user_id, field_id, sender, pesan, status)
VALUES
('$user_id', '$field_id', 'admin', '$pesan', 'terbaca')
");

mysqli_query($conn,"
INSERT INTO user_notifications
(
    user_id,
    field_id,
    jenis,
    judul,
    isi
)
VALUES
(
    '$user_id',
    '$field_id',
    'chat',
    'Pesan Baru',
    'Owner mengirim pesan baru kepada Anda.'
)
");

exit;