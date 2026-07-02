<?php

include "config.php";

$queryProfil = mysqli_query($conn,"
SELECT
    fields.*,
    owners.owner_id,
    owners.nama,
    owners.telepon,
    owners.alamat,
    owners.email
FROM fields
LEFT JOIN owners
ON owners.field_id = fields.field_id
LIMIT 1
");

$profil = mysqli_fetch_assoc($queryProfil);

?>