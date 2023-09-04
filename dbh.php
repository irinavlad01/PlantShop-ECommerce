<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'paint_shop';
$port = '3307';

$conn = new mysqli($hostname, $username, $password, $database, $port);

/*if (!$conn->connect_errno){
    echo ' Conexiune cu succes !';
    exit();
}
else{
    echo 'Nu se poate conecta!!!';
}
*/