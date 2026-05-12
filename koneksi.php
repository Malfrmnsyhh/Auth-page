<?php
$host = '127.0.0.1';
$port = '3308';
$user = 'root';
$pass = 'admin';
$db   = 'users_auth';

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>