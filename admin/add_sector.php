<?php
require_once '../includes/header.php';

if (!isAdmin($link)) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $facility_id = intval($_POST['facility_id']);
    $name = trim($_POST['name']);
    
    $query = "INSERT INTO sectors (facility_id, name) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "is", $facility_id, $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: index.php");
    }
}
?>
<form action="add_sector.php" method="post">
    <label for="facility_id">Obiekt:</label>
    <select name="facility_id" id="facility_id" required>
        <?php
        $query = "SELECT id, name FROM facilities";
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>
    <label for="name">Nazwa Toru / Sektoru</label>
    <input type="text" name="name" id="name" required>
    <button type="submit">Dodaj Tor/Sektor do obiektu</button>
</form>
<?php require_once '../includes/footer.php'; ?>
