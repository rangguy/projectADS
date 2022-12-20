<?php
    error_reporting(E_ALL ^ E_DEPRECATED AND E_NOTICE);
    $host = 'localhost';
    $dbname = 'projek';
    $user = 'root';
    $pass = '';

    $conn = mysqli_connect($host,$user,$pass,$dbname) or die('Gagal Connect');
    
?>
