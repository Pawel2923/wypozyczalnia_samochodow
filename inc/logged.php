<?php 
    if (isset($_SESSION['isLogged'])) 
    {
        if ($_SESSION['isLogged'])
            echo '<script src="js/logged.js"></script>';
    }
?>