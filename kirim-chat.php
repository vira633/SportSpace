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

mysqli_query($conn, "
INSERT INTO chat
(user_id, field_id, sender, pesan)

VALUES
(
'$user_id',
'$field_id',
'user',
'$pesan'
)
");
?>