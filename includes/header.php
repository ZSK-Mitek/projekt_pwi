<?php
require_once 'db.php';
require_once 'auth.php';

// Sprawdzenie czy klucz 'user_role' jest ustawiony w sesji, jeśli nie, ustaw domyślną wartość na 'standard'
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'standard';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    // Sprawdzenie czy klucz 'user_id' i 'user_role' są ustawione w sesji oraz czy 'user_role' ma wartość 'admin'
    return isset($_SESSION['user_id'], $_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function userDarkMode() {
    if (isLoggedIn()) {
        global $link;
        $query = "SELECT dark_mode FROM users WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $dark_mode);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
            return $dark_mode;
        }
    }
    return 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rezerwacja Obiektów</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php if (userDarkMode()): ?>
        <link rel="stylesheet" href="/assets/css/darkmode.css">
    <?php endif; ?>
</head>
<body>
    <header>
        <nav>
            <a href="/index.php">Strona Główna</a>
            <?php if (isLoggedIn()): ?>
                <a href="/user/reservations.php">Moje rezerwacje</a>
                <a href="/user/account.php">Konto</a>
                <a href="/user/logout.php">Wyloguj</a>
                <?php if (isAdmin()): ?>
                    <a href="/admin/index.php">Panel Admina</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="/user/login.php">Zaloguj</a>
                <a href="/user/register.php">Zarejestruj</a>
            <?php endif; ?>
        </nav>
        <form action="/search.php" method="get">
            <input type="text" name="query" placeholder="Wyszukaj...">
            <button type="submit">Szukaj</button>
        </form>
    </header>
