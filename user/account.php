<?php
require_once '../includes/header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT username, email, dark_mode FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $email, $dark_mode);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_dark_mode = isset($_POST['dark_mode']) ? 1 : 0;
    $current_password = trim($_POST['current_password']);
    
    $query = "SELECT password FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stored_password);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        if (password_verify($current_password, $stored_password)) {
            $query = "UPDATE users SET username = ?, email = ?, dark_mode = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($link, $query)) {
                mysqli_stmt_bind_param($stmt, "ssii", $new_username, $new_email, $new_dark_mode, $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                
                $_SESSION['username'] = $new_username;
                $_SESSION['email'] = $new_email;
                $_SESSION['dark_mode'] = $new_dark_mode;
                
                header("Refresh:0");
            } else {
                echo "Błąd aktualizowania danych użytkownika.";
            }
        } else {
            echo "Nieprawidłowe hasło.";
        }
    } else {
        echo "Błąd podczas pobierania danych użytkownika.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $query = "DELETE FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        session_destroy();
        header("Location: /user/login.php");
        exit;
    } else {
        echo "Błąd podczas usuwania konta.";
    }
}
?>

<form action="account.php" id="tabela_login" method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
    <label for="dark_mode">Dark Mode: <input type="checkbox" name="dark_mode" id="dark_mode" <?php echo $dark_mode ? 'checked' : ''; ?>></label>
    
    <label for="current_password">Obecne hasło:</label>
    <input type="password" name="current_password" id="current_password" required>
    <button type="submit" name="update">Zaktualizuj</button>
    
    <button type="submit" name="delete" class="delete-button">Usuń konto</button>
</form>

<?php require_once '../includes/footer.php'; ?>