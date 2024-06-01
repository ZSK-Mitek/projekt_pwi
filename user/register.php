<?php
require_once '../includes/header.php';

function isUsernameTaken($username) {
    global $pdo;
    $query = "SELECT COUNT(*) as count FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

function isEmailTaken($email) {
    global $pdo;
    $query = "SELECT COUNT(*) as count FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $errors = array();

    if (isUsernameTaken($username)) {
        $errors['username'] = "Nazwa użytkownika jest zajęta.";
    }

    if (isEmailTaken($email)) {
        $errors['email'] = "Email jest już zajęty.";
    }

    if (empty($errors)) {
        if (registerUser($username, $email, $password)) {
            if (loginUser($username, $password)) {
                if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin/index.php");
                } else {
                    header("Location: ../user/index.php");
                }
                exit;
            } else {
                echo "Logowanie nie powiodło się.";
            }
        } else {
            echo "Rejestracja nie powiodła się.";
        }
    }
}
?>

<form action="register.php" method="post">
    <label for="username">Nazwa użytkownika: <input type="text" name="username" id="username" required value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>"></label>
    <?php if(isset($errors['username'])) { echo "<span style='color:red;'>{$errors['username']}</span><br>"; } ?>
    
    <label for="email">E-mail: <input type="email" name="email" id="email" required value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"> </label>
    
    <?php if(isset($errors['email'])) { echo "<span style='color:red;'>{$errors['email']}</span><br>"; } ?>
    
    <label for="password">Hasło:</label>
    <input type="password" name="password" id="password" required>
    <br>
    
    <button type="submit">Zarejestruj</button>
</form>
<?php require_once '../includes/footer.php'; ?>