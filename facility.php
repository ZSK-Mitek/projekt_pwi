<?php
require_once 'includes/header.php';

$id = intval($_GET['id']);
$query = "SELECT name, description FROM facilities WHERE id = ?";
if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $description);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}
?>
<main>
    <h1><?php echo htmlspecialchars($name); ?></h1>
    <p><?php echo htmlspecialchars($description); ?></p>
    <h2>Sectors</h2>
    <ul>
        <?php
        $query = "SELECT id, name FROM sectors WHERE facility_id = ?";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $sector_id, $sector_name);
            while (mysqli_stmt_fetch($stmt)) {
                echo "<li><a href='reserve.php?sector_id=$sector_id'>$sector_name</a></li>";
            }
            mysqli_stmt_close($stmt);
        }
        ?>
    </ul>
    <h2>Reviews</h2>
    <?php
    $query = "SELECT u.username, r.rating, r.comment FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.facility_id = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username, $rating, $comment);
        echo "<ul>";
        while (mysqli_stmt_fetch($stmt)) {
            echo "<li><strong>$username</strong>: $rating/5 - $comment</li>";
        }
        echo "</ul>";
        mysqli_stmt_close($stmt);
    }
    ?>
    <?php if (isLoggedIn()): ?>
        <div class="review-form-container">
            <form action="/reviews/add_review.php" method="post">
                <input type="hidden" name="facility_id" value="<?php echo $id; ?>">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <label for="comment">Comment:</label>
                <textarea name="comment" id="comment" required></textarea>
                <button type="submit">Submit Review</button>
            </form>
        </div>

        <h2>Make Reservation</h2>
        <form class="reservation-form-container" action="make_reservation.php" method="post">
            <input type="hidden" name="facility_id" value="<?php echo $id; ?>">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>
            <label for="start_time">Start Time:</label>
            <input type="time" name="start_time" id="start_time" required>
            <label for="end_time">End Time:</label>
            <input type="time" name="end_time" id="end_time" required>
            <button type="submit">Make Reservation</button>
        </form>
    <?php else: ?>
        <p>Please <a href="user/login.php">login</a> to make a reservation.</p>
    <?php endif; ?>
</main>
<?php require_once 'includes/footer.php'; ?>