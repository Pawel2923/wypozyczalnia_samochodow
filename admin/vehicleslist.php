<?php 
    session_start();
    $exit = false;
    if (isset($_SESSION['isLogged']) && isset($_SESSION['isAdmin']))
    {
        if (!$_SESSION['isLogged'] && !$_SESSION['isAdmin']) {
            $exit = true;
        }
    }
    else 
        $exit = true;

    if ($exit)
    {
        header('Location: login.php');
        exit;
    }

    if (isset($_GET['view-mode']))
    {
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
                                    if (isset($_SESSION['login'])) 
                                    {
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
                <main>
                    <div class="vehicles">
                        <header>
                            <h2><a href="../admin.php#vehicles">Pojazdy</a></h2> 
                            <i class="fas fa-chevron-right"></i> 
                            <h2>Lista pojazdów</h2>
                        </header>
                        <form class="view" method="GET">
                            <select name="view-mode">
                                <option value="cards">Karty</option>
                                <option value="list">Lista</option>
                                <option value="table">Tabela</option>
                            </select>
                            <input type="submit" style="display: none;">
                        </form>   
                        <section>         
                            <div class="cars">
                                <?php 
                                    $logAsAdmin = true;
                                    require('../inc/veh.php');
                                    if (isset($vehicle))
                                    {
                                        if (isset($_GET['view-mode']))
                                        {
                                            if ($_GET['view-mode'] == "cards")
                                                printCarInfo("availabilityCheck", $vehNum, $vehicle, true);
                                            elseif ($_GET['view-mode'] == "list")
                                                printCarInfoList("availabilityCheck", $vehNum, $vehicle, true);
                                            elseif ($_GET['view-mode'] == "table")
                                                printCarInfoTable($vehNum, $vehicle);
                                        }
                                        else 
                                        {
                                            if (isset($_COOKIE['vehList-viewMode']))
                                            {
                                                if ($_COOKIE['vehList-viewMode'] == "cards")
                                                    printCarInfo("availabilityCheck", $vehNum, $vehicle, true);
                                                elseif ($_COOKIE['vehList-viewMode'] == "list")
                                                    printCarInfoList("availabilityCheck", $vehNum, $vehicle, true);
                                                elseif ($_COOKIE['vehList-viewMode'] == "table")
                                                    printCarInfoTable($vehNum, $vehicle);
                                                }
                                            else 
                                                printCarInfo("availabilityCheck", $vehNum, $vehicle, true);
                                        }
                                    }
                                    else 
                                    {
                                        echo 'W bazie nie ma żadnych pojazdów.';
                                    }
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
                    <div class="bottom-text">&copy;2021 by Paweł Poremba</div>
                </section>
            </footer>
        </div>
    </div>
    <script src="../js/panelHandler.js"></script>
    <script>
        const viewMode = document.querySelector('select[name="view-mode"]');
        viewMode.addEventListener('change', () => {
            viewMode.form.submit();
        });

        const changeView = (mode) => {
            document.querySelector('main select option[value="'+mode+'"]').setAttribute('selected', 'selected');
            if (mode == "list")
                document.querySelector('.cars').classList.add('cars-list');
        }
        // document.querySelector('button.car-button').addEventListener('click', () => {
        //     <?php 
                
        //     ?>
        // });
    </script>
    <?php 
        if (isset($_GET['view-mode']))
            echo '<script>changeView("'.$_GET['view-mode'].'");</script>';
        elseif (isset($_COOKIE['vehList-viewMode']))
            echo '<script>changeView("'.$_COOKIE['vehList-viewMode'].'");</script>';
    ?>
    <?php include_once('logged.php'); ?>
</body>
</html>