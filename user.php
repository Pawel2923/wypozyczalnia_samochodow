<?php
session_start();
if (isset($_SESSION['isLogged'])) {
    if (!$_SESSION['isLogged']) {
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

if (isset($_POST['theme'])) {
    $theme = htmlentities($_POST['theme']);
    if ($theme == "default" || $theme == "system" || $theme == "dark" || $theme == "light")
        setcookie('theme', $theme, time() + (5 * 365 * 24 * 60 * 60));
}

try {
    require('db/db_connection.php');

    $query = "SELECT id FROM users WHERE login=?";
    $stmt = $db_connection->prepare($query);
    $stmt->bind_param('s', $_SESSION['login']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows == 1) {
        $id = $result->fetch_row();
        $id = $id[0];
    }

    if (isset($_POST['name']) && isset($_POST['sName']) && isset($_POST['tel']) && isset($_POST['email'])) {
        $name = htmlentities($_POST['name']);
        $sName = htmlentities($_POST['sName']);
        $tel = htmlentities($_POST['tel']);
        $email = htmlentities($_POST['email']);

        if (isset($id)) {
            if (!empty($name)) {
                $query = "UPDATE users SET imie=? WHERE id=?";
                $stmt = $db_connection->prepare($query);
                $stmt->bind_param('si', $name, $id);
                $stmt->execute();
                $stmt->close();
            }
            if (!empty($sName)) {
                $query = "UPDATE users SET nazwisko=? WHERE id=?";
                $stmt = $db_connection->prepare($query);
                $stmt->bind_param('si', $sName, $id);
                $stmt->execute();
                $stmt->close();
            }
            if (!empty($tel)) {
                if (filter_var($tel, FILTER_VALIDATE_INT)) {
                    $query = "UPDATE users SET telefon=? WHERE id=?";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param('si', $tel, $id);
                    $stmt->execute();
                    $stmt->close();
                } else
                    $_SESSION['error'] = 'Wprowadzono niepoprawny numer telefonu';
            }
            if (!empty($email)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $query = "UPDATE users SET email=? WHERE id=?";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param('si', $email, $id);
                    $stmt->execute();
                    $stmt->close();
                } else
                    $_SESSION['error'] = 'Wprowadzono niepoprawny email';
            }

            if ($db_connection->affected_rows > 0)
                $_SESSION['msg'] = 'Zmiany zostały zapisane.';
            else
                $_SESSION['error'] = 'Nie udało się wprowadzić zmian.';
        } else
            $_SESSION['error'] = 'Takiego loginu nie ma w bazie danych.';
    }

    if (isset($id)) {
        $query = "SELECT imie, nazwisko, telefon, email FROM users WHERE id=?";
        $stmt = $db_connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();

        foreach ($userData as $key => $value) {
            if (empty($value))
                $userData[$key] = 'Brak danych';
        }
    }

    if (isset($_POST['rentID'])) {
        $rentID = htmlentities($_POST['rentID']);

        $query = "DELETE FROM rezerwacja WHERE id=?";
        $stmt = $db_connection->prepare($query);
        $stmt->bind_param('i', $rentID);
        $stmt->execute();
        $stmt->close();

        $_SESSION['msg'] = 'Anulowano rezerwację.';
        header('Location: user.php#vehicles');
        exit;
    }
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
    <link rel="stylesheet" href="styles/panel.css">
    <link rel="Shortcut Icon" href="./img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        form .buttons {
            column-gap: 10px;
            display: none;
        }

        main form {
            width: 100%;
        }
    </style>
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
        <?php include_once("./inc/message.php"); ?>
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <a href="user.php">
                        <li>Home</li>
                    </a>
                    <a class="veh-link" href="user.php#vehicles">
                        <li>Pojazdy</li>
                    </a>
                    <a class="profile-link" href="user.php#profile">
                        <li>Edytuj profil</li>
                    </a>
                    <a class="settings-link" href="user.php#settings">
                        <li>Ustawienia</li>
                    </a>
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
                    <a href="login.php" class="login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="login-caption">Zaloguj się</span>
                    </a>
                    <div class="logged">
                        <div class="mobile-logged-menu-overlay"></div>
                        <i class="fas fa-user"></i>
                        <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                        <?php include("./inc/logged-menu.php"); ?>
                    </div>
                </div>
                <div class="overlay"></div>
            </div>
            <div class="all-settings">
                <header>
                    <h1><a href="user.php">Panel użytkownika</a></h1>
                    <div class="user">
                        <a href="login.php" class="login">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="login-caption">Zaloguj się</span>
                        </a>
                        <div class="logged">
                            <i class="fas fa-user"></i>
                            <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                            <?php include("./inc/logged-menu.php"); ?>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="home">
                        <section>
                            <div class="home-option manage-veh">
                                <i class="fas fa-car"></i>
                                <span>Wypożyczone pojazdy</span>
                            </div>
                            <div class="home-option manage-profile">
                                <i class="fas fa-user-edit"></i>
                                <span>Edytuj swój profil</span>
                            </div>
                            <div class="home-option manage-settings">
                                <i class="fas fa-cog"></i>
                                <span>Zmień ustawienia panelu</span>
                            </div>
                        </section>
                    </div>
                    <div class="vehicles">
                        <header>
                            <h2>Wypożyczone pojazdy</h2>
                        </header>
                        <section>
                            <?php
                            if (isset($_SESSION['login'])) {
                                require('db/db_connection.php');

                                $login = $_SESSION['login'];
                                $query = "SELECT id FROM users WHERE login=?";
                                $stmt = $db_connection->prepare($query);
                                $stmt->bind_param('s', $login);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $stmt->close();

                                $userId = $result->fetch_row();
                                $userId = $userId[0];

                                $query = "SELECT rezerwacja.id, marka, model, cena, na_ile, data_rezerwacji FROM vehicles INNER JOIN rezerwacja ON vehicles.id=rezerwacja.id_pojazdu WHERE id_klienta=?";
                                $stmt = $db_connection->prepare($query);
                                $stmt->bind_param('i', $userId);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $stmt->close();

                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="option">';
                                    echo '<form action="" method="POST">';
                                    echo 'Nazwa samochodu: ' . $row['marka'] . ' ' . $row['model'] . '<br>';
                                    echo 'Cena: ' . $row['cena'] * $row['na_ile'] . 'zł<br>';
                                    echo 'Na ile godzin: ' . $row['na_ile'] . '<br>';
                                    echo 'Data rezerwacji: ' . $row['data_rezerwacji'] . '<br>';
                                    echo '<input type="hidden" name="rentID" value="' . $row['id'] . '">';
                                    echo '<button type="submit">Anuluj</button>';
                                    echo '</form>';
                                    echo '</div>';
                                }

                                $db_connection->close();
                            }
                            ?>
                        </section>
                    </div>
                    <div class="profile">
                        <header>
                            <h2>Edytuj swój profil</h2>
                        </header>
                        <section>
                            <div class="option edit-profile">
                                <form action="" method="POST">
                                    <label for="name">Imię</label>
                                    <input onclick="this.setSelectionRange(0, this.value.length)" type="text" name="name" value="<?php if (isset($userData['imie'])) echo $userData['imie']; ?>">
                                    <label for="sName">Nazwisko</label>
                                    <input onclick="this.setSelectionRange(0, this.value.length)" type="text" name="sName" value="<?php if (isset($userData['nazwisko'])) echo $userData['nazwisko']; ?>">
                                    <label for="tel">Telefon</label>
                                    <input onclick="this.setSelectionRange(0, this.value.length)" type="tel" name="tel" value="<?php if (isset($userData['telefon'])) echo $userData['telefon']; ?>">
                                    <label for="email">Adres e-mail</label>
                                    <input onclick="this.setSelectionRange(0, this.value.length)" type="email" name="email" value="<?php if (isset($userData['email'])) echo $userData['email']; ?>">
                                    <div class="buttons">
                                        <button type="submit">Potwierdź</button>
                                        <button type="reset">Anuluj zmiany</button>
                                    </div>
                                </form>
                            </div>
                            <div class="option">
                                <a href="user/changeLogin.php">
                                    <button class="option-button ch-login">
                                        <h3>Zmień login</h3>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="user/changePasswd.php">
                                    <button class="option-button ch-passwd">
                                        <h3>Zmień hasło</h3>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                        </section>
                    </div>
                    <div class="settings">
                        <header>
                            <h2>Ustawienia</h2>
                        </header>
                        <section>
                            <div class="option">
                                <h3>Motyw panelu</h3>
                                <form action="" method="POST">
                                    <select name="theme">
                                        <option value="default">Domyślny</option>
                                        <option value="system">Użyj motywu urządzenia</option>
                                        <option value="light">Jasny</option>
                                        <option value="dark">Ciemny</option>
                                    </select>
                                    <button type="submit">Zmień</button>
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
    <script src="js/panelHandler.js"></script>
    <script>
        const selectTheme = (mode) => {
            document.querySelector('main select option[value="' + mode + '"]').setAttribute('selected', 'selected');
        }
        const profileInput = document.querySelectorAll('.edit-profile input');
        for (let i = 0; i < profileInput.length; i++) {
            profileInput[i].addEventListener('keypress', () => {
                document.querySelector('form .buttons').style.display = 'flex';
            });
        }
        document.querySelector('main form button[type="reset"]').addEventListener('click', () => {
            document.querySelector('form .buttons').style.display = 'none';
        });
    </script>
    <?php
    if (isset($_POST['theme']))
        echo '<script>selectTheme("' . $_POST['theme'] . '");</script>';
    elseif (isset($_COOKIE['theme']))
        echo '<script>selectTheme("' . $_COOKIE['theme'] . '");</script>';
    ?>
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