<?php
require_once '../includes/header.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (loginUser($username, $password)) {
        header("Location: ../index.php");
        exit;
    } else {
        $error_message = "Błędna nazwa użytkownika lub hasło";
    }
}
?>
<form action="login.php" method="post">
    <table>
        <tr>
            <td><label for="username">Nazwa użytkownika:</label></td>
            <td><input type="text" name="username" id="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td><label for="password">Hasło:</label></td>
            <td><input type="password" name="password" id="password" required></td>
        </tr>
        
        <tr>
            <td colspan="2"><button type="submit">Zaloguj</button></td>
        </tr>
        <tr>
        <?php if (!empty($error_message)) echo "<span style='color: red;'>$error_message</span>"; ?>
        </tr>
    </table>
    <p> Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
</form>

<?php require_once '../includes/footer.php'; ?>