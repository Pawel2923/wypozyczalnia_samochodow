<?php 
    require('db_logind_data.php');

    mysqli_report(MYSQLI_REPORT_STRICT);
    try 
    {
        $db_connection = new mysqli($host, $user, $password, $db_name);
    }
    catch (mysqli_sql_exception $error)
    {
        $_SESSION['connectionError'] = "Błąd połączenia z bazą danych";
        header('Location: ../login.php');
        exit;
    }
?>