<?php
require_once("./initial.php");
if (isset($_POST['login'])) {
    if (!empty($login = htmlentities($_POST['login']))) {
        $_SESSION['forgotten-passwd'] = true;
        $_SESSION['passwd-login'] = $login;
        header('Location: send.php');
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
    <link rel="Shortcut Icon" href="./img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
</head>

<body>
    <div class="back">
        <i class="fas fa-times"></i>
    </div>
    <main>
        <?php include_once("./inc/message.php"); ?>
        <div class="header-wrapper">
            <header>
                <h1>Zresetuj zapomniane hasło</h1>
            </header>
        </div>
        <div class="form-wrapper">
            <form action="" method="POST">
                <div class="login">
                    <label for="login-field">Wpisz adres e-mail lub login</label>
                    <br>
                    <input type="text" name="login" id="login-field" minlength="4" required>
                </div>
                <div class="form-bottom">
                    <button type="submit">Potwierdź</button>
                </div>
            </form>
        </div>
    </main>
    <script src="js/loginHandler.js"></script>
    <script src="js/message.js"></script>
</body>

</html>