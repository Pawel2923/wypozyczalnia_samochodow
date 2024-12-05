<?php
global $db_connection;
if (isset($_SESSION['login'])) {
    $path = $_SERVER['REQUEST_URI'];
    if (str_contains($path, '/inc'))
        require('../db/db_connection.php');
    else
        require('db/db_connection.php');

    class Profile {
        public string|int $id;
        public string $login;
        public string $name;
        public int $rented_vehicles;
        public int $unread;

        function setProperty($propertyName, $value): void
        {
            $this->$propertyName = $value;
        }
    }

    try {
        $login = $_SESSION['login'];
        $query = "SELECT * FROM profiles WHERE login=:login";

        $stmt = $db_connection->prepare($query);
        $stmt->bindParam("login", $login);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result === false) {
            throw new Exception("Invalid login");
        }

        $userProfile = new Profile;
        foreach ($result as $key => $value) {
            $userProfile->setProperty($key, $value);
        }
        $db_connection = null;
    }
    catch (Exception $error) {
        $_SESSION['connectionError'] = "Błąd ".$error;
    }
}