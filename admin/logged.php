<?php 
    if (isset($_SESSION['isLogged'])) 
    {
        if ($_SESSION['isLogged'])
        {
            $url = $_SERVER['REQUEST_URI'];
            if (strpos($url, 'admin.php'))
            {
                echo '<script src="js/logged.js"></script>';
                echo "JEST OK ";
            }
            else 
            {
                echo '<script src="../js/logged.js"></script>';
                echo $url;
            }
        }
    }
?>