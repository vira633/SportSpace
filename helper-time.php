<?php

function waktuLalu($datetime){

    $selisih = abs(time() - strtotime($datetime));

    if($selisih < 60){
        return "Baru saja";
    }

    if($selisih < 3600){
        return floor($selisih/60)." menit lalu";
    }

    if($selisih < 86400){
        return floor($selisih/3600)." jam lalu";
    }

    if($selisih < 172800){
        return "Kemarin";
    }

    if($selisih < 604800){
        return floor($selisih/86400)." hari lalu";
    }

    if(date("Y", strtotime($datetime)) == date("Y")){
        return date("d M", strtotime($datetime));
    }
    
    return date("d M Y", strtotime($datetime));
}