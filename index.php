<?php require_once 'includes/header.php'; ?>
<main>
    <h1>Dostępne Obiekty</h1>
    <form action="/search.php" method="get" class="search-form">
        <input type="text" name="query" placeholder="Wyszukaj...">
        <button type="submit">Szukaj</button>
    </form>
    <div class="facilities-container">
        <?php
        $query = "SELECT id, name, description, image_path FROM facilities";
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="facility">
                <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                <img src="<?php echo $row['image_path']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <a href="facility.php?id=<?php echo $row['id']; ?>">Zobacz więcej</a>
            </div>
        <?php endwhile; ?>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>