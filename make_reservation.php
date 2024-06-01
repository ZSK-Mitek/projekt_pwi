<?php
require_once 'includes/header.php';

if (!isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: user/login.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$facility_id = intval($_POST['facility_id']);
$sector_id = intval($_POST['sector_id']);
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];


$query = "SELECT COUNT(*) FROM reservations WHERE sector_id IN (SELECT id FROM sectors WHERE facility_id = ?) AND date = ? AND start_time < ? AND end_time > ?";
if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_bind_param($stmt, "isss", $sector_id,  $date, $end_time, $start_time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $conflicting_reservations);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($conflicting_reservations > 0) {
        echo "Wybrany przedział czasowy jest już zarezerwowany. Wybierz inny termin.";
    } else {
        
        $query = "INSERT INTO reservations (user_id, sector_id, date, start_time, end_time) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "iisss", $user_id, $sector_id, $date, $start_time, $end_time);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: user/reservations.php");
            exit;
        } else {
            echo "Błąd podczas dokonywania rezerwacji.";
        }
    }
}

require_once 'includes/footer.php';
?>