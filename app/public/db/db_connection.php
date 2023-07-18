<?php
require('db_data.php');

try {
    if (isset($_SESSION['connectionError'])) {
        unset($_SESSION['connectionError']);
    }
    $db_connection = new PDO($dsn, $db_user, $db_password, $options);
} catch (PDOException $Exception) {
    $_SESSION['connectionError'] = "Błąd połączenia z bazą danych";
}
