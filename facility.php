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
<main style="display: flex;
    flex-direction: column;
    align-items: center;">
    <h1><?php echo htmlspecialchars($name); ?></h1>
    <p><?php echo htmlspecialchars($description); ?></p>
    <h2>Sektory/Tory</h2>
    <ul>
    <?php
    $query = "SELECT id, name FROM sectors WHERE facility_id = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $sector_id, $sector_name);
        while (mysqli_stmt_fetch($stmt)) {
            echo "<li>$sector_name</li>";
        }
        mysqli_stmt_close($stmt);
    }
    ?>
</ul>

    <h2>Opinie</h2>
    <?php
    $query = "SELECT u.username, r.rating, r.comment FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.facility_id = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username, $rating, $comment);
        echo "<ul>";
        while (mysqli_stmt_fetch($stmt)) {
            echo "<li><strong>$username</strong>: $rating/10 - $comment</li>";
        }
        echo "</ul>";
        mysqli_stmt_close($stmt);
    }
    ?>
    <?php if (isLoggedIn()): ?>
        <div class="review-form-container">
            <form action="/reviews/add_review.php" method="post">
                <input type="hidden" name="facility_id" value="<?php echo $id; ?>">
                <label for="rating">Opinia:</label>
                <select name="rating" id="rating" required>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <label for="comment">Komentarz:</label>
                <textarea name="comment" id="comment" required></textarea>
                <button type="submit">Wyślij opinie</button>
            </form>
        </div>

        <?php
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $object_id = (int)$_GET['id'];
        } else {
            die("Niepoprawne ID obiektu.");
        }

        $average_rating = 0;

        try {
            $stmt = $pdo->prepare("SELECT AVG(rating) AS average_rating FROM reviews WHERE facility_id = ?");
            $stmt->execute([$object_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $average_rating = $row['average_rating'];
            }
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
        ?>
        <div>
            <h2>Średnia ocena obiektu</h2>
            <p><?php echo number_format($average_rating, 2); ?></p>
        </div>

        <h2>Rezerwacja</h2>
        <form class="reservation-form-container" action="make_reservation.php" method="post">
            <input type="hidden" name="facility_id" value="<?php echo $id; ?>">
            <select name="sector_id" id="sector_id" required>
                <?php
                $query = "SELECT id, name FROM sectors WHERE facility_id = ?";
                $statement = $link->prepare($query);
                $statement->bind_param('i', $id);
                $statement->execute();
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>

            <label for="date">Data:</label>
            <input type="date" name="date" id="date" required>
            <label for="start_time">Czas rozpoczęcia:</label>
            <input type="time" name="start_time" id="start_time" required>
            <label for="end_time">Czas zakończenia:</label>
            <input type="time" name="end_time" id="end_time" required>
            <button type="button" id="calculate-price">Oblicz cene</button>
            <div id="price-output"></div>
            <button type="submit">Wykonaj rezerwacje</button>

        </form>
    <?php else: ?>
        <p> <a href="user/login.php">Zaloguj</a> się by wykonać rezerwacje</p>
    <?php endif; ?>
</main>
<?php require_once 'includes/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("calculate-price").addEventListener("click", function () {
        var startDate = document.getElementById("date").value + ' ' + document.getElementById("start_time").value;
        var endDate = document.getElementById("date").value + ' ' + document.getElementById("end_time").value;
        var facilityId = document.querySelector("input[name='facility_id']").value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "calculate_price.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var price = parseFloat(xhr.responseText).toFixed(2);
                    document.getElementById("price-output").innerText = "Total price: " + price + " zł";
                } else {
                    console.error('Błąd obliczania ceny.');
                }
            }
        };
        xhr.send("date=" + startDate + "&start_time=" + startDate + "&end_time=" + endDate + "&facility_id=" + facilityId);
    });
});
</script>

