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

    if (isset($_POST['vehicle-brand']) && isset($_POST['vehicle-model']) && isset($_POST['vehicle-price']) && isset($_POST['is-available']))
    {
        if (isset($_SESSION['vehicle-img-name']))
        {
            $brand = htmlentities($_POST['vehicle-brand']);
            $model = htmlentities($_POST['vehicle-model']);
            $price = htmlentities($_POST['vehicle-price']);
            $avail = htmlentities($_POST['is-available']);
            if ($avail == 0 || $avail == 'false' || $avail == 'off' || empty($avail))
                $avail = 0;
            else 
                $avail = 1;

            $img = "img/".$_SESSION['vehicle-img-name'];
            unset($_SESSION['vehicle-img-name']);

            require('../db/db_connection.php');

            $query = "INSERT INTO vehicles (marka, model, cena, img_url, is_available) VALUES(?, ?, ?, ?, ?)";
            $stmt = $db_connection->prepare($query);
            $stmt->bind_param('ssdsi', $brand, $model, $price, $img, $avail);
            $stmt->execute();

            $_SESSION['msg'] = 'Pomyślnie dodano nowy pojazd.';

            $stmt->close();
            $db_connection->close();
        }
        else
        {
            $_SESSION['msg'] = 'Nie udało się dodać pojazdu';
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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        input {
            border: 2px solid #000;
        }
        .content .vehicles header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
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
        main form label,
        main form button {
            margin-top: 20px;
        }
        main form label:first-child {
            margin-top: 0;
        }
        @media screen and (max-width: 800px) {
            .content .vehicles header>* {
                margin-right: 10px;
            }
        }
    </style>
    <?php 
        if (isset($_POST['theme']))
        {
            echo '<link rel="stylesheet" href="../styles/'.$_POST['theme'].'.css">';
        }
        elseif (isset($_COOKIE['theme']))
        {
            echo '<link rel="stylesheet" href="../styles/'.$_COOKIE['theme'].'.css">';
        }
    ?>
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
                            <h2>Dodawanie nowych pojazdów</h2>
                        </header>
                        <section>
                            <form action="upload.php" method="POST" enctype="multipart/form-data">
                                <label>Wybierz zdjęcie samochodu</label>
                                <input type="file" name="vehicle-img" id="vehicle-img" accept="image/png, image/jpg, image/jpeg, image/gif" required>
                                <button type="submit">Prześlij zdjęcie</button>
                            </form>
                            <form action="" method="POST">
                                <label>Marka pojazdu</label>
                                <input type="text" name="vehicle-brand" required>
                                <label>Model pojazdu</label>
                                <input type="text" name="vehicle-model" required>
                                <label>Cena</label>
                                <input type="text" name="vehicle-price" placeholder="np. 59,59" required>
                                <label>Ustaw dostępność do rezerwacji (Opcjonalne)</label>
                                <input type="text" name="is-available" placeholder="Wpisz 0 jeśli nie lub 1 jeśli tak">
                                <button type="submit">Dodaj</button>
                            </form>
                        </section>
                        <?php 
                            if (isset($_SESSION['msg']))
                            {
                                echo '<script>alert("'.$_SESSION['msg'].'");</script>';
                                unset($_SESSION['msg']);
                            }
                        ?>
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
        const checkInput = (name) => {
            name.addEventListener('invalid', () => {
                name.classList.add('subscription-input-invalid');
            });
            name.addEventListener('keyup', () => {
                name.classList.remove('subscription-input-invalid');
            });
        };
        const input = document.querySelectorAll('main form input');
        for (let i=0; i<input.length; i++) {
            checkInput(input[i]);
        }
    </script>
    <?php include_once('logged.php'); ?>
</body>
</html>