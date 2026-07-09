<?php
session_start();
include 'config.php';

if (!isset($_SESSION['owner_id'])) {
    exit;
}

$owner_id = (int) $_SESSION['owner_id'];
$field_id = (int) ($_GET['field_id'] ?? 0);
$user_id  = (int) ($_GET['user_id'] ?? 0);

// pastikan lapangan ini beneran punya owner yang lagi login
$cekOwner = mysqli_query($conn, "
SELECT field_id FROM fields
WHERE field_id = '$field_id' AND owner_id = '$owner_id'
");

if (mysqli_num_rows($cekOwner) === 0) {
    exit;
}

// tandai semua pesan dari user di percakapan ini sebagai sudah dibaca
mysqli_query($conn, "
UPDATE chat
SET status = 'terbaca'
WHERE field_id = '$field_id'
AND user_id = '$user_id'
AND sender = 'user'
AND status = 'belum'
");

$query = mysqli_query($conn, "
SELECT * FROM chat
WHERE field_id = '$field_id'
AND user_id = '$user_id'
ORDER BY waktu ASC
");

while ($chat = mysqli_fetch_assoc($query)) {

    // dari sudut pandang owner: pesan admin = 'me', pesan user = 'user'
    $class = $chat['sender'] == 'admin' ? 'me' : 'user';
    ?>

    <div class="message <?= $class ?>">

        <?= htmlspecialchars($chat['pesan']) ?>

        <div class="time">
            <?= date("H:i", strtotime($chat['waktu'])) ?>
        </div>

    </div>

    <?php
}