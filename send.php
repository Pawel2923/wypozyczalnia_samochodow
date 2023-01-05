<?php
session_start();
include_once("./inc/consoleMessage.php");

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
                $query = "SELECT COUNT(id) FROM messages";
                $stmt = $db_connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                $messageID = $result->fetch_row();
                $messageID = $messageID[0] + 1;

                $query = "SELECT login FROM admins";
                $stmt = $db_connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                $sentTo = $result->fetch_row();

                $date = date('Y-m-d H:i:s');

                $query = "INSERT INTO messages VALUES(?, ?, ?, ?, ?, ?, ?)";
                $stmt = $db_connection->prepare($query);
                $stmt->bind_param('issssis', $messageID, $message, $name, $sName, $email, $tel, $date);
                $stmt->execute();
                $stmt->close();

                $query = "SELECT login FROM users WHERE email=?";
                $stmt = $db_connection->prepare($query);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                $username = $result->fetch_row();
                $username = $username[0];

                if ($username != '') {
                    $direction = "out";
                    $query = "INSERT INTO mailboxes VALUES(NULL, ?, ?, ?)";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param('iss', $messageID, $username, $direction);
                    $stmt->execute();
                    $stmt->close();
                }

                for ($i = 0; $i < sizeof($sentTo); $i++) {
                    $direction = "in";
                    $query = "INSERT INTO mailboxes VALUES(NULL, ?, ?, ?)";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param('iss', $messageID, $sentTo[$i], $direction);
                    $stmt->execute();
                    $stmt->close();
                }

                $_SESSION['msg'] = 'Dziękujemy za wysłanie wiadomości. Prosimy oczekiwać na odpowiedź. <a href="index.php">Powróć na stronę główną</a>';

                $db_connection->close();
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
        } catch (mysqli_sql_exception $error) {
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
