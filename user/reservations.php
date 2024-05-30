<?php
require_once '../includes/header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT r.id, f.name AS facility_name, s.name AS sector_name, r.date, r.start_time, r.end_time 
          FROM reservations r 
          JOIN sectors s ON r.sector_id = s.id 
          JOIN facilities f ON s.facility_id = f.id 
          WHERE r.user_id = ?";
if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $reservation_id, $facility_name, $sector_name, $date, $start_time, $end_time);
    echo "<h2>My Reservations</h2>";
    echo "<ul class='reservations-list'>";
    while (mysqli_stmt_fetch($stmt)) {
        echo "<li>
                <strong>Facility:</strong> " . htmlspecialchars($facility_name) . "<br>
                <strong>Sector:</strong> " . htmlspecialchars($sector_name) . "<br>
                <strong>Date:</strong> " . htmlspecialchars($date) . "<br>
                <strong>Start Time:</strong> " . htmlspecialchars($start_time) . "<br>
                <strong>End Time:</strong> " . htmlspecialchars($end_time) . "
              </li>";
    }
    echo "</ul>";
    mysqli_stmt_close($stmt);
}
?>
<?php require_once '../includes/footer.php'; ?>