<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];

$field_id = $_POST['field_id'];

$cek = mysqli_query($conn, "
SELECT *
FROM favorites
WHERE user_id='$user_id'
AND field_id='$field_id'
");

if (mysqli_num_rows($cek) > 0) {

    mysqli_query($conn, "
DELETE FROM favorites
WHERE user_id='$user_id'
AND field_id='$field_id'
");

    echo json_encode([
        "status" => "removed"
    ]);

} else {

    mysqli_query($conn, "
INSERT INTO favorites(user_id,field_id)
VALUES('$user_id','$field_id')
");

    echo json_encode([
        "status" => "added"
    ]);

}