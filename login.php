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
                </div>
                <div class="password">
                    <label for="password-field">Hasło</label>
                    <br>
                    <input type="password" name="password" id="password-field" required>
                    <a href="passwd.php" class="forgotten-password">Zapomniałeś hasła?</a>
                </div>
                <div class="form-bottom">
                    <button type="submit">Zaloguj się</button>
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
        if (isset($_POST['login']) && isset($_POST['password']))
        {
            if (!empty($_POST['login']) && !empty($_POST['password']))   // Sprawdzenie czy zmienne login i password istnieją i nie są puste
            {
                require('db/db_connection.php'); // Ustanowienie połączenia z bazą danych

                $login = htmlentities(trim($_POST['login']));
                $password = htmlentities(trim($_POST['password'])); // Zadeklarowanie zmiennych login i password, przygotowanie wartości

                // Sprawdzenie czy login występuje w bazie danych oraz czy podany login ma przypisane takie hasło wraz z zabezpieczeniem przed
                // SQL injection
                $query = "SELECT * FROM `users_login` WHERE '$login'=login OR '$login'=email";

                $_SESSION['login'] = $_POST['login']; // Dodanie zmiennej sesyjnej login i isLogged i isAdmin
            }
        }
    ?>
</body>
</html>