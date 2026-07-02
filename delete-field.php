<?php

include "config.php";

if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    
    $query = mysqli_query($conn,"
        DELETE FROM fields
        WHERE field_id = $id
    ");

    if($query){
        header("Location: dashboard-owner.php?section=lapangan");
        exit;
    }else{
        echo "Gagal menghapus data : ".mysqli_error($conn);
    }
}
else{
    header("Location: dashboard-owner.php?section=lapangan");
    exit;
}