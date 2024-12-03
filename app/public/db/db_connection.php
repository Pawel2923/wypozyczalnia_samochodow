<?php
global $db_connection;
try  {
    if (isset($_SESSION['connectionError'])) {
        unset($_SESSION['connectionError']);
    }
    
    $driver = "mysql";
    $dsnParams = [
        "dbname" => $_ENV["DB_NAME"],
        "host" => $_ENV["DB_HOST"],
        "port" => $_ENV["DB_PORT"]
    ];
    $options = [
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    $dsn = $driver . ":dbname=" . $dsnParams["dbname"] . ";host=" . $dsnParams["host"] . ";port=" . $dsnParams["port"];

    $db_connection = PDO::connect($dsn, $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $options);
}
catch (PDOException $error) {
    $_SESSION['connectionError'] = "Błąd połączenia z bazą danych";
    echo $error->getMessage();
    var_dump($error);
}