<?php
session_start();
if (isset($_SESSION['isLogged'])) {
    if ($_SESSION['isLogged']) {
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['login']) && isset($_POST['password'])) {
    if (!empty($_POST['login']) && !empty($_POST['password'])) { // Sprawdzenie czy zmienne login i password istnieją i nie są puste
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

        try {
            // Połączenie z bazą danych
            require('db/db_connection.php');

            if (!isset($_SESSION['connectionError'])) {
                // Sprawdzenie czy istnieje taki login/email
                $query = "SELECT `login`, `email` FROM `users` WHERE `login`=:login OR `email`=:email";

                $stmt = $db_connection->prepare($query);
                $stmt->bindParam('login', $login, PDO::PARAM_STR);
                $stmt->bindParam('email', $email, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_OBJ);

                if ($result) {
                    $getPasswd = "SELECT `password`, `is_admin`, `change_passwd` FROM `users` WHERE `login`=:login OR `email`=:email";

                    $stmt = $db_connection->prepare($getPasswd);
                    $stmt->bindParam('login', $login, PDO::PARAM_STR);
                    $stmt->bindParam('email', $email, PDO::PARAM_STR);
                    $stmt->execute();

                    $result2 = $stmt->fetch(PDO::FETCH_OBJ);

                    if ($result2->change_passwd) {
                        $_SESSION['login'] = $login;
                        $_SESSION['isLogged'] = true;

                        header('Location: changePasswd.php');
                        exit;
                    } else {
                        if (password_verify($password, $result2->password)) {
                            $_SESSION['login'] = $login;
                            $_SESSION['isLogged'] = true;
                            $_SESSION['isAdmin'] = $result2->is_admin;

                            $db_connection = null;

                            header('Location: index.php');
                            exit;
                        } else
                            $_SESSION['password-error'] = "Podane hasło jest nieprawidłowe";
                    }
                } else
                    $_SESSION['login-error'] = "Podany login lub e-mail jest nieprawidłowy";

                $db_connection = null;
            } else {
                throw new Exception("Błąd połączenia z bazą danych");
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
                <h1>Zaloguj się</h1>
                <h3>Nie masz konta? <a href="register.php">Zarejestruj się</a></h3>
            </header>
        </div>
        <div class="form-wrapper">
            <form action="login.php" method="POST">
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
                    <a href="forgotPasswd.php" class="forgotten-password">Zapomniałeś hasła?</a>
                    <br>
                    <div class="warning">
                        <?php
                        if (isset($_SESSION['password-error'])) {
                            echo $_SESSION['password-error'];
                            unset($_SESSION['password-error']);
                        }
                        ?>
                    </div>
                </div>
                <div class="form-bottom">
                    <button type="submit">Zaloguj się</button>
                </div>
                <br>
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