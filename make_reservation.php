<?php
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header("Location: user/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $facility_id = intval($_POST['facility_id']);
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Weryfikacja czasu rezerwacji
    $query = "SELECT COUNT(*) FROM reservations WHERE sector_id IN (SELECT id FROM sectors WHERE facility_id = ?) AND date = ? AND start_time < ? AND end_time > ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "isss", $facility_id, $date, $end_time, $start_time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $conflicting_reservations);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($conflicting_reservations > 0) {
            echo "The selected time slot is already booked. Please choose a different time.";
        } else {
            $query = "INSERT INTO reservations (user_id, sector_id, date, start_time, end_time) VALUES (?, (SELECT id FROM sectors WHERE facility_id = ? LIMIT 1), ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $query)) {
                mysqli_stmt_bind_param($stmt, "iisss", $user_id, $facility_id, $date, $start_time, $end_time);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("Location: user/reservations.php");
                exit;
            } else {
                echo "Error making reservation.";
            }
        }
    } else {
        echo "Error checking reservation conflicts.";
    }
}
?>

<?php require_once 'includes/footer.php'; ?>