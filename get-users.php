<?php

include "config.php";

$queryUsers = mysqli_query($conn,"
SELECT *
FROM users
WHERE role != 'admin'
ORDER BY nama ASC
");