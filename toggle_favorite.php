<?php
session_start();
include "config.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Login dulu"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$field_id = isset($_POST['field_id']) ? intval($_POST['field_id']) : 0;

if ($field_id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Field tidak valid"
    ]);
    exit;
}

/* cek sudah favorit belum */

$cek = mysqli_query($conn,"
SELECT favorite_id
FROM favorites
WHERE user_id='$user_id'
AND field_id='$field_id'
LIMIT 1
");

if(mysqli_num_rows($cek)>0){

    mysqli_query($conn,"
    DELETE FROM favorites
    WHERE user_id='$user_id'
    AND field_id='$field_id'
    ");

    echo json_encode([
        "success"=>true,
        "favorite"=>false
    ]);

}else{

    mysqli_query($conn,"
    INSERT INTO favorites(user_id,field_id)
    VALUES('$user_id','$field_id')
    ");

    echo json_encode([
        "success"=>true,
        "favorite"=>true
    ]);

}