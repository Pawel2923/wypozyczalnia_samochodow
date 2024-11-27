<?php 
mysqli_report(MYSQLI_REPORT_STRICT);
try  {
    if (isset($_SESSION['connectionError'])) {
        unset($_SESSION['connectionError']);
    }
    $db_connection = new mysqli($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"], $_ENV["DB_PORT"]);
}
catch (mysqli_sql_exception $error) {
    $_SESSION['connectionError'] = "Błąd połączenia z bazą danych";
}