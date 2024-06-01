<?php
require_once '../includes/header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_reservation_id'])) {
    $reservation_id_to_cancel = intval($_POST['cancel_reservation_id']);

    $check_query = "SELECT date FROM reservations WHERE id = ? AND user_id = ?";
    if ($stmt = mysqli_prepare($link, $check_query)) {
        mysqli_stmt_bind_param($stmt, "ii", $reservation_id_to_cancel, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $reservation_date);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        $current_date = new DateTime();
        $reservation_date = new DateTime($reservation_date);
        $interval = $current_date->diff($reservation_date);

        if ($interval->days >= 1 && $interval->invert == 0) {
            $delete_query = "DELETE FROM reservations WHERE id = ? AND user_id = ?";
            if ($stmt = mysqli_prepare($link, $delete_query)) {
                mysqli_stmt_bind_param($stmt, "ii", $reservation_id_to_cancel, $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "<p>Rezerwacja została anulowana.</p>";
            }
        } else {
            echo "<p>Rezerwację można anulować najpóźniej jeden dzień wcześniej.</p>";
        }
    }
}

$query = "SELECT r.id, f.name AS facility_name, s.name AS sector_name, r.date, r.start_time, r.end_time 
          FROM reservations r 
          JOIN sectors s ON r.sector_id = s.id 
          JOIN facilities f ON s.facility_id = f.id 
          WHERE r.user_id = ?";
if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $reservation_id, $facility_name, $sector_name, $date, $start_time, $end_time);
    echo "<h1>Moje rezerwacje</h1>";
    echo "<ul class='reservations-list'>";
    while (mysqli_stmt_fetch($stmt)) {
        echo "<li>
                <strong>Obiekt:</strong> " . htmlspecialchars($facility_name) . "<br>
                <strong>Sektor/tor:</strong> " . htmlspecialchars($sector_name) . "<br>
                <strong>Data:</strong> " . htmlspecialchars($date) . "<br>
                <strong>Czas rozpoczęcia:</strong> " . htmlspecialchars($start_time) . "<br>
                <strong>Czas zakończenia:</strong> " . htmlspecialchars($end_time) . "<br>";

        $reservation_date = new DateTime($date);
        $current_date = new DateTime();
        $interval = $current_date->diff($reservation_date);
        if ($interval->days >= 1 && $interval->invert == 0) {
            echo "<form method='post' action='reservations.php'>
                    <input type='hidden' name='cancel_reservation_id' value='" . htmlspecialchars($reservation_id) . "'>
                    <button type='submit' class='cancel-button'>Anuluj</button>
                  </form>";
        }
        echo "</li>";
    }
    echo "</ul>";
    mysqli_stmt_close($stmt);
}
?>
<?php require_once '../includes/footer.php'; ?>