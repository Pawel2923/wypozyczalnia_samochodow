<?php 
//Dodanie skryptu logged.js w zależności od ścieżki
if (isset($_SESSION['isLogged'])) {
    if ($_SESSION['isLogged']) {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (strpos($path, 'admin.php'))
            echo '<script src="js/logged.js"></script>';
        else 
            echo '<script src="../js/logged.js"></script>';
    }
}