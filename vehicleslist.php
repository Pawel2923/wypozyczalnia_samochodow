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
                        <h2>Lista pojazdów</h2>
                    </header>
                    <main>
                    <div class="cars">
                        <div class="car">
                            <div class="image-wrapper">
                                <img src="https://ireland.apollo.olxcdn.com/v1/files/eyJmbiI6IjByc3gyc3BrZzQ4YjMtT1RPTU9UT1BMIiwidyI6W3siZm4iOiJ3ZzRnbnFwNnkxZi1PVE9NT1RPUEwiLCJzIjoiMTYiLCJwIjoiMTAsLTEwIiwiYSI6IjAifV19.hXuoemts_h7soE7DwcsvGnYuHhVCV0y0sCWXJ0ZzIVE/image;s=732x488" alt="Zdjęcie samochodu" width="100%" height="100%">
                                <div class="img-overlay"></div>
                            </div>
                            <span class="car-name">Toyota Yaris</span>
                            <div class="divider"></div>
                            <div class="car-price">
                                <span>1 godz.</span>
                                <span>65,00 zł</span>
                            </div>
                            <button type="button">Dostępny</button>
                        </div>
                        <div class="car">
                            <div class="image-wrapper">
                                <img src="https://i.wpimg.pl/600x0/m.autokult.pl/ford-fusion-4-3ddb5b2d153e08d106.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                                <div class="img-overlay"></div>
                            </div>
                            <span class="car-name">Ford Fusion</span>
                            <div class="divider"></div>
                            <div class="car-price">
                                <span>1 godz.</span>
                                <span>55,00 zł</span>
                            </div>
                            <button type="button">Dostępny</button>
                        </div>
                        <div class="car">
                            <div class="image-wrapper">
                                <img src="https://www.auto-gazda.pl/application/files/8816/2861/3097/1.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                                <div class="img-overlay"></div>
                            </div>
                            <span class="car-name">Volkswagen Golf</span>
                            <div class="divider"></div>
                            <div class="car-price">
                                <span>1 godz.</span>
                                <span>65,00 zł</span>
                            </div>
                            <button type="button">Dostępny</button>
                        </div>
                        <div class="car">
                            <div class="image-wrapper">
                                <img src="https://image.ceneostatic.pl/data/products/95699167/i-mercedes-sprinter-313-2013-r.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                                <div class="img-overlay"></div>
                            </div>
                            <span class="car-name">Mercedes Sprinter</span>
                            <div class="divider"></div>
                            <div class="car-price">
                                <span>1 godz.</span>
                                <span>80,00 zł</span>
                            </div>
                            <button type="button">Dostępny</button>
                        </div>
                    </div>
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