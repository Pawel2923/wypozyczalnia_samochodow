<?php 
    session_start();
    if (isset($_SESSION['isLogged']))
    {
        if ($_SESSION['isLogged'])
        {
            header('Location:index.php');
            exit;
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
                    <div class="warning"></div>
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
                        if (isset($_SESSION['connectionError']))
                        {
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
        if (isset($_POST['password']) && isset($_POST['login']) && isset($_POST['password-confirm']))
        {
            if (!empty($_POST['password']) && isset($_POST['login']) && isset($_POST['password-confirm']))
            {
                if ($_POST['password'] === $_POST['password-confirm'])
                {
                    // Przygotowanie loginu
                    $login = htmlentities(trim($_POST['login']));
                    // Przygotowanie adresu email
                    if (filter_var($login, FILTER_VALIDATE_EMAIL)) // Sprawdzenie czy login jest adresem email
                    {
                        $email = filter_var($login, FILTER_SANITIZE_EMAIL);
                        $login = explode('@', $login);
                        $login = array_shift($login);
                    }
                    // Przygotowanie hasła
                    $password = htmlentities(trim($_POST['password']));
                    $hashedPasswd = password_hash($password, PASSWORD_DEFAULT);

                    // Połączenie z bazą danych
                    require('db/db_connection.php');

                    // Sprawdzenie czy podany login lub email są już w bazie
                    $query = "SELECT `login`, `email` FROM `users` WHERE `login`=? OR `email`=?";

                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param("ss", $login, $email);
                    $stmt->execute();

                    $result = $stmt->get_result();

                    if ($result->fetch_assoc() > 1)
                    {
                        if (isset($email)) 
                        {
                            $loginError = "Podany email jest już zarejestrowany";
                            echo '<script>
                                document.querySelector("form div.warning").textContent = "'.$loginError.'";
                                document.querySelector("#login-field").value = "'.$email.'";
                            </script>';
                        }
                        else 
                        {
                            $loginError = "Podany login jest niedostępny";
                            echo '<script>
                                document.querySelector("form div.warning").textContent = "'.$loginError.'";
                                document.querySelector("#login-field").value = "'.$login.'";
                            </script>';
                        }
                    }
                    else
                    {
                        // Wprowadzanie danych do bazy
                        if (isset($email))
                        {
                            $query2 = "INSERT INTO `users` (login, email, password) VALUES(?, ?, ?)";
    
                            $stmt2 = $db_connection->prepare($query2);
                            $stmt2->bind_param("sss", $login, $email, $hashedPasswd);
                            $stmt2->execute();
                            $stmt2->close();
                        }
                        else 
                        {
                            $query2 = "INSERT INTO `users` (login, password) VALUES(?, ?)";
    
                            $stmt2 = $db_connection->prepare($query2);
                            $stmt2->bind_param("ss", $login, $hashedPasswd);
                            $stmt2->execute();
                            $stmt2->close();
                        }
                        $stmt->close();
                        $db_connection->close();

                        header('Location: login.php');
                        exit;
                    }

                    $stmt->close();
                    $db_connection->close();
                }
            }
        }
    ?>
</body>
</html>