<?php

if (isset($_POST['theme']))
    echo '<script src="js/theme.js" value="'.$_POST['theme'].'"></script>';
elseif (isset($_COOKIE['theme']))
    echo '<script src="js/theme.js" value="'.$_COOKIE['theme'].'"></script>';
