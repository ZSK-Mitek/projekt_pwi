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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_dark_mode = isset($_POST['dark_mode']) ? 1 : 0;
    $current_password = trim($_POST['current_password']);
    
    // Pobierz hasło z bazy danych
    $query = "SELECT password FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stored_password);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        if (password_verify($current_password, $stored_password)) {
            // Aktualizuj dane użytkownika w bazie danych
            $query = "UPDATE users SET username = ?, email = ?, dark_mode = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($link, $query)) {
                mysqli_stmt_bind_param($stmt, "ssii", $new_username, $new_email, $new_dark_mode, $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                
                // Aktualizuj dane w sesji
                $_SESSION['username'] = $new_username;
                $_SESSION['email'] = $new_email;
                $_SESSION['dark_mode'] = $new_dark_mode;
                
                // Przeładuj stronę
                header("Refresh:0");
            } else {
                echo "Error updating user data.";
            }
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Error fetching user data.";
    }
}
?>
<form action="account.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
    <label for="dark_mode">Dark Mode:</label>
    <input type="checkbox" name="dark_mode" id="dark_mode" <?php echo $dark_mode ? 'checked' : ''; ?>>
    <label for="current_password">Current Password:</label>
    <input type="password" name="current_password" id="current_password" required>
    <button type="submit">Update</button>
</form>
<?php require_once '../includes/footer.php'; ?>
