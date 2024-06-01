<?php
require_once './includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_SESSION['user_id']) ? $_SESSION['email'] : trim($_POST['email']);
    $message = trim($_POST['message']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    if (!empty($email) && !empty($message)) {
        $query = "INSERT INTO contact_messages (user_id, email, message) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "iss", $user_id, $email, $message);
            if (mysqli_stmt_execute($stmt)) {
                echo "Wiadomość wysłana pomyślnie.";
            } else {
                echo "Wiadomość nie została wysłana.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Proszę wypełnić wszystkie pola.";
    }
}
?>

<h1>Kontakt</h1>
<form action="contact-us.php" method="post">
    <?php if (!isset($_SESSION['user_id'])): ?>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
    <?php else: ?>
        <p>E-mail: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <?php endif; ?>
    <label for="message">Wiadomość:</label>
    <textarea name="message" id="message" required></textarea>
    <button type="submit">Wyślij</button>
</form>

<?php require_once './includes/footer.php'; ?>