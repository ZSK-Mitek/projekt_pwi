<?php
require_once '../includes/header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $hourly_rate = $_POST['hourly_rate'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $message = "Plik nie jest obrazem.";
        $uploadOk = 0;
    }

    if ($_FILES["image"]["size"] > 5000000) {
        $message = "Ten plik jest za duży.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $message = "Przepraszamy, dozwolone są tylko pliki JPG, JPEG i PNG.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $message = "Przepraszamy, Twój plik nie został przesłany.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;

            $stmt = $link->prepare("INSERT INTO facilities (name, description, image_path, hourly_rate) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssd", $name, $description, $image_path, $hourly_rate);

            if ($stmt->execute()) {
                $message = "<tr><td colspan='4'>Dodano obiekt.</td></tr>";
            } else {
                $message = "<tr><td colspan='4'>Error: " . $stmt->error . "</td></tr>";
            }

            $stmt->close();
        } else {
            $message = "<tr><td colspan='4'>Przepraszam, nastąpił błąd w przesyłaniu twojego pliku.</td></tr>";
        }
    }
}
?>

<form action="add_facility.php" method="post" enctype="multipart/form-data">
    <label for="name">Nazwa Obiektu</label>
    <input type="text" name="name" id="name" required>
    
    <label for="description">Opis</label>
    <textarea name="description" id="description" required></textarea>
    
    <label for="hourly_rate">Cena za 1h (w zł)</label>
    <input type="number" name="hourly_rate" id="hourly_rate" required min="0" step="0.01">
    
    <label for="image">Zdjęcie</label>
    <input type="file" name="image" id="image" accept="image/*" required>
    
    <button type="submit">Dodaj Obiekt</button>
</form>

<table align="center">
    <?php echo $message; ?>
</table>

<?php require_once '../includes/footer.php'; ?>