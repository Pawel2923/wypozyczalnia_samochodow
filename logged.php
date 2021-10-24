<?php 
    if (isset($_SESSION['logged'])) 
    {
        if ($_SESSION['logged'])
        echo '<script src="logged.js"></script>';
    }
?>