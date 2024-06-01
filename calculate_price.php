<?php
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $date = $_POST["date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $facility_id = $_POST["facility_id"];

    
    $query = "SELECT hourly_rate FROM facilities WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $facility_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hourly_rate);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    
    $start = strtotime($start_time);
    $end = strtotime($end_time);
    $hours = ($end - $start) / 3600; 

    
    $total_price = $hours * $hourly_rate;

    
    echo $total_price;
}
?>