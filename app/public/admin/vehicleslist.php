<?php
require_once("../initial.php");
if (isset($_SESSION['isLogged']) && isset($_SESSION['isAdmin'])) {
    if (!$_SESSION['isAdmin']) {
        header('Location: ../index.php');
        exit;
    }
} else {
    header('Location: ../login.php');
    exit;
}

//Stworzenie cookie dla tryby wyświetlania pojazdów
if (isset($_GET['view-mode'])) {
    if ($_GET['view-mode'] == "cards")
        setcookie('vehList-viewMode', "cards", time() + (5 * 365 * 24 * 60 * 60));
    elseif ($_GET['view-mode'] == "list")
        setcookie('vehList-viewMode', "list", time() + (5 * 365 * 24 * 60 * 60));
    elseif ($_GET['view-mode'] == "table")
        setcookie('vehList-viewMode', "table", time() + (5 * 365 * 24 * 60 * 60));
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
    <link rel="stylesheet" href="styles/vehiclelist.css">
    <link rel="Shortcut Icon" href="../img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
    <?php include_once("./inc/theme.php") ?>
</head>

<body>
    <div class="page-wrapper">
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <li><a href="../admin.php">Home</a></li>
                    <li><a class="veh-link" href="../admin.php#vehicles">Pojazdy</a></li>
                    <li><a class="users-link" href="../admin.php#users">Użytkownicy</a></li>
                    <li><a href="../admin/inbox.php">Wiadomości</a></li>
                    <li><a class="settings-link" href="../admin.php#settings">Ustawienia</a></li>
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
                        <?php include("../inc/logged-menu.php"); ?>
                    </div>
                </div>
                <div class="overlay"></div>
            </div>
            <div class="all-settings">
                <header>
                    <h1><a href="../admin.php">Panel administracyjny</a></h1>
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
                    <div class="vehicles">
                        <header>
                            <h2><a href="../admin.php#vehicles">Pojazdy</a></h2>
                            <i class="fas fa-chevron-right"></i>
                            <h2>Lista pojazdów</h2>
                        </header>
                        <form class="view" method="GET">
                            <label>
                                <select name="view-mode">
                                    <option value="cards">Karty</option>
                                    <option value="list">Lista</option>
                                    <option value="table">Tabela</option>
                                </select>
                            </label>
                            <button type="submit"></button>
                        </form>
                        <section>
                            <div class="cars">
                                <?php
                                require('../inc/veh.php');
                                if (isset($vehicle)) {
                                    if (isset($_GET['view-mode'])) {
                                        if ($_GET['view-mode'] == "cards")
                                        {
                                            $options = new PrintOptions();
                                            $options->index = true;
                                            $options->available = false;
                                            printCarInfo($options);
                                        }
                                        elseif ($_GET['view-mode'] == "list")
                                        {
                                            $options = new PrintOptions();
                                            $options->method = PrintMethod::List;
                                            $options->index = true;
                                            $options->available = false;
                                            printCarInfo($options);
                                        }
                                        elseif ($_GET['view-mode'] == "table")
                                        {
                                            $options = new PrintOptions();
                                            $options->method = PrintMethod::Table;
                                            $options->index = true;
                                            $options->available = false;
                                            printCarInfo($options);
                                        }
                                    } else {
                                        if (isset($_COOKIE['vehList-viewMode'])) {
                                            if ($_COOKIE['vehList-viewMode'] == "cards")
                                            {
                                                $options = new PrintOptions();
                                                $options->index = true;
                                                $options->available = false;
                                                printCarInfo($options);
                                            }
                                            elseif ($_COOKIE['vehList-viewMode'] == "list") {
                                                $options = new PrintOptions();
                                                $options->method = PrintMethod::List;
                                                $options->index = true;
                                                $options->available = false;
                                                printCarInfo($options);
                                            } elseif ($_COOKIE['vehList-viewMode'] == "table")
                                            {
                                                $options = new PrintOptions();
                                                $options->method = PrintMethod::Table;
                                                $options->index = true;
                                                $options->available = false;
                                                printCarInfo($options);
                                            }
                                        } else {
                                            $options = new PrintOptions();
                                            $options->index = true;
                                            $options->available = false;
                                            printCarInfo($options);
                                        }
                                    }
                                } else
                                    echo 'W bazie nie ma żadnych pojazdów.';
                                ?>
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
    if (isset($_GET['view-mode']))
        echo '<script src="js/viewMode.js" type="module" value="' . $_GET['view-mode'] . '"></script>';
    elseif (isset($_COOKIE['vehList-viewMode']))
        echo '<script src="js/viewMode.js" type="module" value="' . $_COOKIE['vehList-viewMode'] . '"></script>';
    ?>
    <?php include_once('./inc/logged.php'); ?>
</body>

</html>