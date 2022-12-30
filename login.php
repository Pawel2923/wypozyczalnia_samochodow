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
                echo "<script>console.log('Pomyślnie połączono z bazą')</script>";

                // Sprawdzenie czy istnieje taki login/email
                $query = "SELECT `login`, `email` FROM `users` WHERE `login`=? OR `email`=?";

                $stmt = $db_connection->prepare($query);
                $stmt->bind_param("ss", $login, $email);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->fetch_assoc()) {
                    $getPasswd = "SELECT `password`, `is_admin`, `change_passwd` FROM `users` WHERE `login`=? OR `email`=?";

                    $stmt2 = $db_connection->prepare($getPasswd);
                    $stmt2->bind_param("ss", $login, $email);
                    $stmt2->execute();

                    $result2 = $stmt2->get_result();

                    $queriedData = $result2->fetch_assoc();

                    if ($queriedData['change_passwd']) {
                        $_SESSION['login'] = $login;
                        $_SESSION['isLogged'] = true;

                        header('Location: changePasswd.php');
                        exit;
                    } else {
                        if (password_verify($password, $queriedData['password'])) {
                            $_SESSION['login'] = $login;
                            $_SESSION['isLogged'] = true;
                            $_SESSION['isAdmin'] = $queriedData['is_admin'];

                            $stmt->close();
                            $db_connection->close();

                            header('Location: index.php');
                            exit;
                        } else
                            $_SESSION['password-error'] = "Podane hasło jest nieprawidłowe";
                    }
                } else
                    $_SESSION['login-error'] = "Podany login lub e-mail jest nieprawidłowy";

                $stmt->close();
                $db_connection->close();
            } else {
                echo "<script>console.error('Błąd połączenia z bazą danych');</script>";
            }
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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
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
                    <a href="forgotpasswd.php" class="forgotten-password">Zapomniałeś hasła?</a>
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
    <script>
        document.querySelector('.back').addEventListener('click', () => {
            window.location = './index.php';
        });
    </script>
    <script src="js/loginHandler.js"></script>
    <?php
    if (isset($consoleLog)) {
        if ($consoleLog->show) {
            if ($consoleLog->is_error) {
                echo '<script>console.error("' . $consoleLog->content . '")</script>';
            } else {
                echo '<script>console.log("' . $consoleLog->content . '")</script>';
            }
        }
    }
    ?>
</body>

</html>