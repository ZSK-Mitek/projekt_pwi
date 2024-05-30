<?php
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (loginUser($username, $password)) {
        header("Location: ../index.php");
    } else {
        echo "Login failed.";
    }
}
?>
<form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Login</button>
</form>

<?php
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT id, username, password, user_role FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $db_username, $db_password, $user_role);
        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $db_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['user_role'] = $user_role;

                if ($user_role === 'admin') {
                    header("Location: ../admin/index.php");
                } else {
                    header("Location: ../user/index.php");
                }
                exit;
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User not found.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in database query.";
    }
}
?>

<?php require_once '../includes/footer.php'; ?>


