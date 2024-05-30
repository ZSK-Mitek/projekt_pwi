<?php
require_once '../includes/header.php';

if (!isAdmin()) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    
    $query = "INSERT INTO facilities (name, description) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "ss", $name, $description);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: index.php");
    }
}
?>
<form action="add_facility.php" method="post">
    <label for="name">Nazwa Obiektu</label>
    <input type="text" name="name" id="name" required>
    <label for="description">Opis</label>
    <textarea name="description" id="description" required></textarea>
    <button type="submit">Dodaj Obiekt</button>
</form>
<?php require_once '../includes/footer.php'; ?>
