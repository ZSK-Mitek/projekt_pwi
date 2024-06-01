<?php
require_once 'db.php';
require_once 'auth.php';


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserEmail($user_id) {
    global $link;
    $query = "SELECT email FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $email);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $email;
    }
    return null;
}

if (isLoggedIn()) {
    $_SESSION['email'] = getUserEmail($_SESSION['user_id']);
}



function isAdmin($link) {
    $user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'standard';
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        $query = "SELECT user_role FROM users WHERE id = ?";
        $statement = $link->prepare($query);
        $statement->bind_param('i', $user_id);
        $statement->execute();
        
        $statement->bind_result($user_role);
        $statement->fetch();

        if($user_role === 'admin') {
            return true;
        }
    }
    
    return false;
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
<html lang="pl">
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
        <nav class="nav-container">
            <a href="/index.php"><img src="/assets/images/logo.jpg" alt="Logo" width="60" height="auto"></a>
            <div class="nav-left">
                <a href="/index.php">Strona Główna</a>
            </div>
            <div class="nav-center">
                <?php if (isLoggedIn()): ?>
                    <a href="/user/reservations.php">Moje rezerwacje</a>
                    <a href="/user/account.php">Konto</a>
                    <?php if (isAdmin($link)): ?>
                        <a href="/admin/index.php">Panel Admina</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="nav-right">
                <?php if (isLoggedIn()): ?>
                    <a href="/contact-us.php">Kontakt</a>
                    <a href="/user/logout.php">Wyloguj</a>
                <?php else: ?>
                    <a href="/user/login.php">Zaloguj</a>
                    <a href="/user/register.php">Zarejestruj</a>
                    <a href="/contact-us.php">Kontakt</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
</body>
</html>
