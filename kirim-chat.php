<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    exit;
}

$user_id = $_SESSION['user_id'];

$field_id = (int)$_POST['field_id'];
$pesan = trim($_POST['pesan']);

if ($pesan == "") {
    exit;
}

$pesan = mysqli_real_escape_string($conn, $pesan);

// status='belum' -> pesan ini belum dibaca owner, jadi bakal kehitung
// di badge notifikasi "Pesan" pada dashboard owner
mysqli_query($conn, "
INSERT INTO chat
(user_id, field_id, sender, pesan, status)

VALUES
(
'$user_id',
'$field_id',
'user',
'$pesan',
'belum'
)
");
?>