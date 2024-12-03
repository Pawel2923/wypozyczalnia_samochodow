<?php
require_once("./initial.php");

if (isset($_POST['name']) && isset($_POST['sName']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['message']) || isset($_SESSION['forgotten-passwd'])) {
    if (isset($_SESSION['forgotten-passwd'])) {
        unset($_SESSION['forgotten-passwd']);
        $login = $_SESSION['passwd-login'];
        unset($_SESSION['passwd-login']);

        $name = ' ';
        $sName = ' ';
        $email = "noreply@wyposamochodow.localhost";
        $tel = 0;
        $message = 'Użytkownik o loginie lub adresie e-mail: <b>' . $login . '</b> prosi o zresetowanie hasła.';
    } else {
        $name = htmlentities($_POST['name']);
        $sName = htmlentities($_POST['sName']);
        $email = htmlentities($_POST['email']);
        $tel = htmlentities($_POST['tel']);
        $message = htmlentities($_POST['message']);
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            require('db/db_connection.php');

            if (isset($db_connection)) {
                $query = "SELECT login FROM admins";
                $stmt = $db_connection->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch();
                $sentTo = $result["login"];

                $date = date('Y-m-d H:i:s');

                $query = "INSERT INTO messages VALUES(DEFAULT, :message, :name, :sName, :email, :tel, :date)";
                $stmt = $db_connection->prepare($query);
                $stmt->bindParam('message', $message);
                $stmt->bindParam('name', $name);
                $stmt->bindParam('sName', $sName);
                $stmt->bindParam('email', $email);
                $stmt->bindParam('tel', $tel);
                $stmt->bindParam('date', $date);
                $stmt->execute();

                $query = "SELECT login FROM users WHERE email=:email";
                $stmt = $db_connection->prepare($query);
                $stmt->bindParam('email', $email);
                $stmt->execute();
                $result = $stmt->fetch();
                $username = $result["login"];

                if ($username != '') {
                    $direction = "out";
                    $query = "INSERT INTO mailboxes VALUES(DEFAULT, :id, :username, :direction)";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bindParam('id', $messageID, PDO::PARAM_INT);
                    $stmt->bindParam('username', $username);
                    $stmt->bindParam('direction', $direction);
                    $stmt->execute();
                }

                for ($i = 0; $i < sizeof($sentTo); $i++) {
                    $direction = "in";
                    $query = "INSERT INTO mailboxes VALUES(DEFAULT, :id, :username, :direction)";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bindParam('id', $messageID);
                    $stmt->bindParam('username', $sentTo[$i]);
                    $stmt->bindParam('direction', $direction);
                    $stmt->execute();
                }

                $_SESSION['msg'] = 'Dziękujemy za wysłanie wiadomości. Prosimy oczekiwać na odpowiedź. <a href="index.php">Powróć na stronę główną</a>';

                $db_connection = null;
            } else {
                throw new Exception("Nie udało połączyć się z bazą danych");
            }
        } catch (Exception $error) {
            $error = addslashes($error);
            $error = str_replace("\n", "", $error);
            $consoleLog->show = true;
            $consoleLog->content = $error;
            $consoleLog->is_error = true;
            $_SESSION['error'] = $error;
        } catch (PDOException $error) {
            $consoleLog->show = true;
            $consoleLog->content = $error;
            $consoleLog->is_error = true;
            $_SESSION['error'] = $error;
        }
    } else
        $_SESSION['msg'] = 'Podany adres e-mail jest nieprawidłowy.';
}

if (isset($consoleLog)) {
    if ($consoleLog->show) {
        if ($consoleLog->is_error) {
            echo '<script src="js/log.js" value="' . $consoleLog->content . '" name="error"></script>';
        } else {
            echo '<script src="js/log.js" value="' . $consoleLog->content . '" name="log"></script>';
        }
    }
}
?>

<?php
header('Location: pricing.php');
exit;
