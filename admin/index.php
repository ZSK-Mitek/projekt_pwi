<?php
require_once '../includes/header.php';

if (!isAdmin($link)) {
    header("Location: ../index.php");
    exit;
}
?>
<h1>Admin Panel</h1>
<ul>
    <?php $query = "SELECT * FROM facilities"; ?>
    <form action="add_facility.php" method="go" >
        <button type="no_hej">Dodaj Obiekt</button>
    </form>

    <form action="add_sector.php" method="go" >
        <button type="no_hej">Dodaj Sektor</button>
    </form>
</ul>
<?php require_once '../includes/footer.php'; ?>
