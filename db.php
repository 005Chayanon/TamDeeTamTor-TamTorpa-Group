<?php
    $h = "127.0.0.1";
    $u = "root";
    $p = "";
    $db = "shcoolbooks";

    $conn = new mysqli($h,$u,$p,$db);

    if($conn->connect_error){
        die('Error' .$conn->connect_error);
    } 

    $conn->set_charset("utf8");
?>