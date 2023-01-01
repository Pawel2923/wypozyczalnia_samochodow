<?php
session_start();
if (isset($_SESSION['isLogged']) && isset($_SESSION['isAdmin'])) {
    if (!$_SESSION['isAdmin']) {
        header('Location: ../index.php');
        exit;
    }
} else {
    header('Location: ../login.php');
    exit;
}

if (isset($_SESSION['vehicle-img-name'])) {
    if (!file_exists("../img/" . $_SESSION['vehicle-img-name']))
        unset($_SESSION['vehicle-img-name']);
}

include_once("../inc/consoleMessage.php");

if (isset($_POST['vehicle-brand']) && isset($_POST['vehicle-model']) && isset($_POST['vehicle-price']) && isset($_POST['is-available']) && isset($_POST['vehicle-description'])) {
    if (isset($_SESSION['vehicle-img-name'])) {
        $brand = htmlentities($_POST['vehicle-brand']);
        $model = htmlentities($_POST['vehicle-model']);
        $price = htmlentities($_POST['vehicle-price']);
        $avail = htmlentities($_POST['is-available']);
        $description = NULL;

        if (strlen($_POST['vehicle-description']) > 0) {
            $description = htmlentities($_POST['vehicle-description']);
        }

        if ($avail == 0 || $avail == 'false' || $avail == 'off' || empty($avail))
            $avail = 0;
        else
            $avail = 1;

        $img = $_SESSION['vehicle-img-name'];
        unset($_SESSION['vehicle-img-name']);

        try {
            require('../db/db_connection.php');

            $query = "SELECT COUNT(id) FROM vehicles";
            $stmt = $db_connection->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $vehicleID = $result->fetch_row();
            $vehicleID = $vehicleID[0] + 1;
            $stmt->close();

            $query = "INSERT INTO vehicles VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db_connection->prepare($query);

            if ($stmt !== false) {
                $stmt->bind_param('issdsis', $vehicleID, $brand, $model, $price, $img, $avail, $description);

                if ($stmt->execute())
                    $_SESSION['msg'] = 'Pomyślnie dodano nowy pojazd.';
                else
                    $_SESSION['msg'] = 'Nie udało się dodać pojazdu.';
            } else {
                throw new Exception("Statement's value is false.Query's value is: $query");
            }

            $stmt->close();
            $db_connection->close();
        } catch (Exception $error) {
            $error = addslashes($error);
            $error = str_replace("\n", "", $error);
            $consoleLog->show = true;
            $consoleLog->content = $error;
            $consoleLog->is_error = true;
        } catch (mysqli_sql_exception $error) {
            $consoleLog->show = true;
            $consoleLog->content = $error;
            $consoleLog->is_error = true;
        }
    } else {
        $_SESSION['msg'] = 'Nie udało się pobrać zdjęcia.';
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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        .uploaded-wrapper {
            display: none;
            max-width: 60%;
        }

        .uploaded-wrapper > div {
            display: flex;
            align-items: center;
        }
        
        .uploaded-wrapper > button {
            margin-top: 1rem;
            width: 50%;
        }

        .uploaded-wrapper .img-check {
            display: none;
            color: #60b8ff;
            font-size: 1.5em;
            margin-left: 0.5rem;
        }

        img {
            margin-top: 10px;
            margin-bottom: 10px;
            max-width: 50%;
        }
    </style>
    <?php include_once("./inc/theme.php") ?>
</head>

<body>
    <div class="page-wrapper">
        <?php include_once("../inc/message.php"); ?>
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <a href="../admin.php">
                        <li>Home</li>
                    </a>
                    <a class="veh-link" href="../admin.php#vehicles">
                        <li>Pojazdy</li>
                    </a>
                    <a class="users-link" href="../admin.php#users">
                        <li>Użytkownicy</li>
                    </a>
                    <a href="../admin/inbox.php">
                        <li>Wiadomości</li>
                    </a>
                    <a class="settings-link" href="../admin.php#settings">
                        <li>Ustawienia</li>
                    </a>
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
                            <h2>Dodawanie nowych pojazdów</h2>
                        </header>
                        <section>
                            <form action="upload.php" method="POST" enctype="multipart/form-data" name="vehicleImg">
                                <label for="vehicle-img">Wybierz zdjęcie samochodu*</label>
                                <input type="file" name="vehicle-img" id="vehicle-img" accept="image/jpg image/jpeg image/gif image/png image/webp image/avif image/bmp image/xbm" required>
                                <label for="vehicle-img-name">Zmień nazwę pliku</label>
                                <input type="text" name="vehicle-img-name" id="vehicle-img-name" />
                                <button type="submit">Prześlij zdjęcie</button>
                            </form>
                            <div class="uploaded-wrapper">
                                <div>
                                    <h3>Zdjęcie zostało wybrane</h3>
                                    <i class="fas fa-check-circle img-check"></i>
                                </div>
                                <button>Usuń obecne zdjęcie</button>
                            </div>
                            <figure class="image-msg">
                                <?php
                                if (isset($_SESSION['vehicle-img-name'])) {
                                    echo '<figcaption>Wybrane zdjęcie: <b>' . basename($_SESSION['vehicle-img-name']) . '</b></figcaption>';
                                    echo '<img src="' . $_SESSION['vehicle-img-name'] . '" alt="Zdjęcie wybranego samochodu">';
                                }
                                ?>
                            </figure>
                            <form action="" method="POST">
                                <label for="vehicle-brand">Marka pojazdu*</label>
                                <input type="text" name="vehicle-brand" required>
                                <label for="vehicle-model">Model pojazdu*</label>
                                <input type="text" name="vehicle-model" required>
                                <label for="vehicle-price">Cena*</label>
                                <input type="text" name="vehicle-price" placeholder="np. 59,59" required>
                                <label for="is-available">Ustaw dostępność do rezerwacji</label>
                                <input type="text" name="is-available" placeholder="Wpisz 0 jeśli nie lub 1 jeśli tak">
                                <label for="vehicle-description">Dodaj opis pojazdu</label>
                                <textarea name="vehicle-description"></textarea>
                                <button type="submit">Dodaj</button>
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
                    <div class="bottom-text">&copy;2022 by Paweł Poremba</div>
                </section>
            </footer>
        </div>
    </div>
    <script src="../js/panelHandler.js"></script>
    <script>
        const forbiddenChars = [".", "\\", "/", ":", "*", "<", ">", "|"];
        const vehicleImgNameInput = document.querySelector("input[name='vehicle-img-name']");

        vehicleImgNameInput.addEventListener("blur", (ev) => {
            for (let char of forbiddenChars) {
                if (ev.target.value.includes(char)) {
                    ev.target.setCustomValidity(`Nazwa nie może zawierać znaku: ${char}`);
                    break;
                } else
                    ev.target.setCustomValidity("");
            }
        });

        const checkInput = (name) => {
            name.addEventListener('invalid', () => {
                name.classList.add('subscription-input-invalid');
            });
            name.addEventListener('keyup', () => {
                name.classList.remove('subscription-input-invalid');
            });
        };
        const input = document.querySelectorAll('main form input');
        for (let i = 0; i < input.length; i++) {
            checkInput(input[i]);
        }
        <?php
        if (isset($_SESSION['vehicle-img-name']))
            echo '
            document.querySelector(".img-check").style.display = "block";
            document.querySelector(".uploaded-wrapper").style.display = "block";
            document.forms.vehicleImg.style.display = "none";
            document.querySelector(".uploaded-wrapper > button").addEventListener("click", () => {
                window.location.pathname = window.location.pathname.replace("/addvehicles.php", "/deleteimg.php");
            });
            ';
        ?>
    </script>
    <?php
    include_once('./inc/logged.php');
    if (isset($consoleLog)) {
        if ($consoleLog->show) {
            if ($consoleLog->is_error) {
                echo '<script>console.error("' . $consoleLog->content . '")</script>';
            } else {
                echo '<script>console.log("' . $consoleLog->content . '")</script>';
            }
        }
    }
    ?>
</body>

</html>