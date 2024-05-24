<?php
    $title = 'Strona główna';
    $activePage = 'home';
    require_once './include/functions.php';
?>
<!DOCTYPE html>
<html lang="pl">
<?php
require_once './include/head.php';
?>
<body>
    <div>
        <?php
            require_once './include/nav.php'
        ?>
        <div>
            <?php
                echo renderHeader($title, 1);
            ?>
        </div>
        <?php
        require_once './include/footer.php'
        ?>
    </div>
</body>
</html>