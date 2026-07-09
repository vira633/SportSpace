<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['owner_id'])) {
    echo json_encode([]);
    exit;
}

$owner_id = (int) $_SESSION['owner_id'];

$query = mysqli_query($conn, "
SELECT
    c.field_id,
    c.user_id,
    u.nama AS user_nama,
    f.nama_lapangan,
    (
        SELECT pesan FROM chat c2
        WHERE c2.field_id = c.field_id AND c2.user_id = c.user_id
        ORDER BY c2.waktu DESC LIMIT 1
    ) AS last_pesan,
    (
        SELECT waktu FROM chat c2
        WHERE c2.field_id = c.field_id AND c2.user_id = c.user_id
        ORDER BY c2.waktu DESC LIMIT 1
    ) AS last_waktu,
    (
        SELECT COUNT(*) FROM chat c3
        WHERE c3.field_id = c.field_id AND c3.user_id = c.user_id
        AND c3.sender = 'user' AND c3.status = 'belum'
    ) AS unread
FROM chat c
JOIN fields f ON c.field_id = f.field_id
JOIN users u ON c.user_id = u.user_id
WHERE f.owner_id = '$owner_id'
GROUP BY c.field_id, c.user_id
ORDER BY last_waktu DESC
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {

    $inisial = "";
    $kata = explode(" ", trim($row['user_nama']));
    foreach ($kata as $k) {
        if ($k !== "") $inisial .= strtoupper(substr($k, 0, 1));
    }
    $inisial = substr($inisial, 0, 2);

    $data[] = [
        'field_id'      => (int) $row['field_id'],
        'user_id'       => (int) $row['user_id'],
        'user_nama'     => $row['user_nama'],
        'inisial'       => $inisial,
        'nama_lapangan' => $row['nama_lapangan'],
        'last_pesan'    => $row['last_pesan'],
        'last_waktu'    => $row['last_waktu'] ? date('H:i', strtotime($row['last_waktu'])) : '',
        'unread'        => (int) $row['unread'],
    ];
}

echo json_encode($data);