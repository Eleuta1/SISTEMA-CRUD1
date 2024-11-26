<?php

//host

// subir file no git 

$host = '';

//database

$db_name =  '';
$db_host = '';
$db_user = 'root';
$db_pass = '';

try {
    $conn = mysqli_connect($db_host, $db_user, $db_name);
}   catch (\Throwable $th) {
    throw $th;
}