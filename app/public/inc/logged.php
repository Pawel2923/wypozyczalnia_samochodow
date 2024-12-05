<?php 
    if (isset($_SESSION['isLogged'])) {
        if ($_SESSION['isLogged']) {
            echo '<script src="js/logged.js"></script>';

            if (isset($_SESSION['changePasswd'])) {
                if ($_SESSION['changePasswd']) {
                    header('Location: changePasswd.php');
                    exit;
                }
            }
        }
    }
