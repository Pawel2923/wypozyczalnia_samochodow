<?php 
    session_start();

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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        .message-wrapper {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
            z-index: 3;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .message {
            background-color: #fff;
            border: 1px solid #000;
            position: absolute;
            padding: 50px;
            max-width: 55%;
            z-index: 1;
            display: flex;
            text-align: center;
        }

        .message-wrapper>.overlay {
            content: '';
            background-color: rgba(0,0,0,.5);
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .message-wrapper .close {
            position: absolute;
            top: 6px;
            right: 10px;
            font-size: 1.5em;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="back">
        <i class="fas fa-times"></i>
    </div>
    <main>
        <div class="message-wrapper" <?php if (isset($_SESSION['msg'])) echo 'style="display: flex;"'?>>
            <div class="overlay"></div>
            <div class="message">
                <div class="close"><i class="fas fa-times"></i></div>
                <div class="msg">
                    <?php 
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                </div>
            </div>
        </div>
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
    <script>
        document.querySelector('.back').addEventListener('click', () => {
            window.location = './index.php';
        }); 
        const msgCloseButton = document.querySelector('.message .close');
        const msgWrapper = document.querySelector('.message-wrapper');
        const msgOverlay = document.querySelector('.message-wrapper .overlay');

        if (msgCloseButton != null && msgWrapper != null && msgOverlay != null) {
            msgCloseButton.addEventListener('click', () => {
                msgWrapper.style.display = 'none';
            });
            msgOverlay.addEventListener('click', () => {
                msgWrapper.style.display = 'none';
            });
        }
    </script>
    <script src="js/loginHandler.js"></script>
</body>
</html>