<?php 
    session_start();
    if (isset($_SESSION['isLogged'])) {
        if (!$_SESSION['isLogged']) {
            header('Location: ../login.php');
            exit;
        }
    }
    else  {
        header('Location: ../login.php');
        exit;
    }

    if (isset($_POST['new-login']) && isset($_SESSION['login'])) {
        $login = htmlentities($_SESSION['login']);
        $newLogin = htmlentities($_POST['new-login']);

        if ($login !== $newLogin) {
            require('../db/db_connection.php');

            $query = "SELECT COUNT(id) FROM users WHERE login=?";
            $stmt = $db_connection->prepare($query);
            $stmt->bind_param('s', $newLogin);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $checkLogin = $result->fetch_row();
            $checkLogin = $checkLogin[0];

            if ($checkLogin != 1) {
                $query = "SELECT id FROM users WHERE login=?";
                $stmt = $db_connection->prepare($query);
                $stmt->bind_param('s', $_SESSION['login']);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                
                if ($result->num_rows == 1) {
                    $id = $result->fetch_row();
                    $id = $id[0];
                    $query = "UPDATE users SET login=? WHERE id=?";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param('si', $newLogin, $id);
                    $stmt->execute();
                    $stmt->close();

                    $_SESSION['msg'] = 'Pomyślnie zmieniono login. Za chwilę wystąpi wylogowanie...';
                    echo '<script>
                        setTimeout(() => {
                            window.location = "../logout.php";
                        }, 5000);
                    </script>';
                }
                else 
                    $_SESSION['error'] = 'Takiego loginu nie ma w bazie danych.';
            }
            else 
                $_SESSION['error'] = 'Taki login jest już zajęty.';

            $db_connection->close();
        }
        else 
            $_SESSION['error'] = 'Nowy login jest taki sam jak stary.';
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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        input {
            border: 2px solid #000;
        }
        .content .users header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
        }
        .content .users header>* {
            margin-right: 20px;
        }
        .content .users header>*:last-child {
            margin-right: 0;
        }
        .content .users header>* a {
            color: #000;
        }
        main form {
            width: 60%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
        }
        main form button {
            margin-top: 20px;
        }
        @media screen and (max-width: 800px) {
            .content .users header>* {
                margin-right: 10px;
            }
        }
        main form input {
            margin-top: 5px;
        }
        main form>div {
            margin-top: 20px;
        }
        main form>div:first-child {
            margin-top: 0;
        }
    </style>
    <?php 
        if (isset($_POST['theme'])) {
            if ($_POST['theme'] != "default")
                echo '<link rel="stylesheet" href="styles/'.$_POST['theme'].'.css">';
        }
        elseif (isset($_COOKIE['theme'])) {
            if ($_COOKIE['theme'] != "default")
                echo '<link rel="stylesheet" href="styles/'.$_COOKIE['theme'].'.css">';
        }
    ?>
</head>
<body>
    <div class="page-wrapper">
        <div class="message-wrapper" <?php if (isset($_SESSION['msg']) || isset($_SESSION['error'])) echo 'style="display: block;"'?>>
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
                <div class="error">
                    <?php 
                        if (isset($_SESSION['error'])) {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        }
                    ?>
                </div>
            </div>
        </div>
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <a href="../user.php"><li>Home</li></a>
                    <a class="veh-link" href="../user.php#vehicles"><li>Pojazdy</li></a>
                    <a class="profile-link" href="../user.php#profile"><li>Edytuj profil</li></a>
                    <a class="settings-link" href="../user.php#settings"><li>Ustawienia</li></a>
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
                        <div class="logged-menu">
                            <ul>
                                <?php
                                    if (isset($_SESSION['login'])) {
                                        if ($_SESSION['isAdmin'])
                                            echo '<li><a href="admin.php">Panel administracyjny</a></li>';
                                    }
                                ?>
                                <li><a href="user.php">Panel użytkownika</a></li>
                                <li><a href="logout.php">Wyloguj się</a></li>
                            </ul>
                        </div>
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
                            <div class="logged-menu">
                                <ul>
                                    <?php
                                        if (isset($_SESSION['isAdmin'])) {
                                            if ($_SESSION['isAdmin'])
                                                echo '<li><a href="../admin.php">Panel administracyjny</a></li>';
                                        }
                                    ?>
                                    <li><a href="../user.php">Panel użytkownika</a></li>
                                    <li><a href="../logout.php">Wyloguj się</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="users">
                        <header>
                            <h2><a href="../user.php#profile">Edytuj swój profil</a></h2> 
                            <i class="fas fa-chevron-right"></i> 
                            <h2>Zmień login</h2>
                        </header>
                        <section>
                            <div class="form-wrapper">
                                <form action="" method="POST">
                                    <div class="new-login">
                                        <label for="new-login">Wpisz nowy login</label>
                                        <br>
                                        <input type="text" name="new-login" required>
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
                    <div class="bottom-text">&copy;2021 by Paweł Poremba</div>
                </section>
            </footer>
        </div>
    </div>
    <script src="../js/panelHandler.js"></script>
    <?php include_once('logged.php'); ?>
</body>
</html>