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
                public $rented_vehicles;
                public $name;
                public $unread;
    
                function setProperty($propertyName, $value) {
                    $this->$propertyName = $value;
                }
            };
            
            try {
                $login = $_SESSION['login'];
                $query = "SELECT * FROM profiles WHERE login=?";
    
                $stmt = $db_connection->prepare($query);
                $stmt->bind_param("s", $login);
                $stmt->execute();
                $result = $stmt->get_result();
                $array = $result->fetch_array();
                $stmt->close();
                $db_connection->close();
    
                $userProfile = new Profile;
                foreach ($array as $key => $value) {
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