<?php


    $pdo = new PDO("mysql:host=localhost;dbname=geo_location", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

if(!$pdo){
    echo "not connected";
}
// else{
//     // echo "connected";
// }
?>