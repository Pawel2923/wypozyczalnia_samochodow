<?php
require_once("./initial.php");
if (isset($_SESSION['isLogged'])) {
    if (!$_SESSION['isLogged']) {
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

if (isset($_POST['password']) && isset($_POST['password-confirm']) && isset($_SESSION['login'])) {
    $newPasswd = htmlentities($_POST['password']);
    $confirmPasswd = htmlentities($_POST['password-confirm']);

    try {
        require('db/db_connection.php');
        $query = "SELECT id FROM users WHERE login=?";
        $stmt = $db_connection->prepare($query);
        $stmt->bind_param('s', $_SESSION['login']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        ($result->num_rows == 1) ? $id = $result->fetch_row() : $_SESSION['error'] = 'Takiego loginu nie ma w bazie danych.';

        if (isset($id)) {
            $id = $id[0];
            $query = "SELECT password FROM users WHERE id=?";
            $stmt = $db_connection->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $hashedPasswd = $result->fetch_row();
            $hashedPasswd = $hashedPasswd[0];
            $stmt->close();

            if ($newPasswd === $confirmPasswd) {
                $newHashedPasswd = password_hash($newPasswd, PASSWORD_DEFAULT, array('cost' => 10));
                $query = "UPDATE users SET password=?, change_passwd=0 WHERE id=?";
                $stmt = $db_connection->prepare($query);
                $stmt->bind_param('si', $newHashedPasswd, $id);
                $stmt->execute();

                if ($db_connection->affected_rows == 1) {
                    $_SESSION['msg'] = 'Pomyślnie zmieniono hasło...';
                    session_destroy();
                    echo '<script src="js/changeLocation.js" class="script-changeLocation" id="3000" value="login.php"></script>';
                } else
                    $_SESSION['error'] = 'Nie udało się zmienić hasła.';
            } else
                $_SESSION['error'] = 'Hasła nie są takie same.';
        }

        $db_connection->close();
    } catch (Exception $error) {
        $error = addslashes($error);
        $error = str_replace("\n", "", $error);
        $consoleLog->show = true;
        $consoleLog->content = $error;
        $consoleLog->is_error = true;
    } catch (mysqli_sql_exception $error) {
        $consoleLog->show = true;
        $consoleLog->content = $error;
        $consoleLog->is_error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Paweł Poremba">
    <meta name="description" content="Wypożycz samochód szybko i wygodnie, sprawdź kiedy masz zwrócić samochód i wiele więcej funkcji.">
    <meta name="keywords" content="samochód, auto, wypożyczalnia, wypożycz, szybko, wygodnie, łatwo, duży wybór, polska">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wypożyczalnia samochodów</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="Shortcut Icon" href="./img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
</head>

<body>
    <div class="back">
        <i class="fas fa-times"></i>
    </div>
    <main>
        <div class="header-wrapper">
            <header>
                <h1>Zmień swoje hasło</h1>
            </header>
        </div>
        <div class="form-wrapper">
            <form action="" method="POST">
                <div class="password">
                    <label for="password-field">Nowe hasło</label>
                    <br>
                    <input type="password" name="password" id="password-field" minlength="4" required>
                </div>
                <div class="password-confirm">
                    <label for="password-field-confirm">Potwierdź hasło</label>
                    <br>
                    <input type="password" name="password-confirm" id="password-field-confirm" minlength="4" required>
                </div>
                <div class="form-bottom">
                    <button type="submit">Zmień</button>
                </div>
            </form>
            <div class="message">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </div>
            <div class="error">
                <?php
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
                ?>
            </div>
        </div>
    </main>
    <script src="js/loginHandler.js"></script>
    <?php
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
</body>

</html>