<?php
global $db_connection, $consoleLog;
require_once($_SERVER['DOCUMENT_ROOT'] . "/initial.php");
if (isset($_SESSION['isLogged'])) {
    if (!$_SESSION['isLogged']) {
        header('Location: ../login.php');
        exit;
    }
} else {
    header('Location: ../login.php');
    exit;
}

if (isset($_POST['password']) && isset($_POST['password-confirm']) && isset($_SESSION['login'])) {
    $newPasswd = htmlentities($_POST['password']);
    $confirmPasswd = htmlentities($_POST['password-confirm']);

    try {
        require('../db/db_connection.php');
        $query = "SELECT id FROM users WHERE login=:login";
        $stmt = $db_connection->prepare($query);
        $stmt->bindParam('login', $_SESSION['login']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        ($stmt->rowCount() == 1) ? $id = $result->fetch() : $_SESSION['error'] = 'Takiego loginu nie ma w bazie danych.';

        if (isset($id)) {
            $id = $id[0];
            $query = "SELECT password FROM users WHERE id=:id";
            $stmt = $db_connection->prepare($query);
            $stmt->bindParam('id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $hashedPasswd = $result->fetch();
            $hashedPasswd = $hashedPasswd[0];

            if (password_verify($newPasswd, $hashedPasswd))
                $_SESSION['error'] = 'Nowe hasło nie powinno być takie samo jak stare hasło.';
            else {
                if ($newPasswd === $confirmPasswd) {
                    $newHashedPasswd = password_hash($newPasswd, PASSWORD_DEFAULT, array('cost' => 10));
                    $query = "UPDATE users SET password=:password WHERE id=:id";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bindParam('password', $newHashedPasswd);
                    $stmt->bindParam('id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                    if ($stmt->rowCount() == 1) {
                        $_SESSION['msg'] = 'Pomyślnie zmieniono hasło. Za chwilę wystąpi wylogowanie...';
                        echo '<script src="../js/changeLocation.js" class="script-changeLocation" id="5000" value="../logout.php"></script>';
                    } else
                        $_SESSION['error'] = 'Nie udało się zmienić hasła.';
                } else
                    $_SESSION['error'] = 'Hasła nie są takie same.';
            }
        }

        $db_connection = null;
    } catch (PDOException $error) {
        $consoleLog->show = true;
        $consoleLog->content = $error;
        $consoleLog->is_error = true;
    } catch (Exception $error) {
        $error = addslashes($error);
        $error = str_replace("\n", "", $error);
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
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/panel.css">
    <link rel="Shortcut Icon" href="../img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
    <?php
    if (isset($_POST['theme'])) {
        if ($_POST['theme'] != "default")
            echo '<link rel="stylesheet" href="styles/' . $_POST['theme'] . '.css">';
    } elseif (isset($_COOKIE['theme'])) {
        if ($_COOKIE['theme'] != "default")
            echo '<link rel="stylesheet" href="styles/' . $_COOKIE['theme'] . '.css">';
    }
    ?>
</head>

<body>
    <div class="page-wrapper">
        <?php include_once("../inc/message.php"); ?>
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <li><a href="../user.php">Home</a></li>
                    <li><a class="veh-link" href="../user.php#vehicles">Pojazdy</a></li>
                    <li><a class="profile-link" href="../user.php#profile">Edytuj profil</a></li>
                    <li><a class="settings-link" href="../user.php#settings">Ustawienia</a></li>
                </ul>
            </div>
            <div class="back">
                <a href="../index.php">
                    <i class="fas fa-angle-double-left"></i> Wyjdź
                </a>
            </div>
        </nav>
        <div class="content">
            <div class="mobile-nav">
                <div class="open"><i class="fas fa-bars"></i></div>
                <div class="user">
                    <a href="login.php" class="login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="login-caption">Zaloguj się</span>
                    </a>
                    <div class="logged">
                        <div class="mobile-logged-menu-overlay"></div>
                        <i class="fas fa-user"></i>
                        <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                        <?php include("../inc/logged-menu.php") ?>
                    </div>
                </div>
                <div class="overlay"></div>
            </div>
            <div class="all-settings">
                <header>
                    <h1><a href="../user.php">Panel użytkownika</a></h1>
                    <div class="user">
                        <a href="../login.php" class="login">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="login-caption">Zaloguj się</span>
                        </a>
                        <div class="logged">
                            <i class="fas fa-user"></i>
                            <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                            <?php include("../inc/logged-menu.php"); ?>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="users">
                        <header>
                            <h2><a href="../user.php#profile">Edytuj swój profil</a></h2>
                            <i class="fas fa-chevron-right"></i>
                            <h2>Zmień hasło</h2>
                        </header>
                        <section>
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
                            </div>
                        </section>
                    </div>
                </main>
            </div>
            <footer>
                <section class="bottom-content">
                    <div class="footer-socials">
                        <i class="fab fa-facebook"></i>
                        <i class="fab fa-youtube"></i>
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                    <div class="bottom-text">&copy;2022 by Paweł Poremba</div>
                </section>
            </footer>
        </div>
    </div>
    <script src="../js/panelHandler.js"></script>
    <?php
    include_once('./logged.php');
    if (isset($consoleLog)) {
        if ($consoleLog->show) {
            if ($consoleLog->is_error) {
                echo '<script src="../js/log.js" value="' . $consoleLog->content . '" name="error"></script>';
            } else {
                echo '<script src="../js/log.js" value="' . $consoleLog->content . '" name="log"></script>';
            }
        }
    }
    ?>
    <script src="../js/loginHandler.js"></script>
</body>

</html>