<?php
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sports_reservation');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("BŁĄD: Nie można się połączyć. " . mysqli_connect_error());
}

$dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME;
try {
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Połączenie nie powiodło się: ' . $e->getMessage();
    exit;
}
?>