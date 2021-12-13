<?php 
session_start();

if (isset($_POST['name']) && isset($_POST['sName']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['message'])) {
    
    $name = htmlentities($_POST['name']);
    $sName = htmlentities($_POST['sName']);    
    $email = htmlentities($_POST['email']);
    $tel = htmlentities($_POST['tel']);
    $message = htmlentities($_POST['message']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        require('db/db_connection.php');

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
    }
    else {
        $_SESSION['msg'] = 'Podany adres e-mail jest nieprawidłowy.';
    }
}

header('Location: '.$_SERVER['HTTP_REFERER']);
exit;