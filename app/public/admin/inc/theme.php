<?php
if (isset($_POST['theme'])) {
    if ($_POST['theme'] != "default")
        echo '<link rel="stylesheet" href="../styles/' . $_POST['theme'] . '.css">';
} elseif (isset($_COOKIE['theme'])) {
    if ($_COOKIE['theme'] != "default")
        echo '<link rel="stylesheet" href="../styles/' . $_COOKIE['theme'] . '.css">';
}
