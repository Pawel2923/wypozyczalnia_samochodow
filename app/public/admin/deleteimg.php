<?php
session_start();
if ($_SESSION['vehicle-img-name']) {
    unlink($_SESSION['vehicle-img-name']);
    unset($_SESSION['vehicle-img-name']);
}

header('Location: addvehicles.php');
exit;
