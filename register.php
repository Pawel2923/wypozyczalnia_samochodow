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
                    echo "<script>console.log('Pomyślnie połączono z bazą')</script>";

                    // Sprawdzenie czy podany login lub email są już w bazie
                    $query = "SELECT `login`, `email` FROM `users` WHERE `login`=? OR `email`=?";

                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param("ss", $login, $email);
                    $stmt->execute();

                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->fetch_assoc() > 0) {
                        if (isset($email))
                            $_SESSION['login-error'] = "Podany email jest już zarejestrowany";
                        else
                            $_SESSION['login-error'] = "Podany login jest już zarejestrowany";
                    } else {
                        // Ustawienie id użytkownika
                        $query = "SELECT COUNT(id) FROM users";
                        $stmt = $db_connection->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $userID = $result->fetch_row();
                        $userID = $userID[0] + 1;
                        $stmt->close();
                        // Wprowadzanie danych do bazy
                        if (isset($email)) {
                            $query = "INSERT INTO `users` (id, login, email, password) VALUES(?, ?, ?, ?)";

                            $stmt = $db_connection->prepare($query);
                            $stmt->bind_param("isss", $userID, $login, $email, $hashedPasswd);
                            $stmt->execute();
                            $stmt->close();
                        } else {
                            $query = "INSERT INTO `users` (id, login, password) VALUES(?, ?, ?)";

                            $stmt = $db_connection->prepare($query);
                            $stmt->bind_param("iss", $userID, $login, $hashedPasswd);
                            $stmt->execute();
                            $stmt->close();
                        }
                        $db_connection->close();

                        header('Location: login.php');
                        exit;
                    }
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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
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
    <script>
        document.querySelector('.back').addEventListener('click', () => {
            window.location = './index.php';
        });
        passwdCheck();
    </script>
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