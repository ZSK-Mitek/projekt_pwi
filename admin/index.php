<?php
require_once '../includes/header.php';

if (!isAdmin()) {
    header("Location: ../index.php");
    exit;
}
?>
<h1>Admin Panel</h1>
<ul>
    <?php $query = "SELECT * FROM facilities"; ?>
    <li><a href="add_facility.php">Add Facility</a></li>
    <li><a href="add_sector.php">Add Sector</a></li>
</ul>
<?php require_once '../includes/footer.php'; ?>
