<?php
session_start();

if (isset($_SESSION['admin_name'])) {
    header('Location: ./');
    die;
}

if (isset($_POST['login'], $_POST['username'], $_POST['pass'])) {
    include '../include/db.php';

    $uname = $_POST['username'];
    $pass = $_POST['pass'];

    $adminData = findAdminById($uname);

    if ($adminData) {
        $hashedPass = hash('sha256', $pass);

        if ($hashedPass === $adminData['password']) {
            $_SESSION['admin_name'] = $adminData['name'];
            header('Location: ./');
            die;
        }
    }
}

$title = 'Panel administracyjny | Logowanie';
?>

<!doctype html>
<html lang="pl">
<?php
require_once '../include/head.php';
?>
<body>
<div>
    <div>
        <div>
            <div>
                <div>
                    <div>
                        <h1>Zaloguj się do panelu</h1>
                        <?= hash('sha256', 'admin') ?>
                    </div>
                    <div>
                        <form method="post">
                            <div>
                                <label for="username">Login</label>
                                <input type="text" id="username" name="username" required autocomplete="off">
                            </div>
                            <div>
                                <label for="password">Hasło</label>
                                <input type="password" id="password" name="pass" required autocomplete="off">
                            </div>
                            <button name="login">Zaloguj się</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
