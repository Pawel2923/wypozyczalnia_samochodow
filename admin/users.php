<?php 
    session_start(); 
    if (!$_SESSION['isLogged'] && !$_SESSION['isAdmin']) {
        header('Location: login.php');
        exit;
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
        .content .vehicles header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            -webkit-box-pack: start;
                -ms-flex-pack: start;
                    justify-content: flex-start;
        }
        .content .vehicles header>* {
            margin-right: 20px;
        }
        .content .vehicles header>*:last-child {
            margin-right: 0;
        }
        .content .vehicles header>* a {
            color: #000;
        }
        main .cars {
            display: -ms-grid;
            display: grid;
            -ms-grid-rows: auto;
            -ms-grid-columns: 1fr 20px 1fr 20px 1fr;
                grid-template: auto / 1fr 1fr 1fr;
            -webkit-column-gap: 20px;
            -moz-column-gap: 20px;
                    column-gap: 20px;
            row-gap: 20px;
        }
        main .cars .car {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            border: 1px solid #000;
            width: -webkit-fit-content;
            width: -moz-fit-content;
            width: fit-content;
            overflow: hidden;
        }
        main .car .image-wrapper {
            width: 100%;
            height: 100%;
            position: relative;
            cursor: pointer;
        }
        main .car .img-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, .4);
            z-index: 1;
            opacity: 0;
            -webkit-transition: opacity .2s ease;
            -o-transition: opacity .2s ease;
            transition: opacity .2s ease;
        }
        main .car .img-overlay:hover {
            opacity: 1;
        }
        main .cars .car>span {
            margin-top: 5%;
            margin-bottom: 5%;
        }
        main .car-price {
            margin-top: 5%;
            margin-bottom: 5%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
        }
        main .car-price span {
            margin-top: 10px;
        }
        main .car-price span:first-child {
            margin-top: 0;
        }
        main .car .car-name {
            font-weight: 400;
        }
        main .car .divider {
            width: 80%;
            height: 2px;
            background: #000;
        }
        main .car button {
            width: 80%;
            margin-bottom: 5%;
        }
        @media screen and (max-width: 800px) {
            main .cars {
                -ms-grid-rows: 1fr 1fr 1fr;
                -ms-grid-columns: auto;
                    grid-template: 1fr 1fr 1fr / auto;
            }
            .content .vehicles header>* {
                margin-right: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <a href="../admin.php"><li>Home</li></a>
                    <a class="veh-link" href="../admin.php#vehicles"><li>Pojazdy</li></a>
                    <a class="users-link" href="../admin.php#users"><li>Użytkownicy</li></a>
                    <a class="settings-link" href="../admin.php#settings"><li>Ustawienia</li></a>
                </ul>
            </div>
            <div class="back">
                <a href="index.php">
                    <i class="fas fa-angle-double-left"></i> Wyjdź
                </a>
            </div>
        </nav>
        <div class="content">
            <div class="mobile-nav">
                <div class="open"><i class="fas fa-bars"></i></div>
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
                                    if (isset($_SESSION['isAdmin'])) 
                                    {
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
                            <div class="logged-menu">
                                <ul>
                                    <?php
                                        if (isset($_SESSION['isAdmin'])) 
                                        {
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
                <div class="vehicles">
                    <header>
                        <h2><a href="../admin.php#users">Użytkownicy</a></h2> 
                        <i class="fas fa-chevron-right"></i> 
                        <h2>Statystyki użytkowników</h2>
                    </header>
                    <main>
                        Ilość wypożyczonych aut etc.
                    </main>
                </div>
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