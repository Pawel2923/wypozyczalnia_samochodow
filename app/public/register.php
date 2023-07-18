<?php
session_start();
if (isset($_SESSION['isLogged'])) {
    if ($_SESSION['isLogged']) {
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['password']) && isset($_POST['login']) && isset($_POST['password-confirm'])) {
    if (!empty($_POST['password']) && isset($_POST['login']) && isset($_POST['password-confirm'])) {
        if ($_POST['password'] === $_POST['password-confirm']) {
            // Przygotowanie loginu
            $login = htmlentities(trim($_POST['login']));
            // Przygotowanie adresu email
            if (filter_var($login, FILTER_VALIDATE_EMAIL)) { // Sprawdzenie czy login jest adresem email
                $email = filter_var($login, FILTER_SANITIZE_EMAIL);
                $login = explode('@', $login);
                $login = array_shift($login);
            }
            // Przygotowanie hasła
            $password = htmlentities(trim($_POST['password']));
            $newHashedPasswd = password_hash($newPasswd, PASSWORD_DEFAULT, array('cost' => 10));

            try {
                // Połączenie z bazą danych
                require('db/db_connection.php');

                if (!isset($_SESSION['connectionError'])) {
                    // Sprawdzenie czy podany login lub email są już w bazie
                    $query = "SELECT `login`, `email` FROM `users` WHERE `login`=? OR `email`=?";

                    $stmt = $db_connection->prepare($query);
                    $stmt->bindParam("login", $login);
                    $stmt->bindParam('email', $email);
                    $stmt->execute();

                    $result = $stmt->fetch(PDO::FETCH_OBJ);

                    if ($result->fetch(PDO::FETCH_ASSOC) > 0) {
                        if (isset($email))
                            $_SESSION['login-error'] = "Podany email jest już zarejestrowany";
                        else
                            $_SESSION['login-error'] = "Podany login jest już zarejestrowany";
                    } else {
                        // Ustawienie id użytkownika
                        $query = "SELECT COUNT(id) FROM users";
                        $stmt = $db_connection->prepare($query);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_OBJ);
                        $userID = $result->fetch();
                        $userID = $userID[0] + 1;
                        // Wprowadzanie danych do bazy
                        if (isset($email)) {
                            $query = "INSERT INTO `users` (id, login, email, password) VALUES(:userID, :login, :email, :passwd)";

                            $stmt = $db_connection->prepare($query);
                            $stmt->bindParam('userID', $userID, PDO::PARAM_INT);
                            $stmt->bindParam('login', $login);
                            $stmt->bindParam('email', $email);
                            $stmt->bindParam('passwd', $hashedPasswd);
                            $stmt->execute();
                        } else {
                            $query = "INSERT INTO `users` (id, login, password) VALUES(:userID, :login, :passwd)";

                            $stmt = $db_connection->prepare($query);
                            $stmt->bindParam('userID', $userID, PDO::PARAM_INT);
                            $smtt->bindParam('login', $login);
                            $smtt->bindParam('passwd', $hashedPasswd);
                            $stmt->execute();
                        }
                        $db_connection = null;

                        header('Location: login.php');
                        exit;
                    }
                    $db_connection = null;
                } else {
                    throw new Exception("Błąd połączenia z bazą danych.");
                }
            } catch (Exception $Exception) {
                $Exception = addslashes($Exception);
                $Exception = str_replace("\n", "", $Exception);
                $consoleLog->show = true;
                $consoleLog->content = $Exception;
                $consoleLog->is_error = true;
            } catch (PDOException $Exception) {
                $consoleLog->show = true;
                $consoleLog->content = $Exception;
                $consoleLog->is_error = true;
            }

            header('Location: register.php');
            exit;
        }
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
                <h1>Zarejestruj się</h1>
                <h3>Masz już konto? <a href="login.php">Zaloguj się</a></h3>
            </header>
        </div>
        <div class="form-wrapper">
            <form action="register.php" method="POST">
                <div class="login">
                    <label for="login-field">Login lub adres e-mail</label>
                    <br>
                    <input type="text" name="login" id="login-field" required>
                    <br>
                    <div class="warning">
                        <?php
                        if (isset($_SESSION['login-error'])) {
                            echo $_SESSION['login-error'];
                            unset($_SESSION['login-error']);
                        }
                        ?>
                    </div>
                </div>
                <div class="password">
                    <label for="password-field">Hasło</label>
                    <br>
                    <input type="password" name="password" id="password-field" minlength="4" required>
                </div>
                <div class="password-confirm">
                    <label for="password-field-confirm">Potwierdź hasło</label>
                    <br>
                    <input type="password" name="password-confirm" id="password-field-confirm" minlength="4" required>
                </div>
                <div class="form-bottom">
                    <button type="submit">Zarejestruj się</button>
                </div>
                <div class="error">
                    <?php
                    if (isset($_SESSION['connectionError'])) {
                        echo $_SESSION['connectionError'];
                        unset($_SESSION['connectionError']);
                    }
                    ?>
                </div>
            </form>
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