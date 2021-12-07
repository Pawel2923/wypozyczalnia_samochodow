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
        .image-wrapper {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
        }
        .vehicle-image {
            position: relative;
            cursor: pointer;
        }
        .vehicle-image img {
            display: block;
        }
        .vehicle-image>.img-overlay {
            background-color: rgba(0,0,0,.5);
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity .2s ease;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
        }
        .vehicle-image:hover .img-overlay {
            opacity: 1;
        }
        .add-img {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 8em;
            color: #ccc;
            border: 5px solid #ccc;
            transition: .2s ease;
        }
        .add-img:hover {
            border-color: #60B8FF;
            color: #60B8FF;
            cursor: pointer;
        }
        .upload {
            position: fixed;
            background-color: #fff;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: none;
        }
        .upload-status {
            display: none;
            position: fixed;
            top: calc(50% - 100px);
            left: calc(50% - 100px);
            background-color: #fff;
            padding: 50px;
            z-index: 4;
        }
        .upload-status>.back {
            width: fit-content;
            height: fit-content;
            right: 20px;
            top: 20px;
            left: unset;
            bottom: unset;
            transform: unset;
            cursor: pointer;
        }
        @media screen and (max-width: 800px) {
            .content .vehicles header>* {
                margin-right: 10px;
            }
            .image-wrapper {
                grid-template-columns: 1fr 1fr;
                gap: 5px;
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
    <div class="upload-status">
        <div class="back">
            <i class="fas fa-times"></i>
        </div>
        <div class="msg">
        <?php 
            if (isset($_SESSION['msg']))
            {
                echo '<script>document.querySelector(".upload-status").style.display = "block";</script>';
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>
        </div>
        <div class="error">
            <?php 
                if (isset($_SESSION['error']))
                {
                    echo '<script>document.querySelector(".upload-status").style.display = "block";</script>';
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
            ?>
        </div>
    </div>
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
                            <h2>Zdjęcia pojazdów</h2>
                        </header>
                        <section>
                            <div class="image-wrapper">
                                <?php 
                                    require('../db/db_connection.php');

                                    $query = "SELECT img_url FROM vehicles";
                                    $stmt = $db_connection->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $stmt->close();
                                    
                                    while ($row = $result->fetch_row())
                                    {
                                        if (filter_var($row[0], FILTER_VALIDATE_URL))
                                        {
                                            echo '<div class="vehicle-image">';
                                            echo '<img src="'.$row[0].'" alt="Zdjęcie pojazdu" width="100%" height="100%">';
                                            echo '<div class="img-overlay"><i class="fas fa-trash-alt"></i> Usuń zdjęcie</div>';
                                            echo '</div>';
                                        }
                                        else 
                                        {
                                            echo '<div class="vehicle-image"';
                                            echo '<img src="../img/'.$row[0].'" alt="Zdjęcie pojazdu" width="100%" height="100%">';
                                            echo '<div class="img-overlay"><i class="fas fa-trash-alt"></i> Usuń zdjęcie</div>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                                <div class="add-img">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                        </section>
                        <section class="upload">
                            <form action="upload.php" method="POST" enctype="multipart/form-data">
                                <label>Wybierz zdjęcie samochodu</label>
                                <div class="upload-wrapper">
                                    <input type="file" name="vehicle-img" id="vehicle-img" accept="image/png, image/jpg, image/jpeg, image/gif" required>
                                </div>
                                <button type="submit">Prześlij zdjęcie</button>
                            </form>
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
        <?php 
            if (isset($_SESSION['vehicle-img-name']))
                echo 'document.querySelector(".img-check").style.display = "block";';
        ?>
        document.querySelector('.add-img').addEventListener('click', () => {
            document.querySelector('.upload').style.display = "block";
            window.scrollTo(0, 0);
            document.body.style.overflow = 'hidden';
        });
    </script>
    <script>
        document.querySelector('.upload-status').addEventListener('click', () => {
            document.querySelector('.upload-status').style.display = "none";
        });
    </script>
    <?php include_once('logged.php'); ?>
</body>
</html>