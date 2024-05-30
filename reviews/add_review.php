<?php
require_once '../includes/header.php';

if (!isLoggedIn()) {
    header("Location: ../user/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $facility_id = intval($_POST['facility_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);
    
    $query = "INSERT INTO reviews (user_id, facility_id, rating, comment) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "iiis", $user_id, $facility_id, $rating, $comment);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: ../facility.php?id=$facility_id");
    }
}
?>
