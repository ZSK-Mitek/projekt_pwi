<?php
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (registerUser($username, $email, $password)) {
        // Logowanie użytkownika po udanej rejestracji
        if (loginUser($username, $password)) {
            // Pomyślne zalogowanie użytkownika, przekierowanie na odpowiednią stronę
            if ($_SESSION['user_role'] === 'admin') {
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../user/index.php");
            }
            exit;
        } else {
            // Błąd logowania
            echo "Login failed.";
        }
    } else {
        echo "Registration failed.";
    }
}
?>
<form action="register.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Register</button>
</form>
<?php require_once '../includes/footer.php'; ?>