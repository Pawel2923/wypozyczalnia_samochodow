<?php session_start(); ?>
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
            <form action="login.php" method="POST">
                <div class="login">
                    <label for="login-field">Login lub adres e-mail</label>
                    <br>
                    <input type="text" name="login" id="login-field" required>
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
            </form>
        </div>
    </main>
    <script src="loginHandler.js"></script>
    <script>
        document.querySelector('.back').addEventListener('click', () => {
            window.location = './index.php';
        });
        passwdCheck();
    </script>
    <?php 
        if (isset($_SESSION['login'])) 
        {
            header('Location:index.php');
            exit;
        }
    ?>
</body>
</html>