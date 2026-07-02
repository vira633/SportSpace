<?php
header('Content-Type: application/json');

include "config.php";

if (!isset($_GET['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "ID tidak ditemukan."
    ]);
    exit;
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "SELECT aktif FROM fields WHERE field_id = $id");

if (mysqli_num_rows($query) == 0) {
    echo json_encode([
        "success" => false,
        "message" => "Lapangan tidak ditemukan."
    ]);
    exit;
}

$field = mysqli_fetch_assoc($query);

$statusBaru = ($field['aktif'] == 'aktif') ? 'nonaktif' : 'aktif';

$update = mysqli_query(
    $conn,
    "UPDATE fields SET aktif='$statusBaru' WHERE field_id=$id"
);

if ($update) {

    $qAktif = mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM fields
        WHERE aktif='aktif'
    ");

    $aktif = mysqli_fetch_assoc($qAktif);

    $qNonaktif = mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM fields
        WHERE aktif='nonaktif'
    ");

    $nonaktif = mysqli_fetch_assoc($qNonaktif);

    $qTotal = mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM fields
    ");

    $total = mysqli_fetch_assoc($qTotal);

    $qRata = mysqli_query($conn,"
    SELECT IFNULL(AVG(harga),0) AS rata
    FROM fields
    WHERE aktif='aktif'
    ");

$rata = mysqli_fetch_assoc($qRata);

    echo json_encode([
    "success"   => true,
    "status"    => $statusBaru,
    "aktif"     => (int)$aktif['total'],
    "nonaktif"  => (int)$nonaktif['total'],
    "total"     => (int)$total['total'],
    "rata"      => round($rata['rata'])
]);

}

else {

    echo json_encode([
        "success" => false,
        "message" => mysqli_error($conn)
    ]);

}