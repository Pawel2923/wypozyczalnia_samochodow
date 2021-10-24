<?php 
    if (isset($_SESSION['isLogged'])) 
    {
        if ($_SESSION['isLogged'])
            echo '<script src="logged.js"></script>';
    }
?>