<?php
require_once '../includes/header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>
<h1>User Dashboard</h1>
<ul>
    <li><a href="reservations.php">My Reservations</a></li>
    <li><a href="account.php">Account</a></li>
</ul>
<?php require_once '../includes/footer.php'; ?>
