<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];

$field_id = (int)$_GET['field_id'];

$query = mysqli_query($conn,"
SELECT *
FROM chat
WHERE user_id='$user_id'
AND field_id='$field_id'
ORDER BY waktu ASC
");

while($chat=mysqli_fetch_assoc($query)){

    $class = $chat['sender']=="user" ? "me" : "admin";

    ?>

    <div class="message <?= $class ?>">

        <?= htmlspecialchars($chat['pesan']) ?>

        <div class="time">

            <?= date("H:i",strtotime($chat['waktu'])) ?>

        </div>

    </div>

    <?php

}