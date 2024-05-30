<?php
require_once 'includes/header.php';
?>

<main>
    <h2>Wyniki wyszukania</h2>
    <?php
    $query = trim($_GET['query']);
    $sql = "SELECT id, name, description FROM facilities WHERE name LIKE ?";
    $search = "%{$query}%";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $search);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name, $description);
        echo "<ul>";
        while (mysqli_stmt_fetch($stmt)) {
            echo "<li><a href='facility.php?id=$id'>$name</a></li>";
        }
        echo "</ul>";
        mysqli_stmt_close($stmt);
    }
    ?>
</main>

<?php require_once 'includes/footer.php'; ?>