<?php
$host = "127.0.0.1";
$userName = "pu_admin";
$password = "pentvars@12345";
$dbname = "puinvdb";
$port = 3309;

$mysqli = new mysqli($host, $userName, $password, $dbname, $port);

if ($mysqli->connect_errno) {
    die('Sorry, we have some problems');
}
mysqli_connect($host, $userName, $password, $dbname, $port);
