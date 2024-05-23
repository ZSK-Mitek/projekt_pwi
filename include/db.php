<?php

$conn = new mysqli(
    '127.0.0.1',
    'root',
    '',
    'database', //jak bedzie baza danych stworzona to trzeba poustawiac
    3306
);

if ($conn->connect_errno) {
    echo "Failed to connect: " . $conn->connect_errno;
    die;
}