<?php
require_once 'includes/header.php';
?>
<main>
    <h1>Dostępne Obiekty</h1>
    <ul>
        <?php
        $query = "SELECT id, name, description FROM facilities";
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_assoc($result)): ?>
            <li><a href="facility.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></a></li>
        <?php endwhile; ?>
    </ul>
</main>
<?php require_once 'includes/footer.php'; ?>