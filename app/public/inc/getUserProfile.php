<?php
    if (isset($_SESSION['login'])) {
        $path = $_SERVER['REQUEST_URI']; 
        if (strpos($path, '/inc') !== false)
            require('../db/db_connection.php');
        else 
            require('db/db_connection.php');

        if (!isset($_SESSION['connectionError'])) {
            class Profile {
                public $id;
                public $login;
                public $name;
                public $rented_vehicles;
                public $unread;
    
                function setProperty($propertyName, $value) {
                    $this->$propertyName = $value;
                }
            };
            
            try {
                $login = $_SESSION['login'];
                $query = "SELECT * FROM profiles WHERE login=:login";
    
                $stmt = $db_connection->prepare($query);
                $stmt->bindParam("login", $login);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                $db_connection = null;
    
                $userProfile = new Profile;
                foreach ($result as $key => $value) {
                    $userProfile->setProperty($key, $value);
                }
            } catch (Exception $error) {
                $_SESSION['connectionError'] = "Błąd ".$error;
                header('Location: login.php');
                exit;
            }
        }
    }
?>