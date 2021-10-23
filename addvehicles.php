<?php 
    session_start(); 
    if (!$_SESSION['logged'] && !$_SESSION['adminMode']) {
        header('Location: index.php');
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
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/admin.css">
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        .content .vehicles header {
            display: flex;
            align-items: center;
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

        @media screen and (max-width: 800px) {
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
                    <a href="admin.php"><li>Home</li></a>
                    <a class="veh-link" href="admin.php#vehicles"><li>Pojazdy</li></a>
                    <a class="users-link" href="admin.php#users"><li>Użytkownicy</li></a>
                    <a class="settings-link" href="admin.php#settings"><li>Ustawienia</li></a>
                </ul>
            </div>
            <div class="back"><i class="fas fa-angle-double-left"></i> <a href="index.php">Wyjdź</a></div>
        </nav>
        <div class="content">
            <div class="mobile-nav">
                <div class="open"><i class="fas fa-bars"></i></div>
                <div class="user">
                    <a href="login.php" class="login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="login-caption">Zaloguj się</span>
                    </a>
                    <a href="admin.php" class="logged">
                        <i class="fas fa-user"></i>
                        <span class="login-caption"><?php echo $_SESSION['login'] ?></span>
                    </a>
                </div>
                <div class="overlay"></div>
            </div>
            <div class="all-settings">
                <header>
                    <h1><a href="admin.php">Panel administracyjny</a></h1>
                    <div class="user">
                        <a href="login.php" class="login">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="login-caption">Zaloguj się</span>
                        </a>
                        <a href="admin.php" class="logged">
                            <i class="fas fa-user"></i>
                            <span class="login-caption"><?php echo $_SESSION['login'] ?></span>
                        </a>
                    </div>
                </header>
                <div class="vehicles">
                    <header>
                        <h2><a href="admin.php#vehicles">Pojazdy</a></h2> 
                        <i class="fas fa-chevron-right"></i> 
                        <h2>Dodawanie nowych pojazdów</h2>
                    </header>
                    <main>
                        Andrzej
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
    <script src="adminHandler.js"></script>
    <?php 
        if ($_SESSION['logged'])
            echo '<script src="logged.js"></script>';
    ?>
</body>
</html>