<?php
global $db_connection, $consoleLog;
require_once("./initial.php");
if (isset($_SESSION['isLogged'])) {
    if (!$_SESSION['isLogged']) {
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

setPanelThemeCookie();

try {
    require('db/db_connection.php');

    $query = "SELECT id FROM users WHERE login=:login";
    $stmt = $db_connection->prepare($query);
    $stmt->bindParam('login', $_SESSION['login']);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($stmt->rowCount() == 1) {
        $id = $result["id"];
    }

    if (isset($_POST['name']) && isset($_POST['sName']) && isset($_POST['tel']) && isset($_POST['email'])) {
        $name = htmlentities($_POST['name']);
        $sName = htmlentities($_POST['sName']);
        $tel = htmlentities($_POST['tel']);
        $email = htmlentities($_POST['email']);

        if (isset($id)) {
            if (!empty($name)) {
                $query = "UPDATE users SET first_name=:firstName WHERE id=:id";
                $stmt = $db_connection->prepare($query);
                $stmt->bindParam("firstName", $name);
                $stmt->bindParam("id", $id, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0)
                    $_SESSION['msg'] = 'Zmiany zostały zapisane.';
                else
                    $_SESSION['error'] = 'Nie udało się wprowadzić zmian.';
            }
            if (!empty($sName)) {
                $query = "UPDATE users SET last_name=:lastName WHERE id=:id";
                $stmt = $db_connection->prepare($query);
                $stmt->bindParam("lastName", $sName);
                $stmt->bindParam("id", $id, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0)
                    $_SESSION['msg'] = 'Zmiany zostały zapisane.';
                else
                    $_SESSION['error'] = 'Nie udało się wprowadzić zmian.';
            }
            if (!empty($tel)) {
                if (filter_var($tel, FILTER_VALIDATE_INT)) {
                    $query = "UPDATE users SET phone_number=:tel WHERE id=:id";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bindParam("tel", $tel);
                    $stmt->bindParam("id", $id, PDO::PARAM_INT);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0)
                        $_SESSION['msg'] = 'Zmiany zostały zapisane.';
                    else
                        $_SESSION['error'] = 'Nie udało się wprowadzić zmian.';
                } else
                    $_SESSION['error'] = 'Wprowadzono niepoprawny numer telefonu';
            }
            if (!empty($email)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $query = "UPDATE users SET email=:email WHERE id=:id";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bindParam("email", $email);
                    $stmt->bindParam("id", $id, PDO::PARAM_INT);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0)
                        $_SESSION['msg'] = 'Zmiany zostały zapisane.';
                    else
                        $_SESSION['error'] = 'Nie udało się wprowadzić zmian.';
                } else
                    $_SESSION['error'] = 'Wprowadzono niepoprawny email';
            }
        } else
            $_SESSION['error'] = 'Takiego loginu nie ma w bazie danych.';
    }

    if (isset($id)) {
        $query = "SELECT first_name, last_name, phone_number, email FROM users WHERE id=:id";
        $stmt = $db_connection->prepare($query);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        foreach ($result as $key => $value) {
            if (empty($value))
                $result[$key] = 'Brak danych';
        }
    }

    if (isset($_POST['rentID'])) {
        $rentID = htmlentities($_POST['rentID']);

        $query = "DELETE FROM reservations WHERE id:id";
        $stmt = $db_connection->prepare($query);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['msg'] = 'Anulowano rezerwację.';
        header('Location: user.php#vehicles');
        exit;
    }
    $db_connection = null;
} catch (PDOException $error) {
    $consoleLog->show = true;
    $consoleLog->content = $error;
    $consoleLog->is_error = true;
} catch (Exception $error) {
    $error = addslashes($error);
    $error = str_replace("\n", "", $error);
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
    <link rel="stylesheet" href="styles/user.css">
    <link rel="Shortcut Icon" href="./img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
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
                    <li><a href="user.php">Home</a></li>
                    <li><a class="veh-link" href="user.php#vehicles">Pojazdy</a></li>
                    <li><a class="profile-link" href="user.php#profile">Edytuj profil</a></li>
                    <li><a class="settings-link" href="user.php#settings">Ustawienia</a></li>
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
                            <div class="home-option vehicles">
                                <i class="fas fa-car"></i>
                                <span>Wypożyczone pojazdy</span>
                            </div>
                            <div class="home-option profile">
                                <i class="fas fa-user-edit"></i>
                                <span>Edytuj swój profil</span>
                            </div>
                            <div class="home-option settings">
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
                                $query = "SELECT id FROM users WHERE login=:login";
                                $stmt = $db_connection->prepare($query);
                                $stmt->bindParam("login", $login);
                                $stmt->execute();
                                $result = $stmt->fetch();

                                $userId = $result["id"];

                                $query = "SELECT r.id, brand, model, price_per_day, days_count, date FROM vehicles v INNER JOIN reservations r ON v.id=r.vehicle_id WHERE client_id=:id";
                                $stmt = $db_connection->prepare($query);
                                $stmt->bindParam('i', $userId, PDO::PARAM_INT);
                                $stmt->execute();
                                $result = $stmt->fetch();

                                foreach ($result as $row) {
                                    echo '<div class="option">';
                                    echo '<form action="" method="POST">';
                                    echo 'Nazwa samochodu: ' . $row['brand'] . ' ' . $row['model'] . '<br>';
                                    echo 'Cena: ' . $row['price_per_day'] * $row['days_count'] . 'zł<br>';
                                    echo 'Na ile godzin: ' . $row['na_ile'] . '<br>';
                                    echo 'Data rezerwacji: ' . $row['date'] . '<br>';
                                    echo '<input type="hidden" name="rentID" value="' . $row['id'] . '">';
                                    echo '<button type="submit">Anuluj</button>';
                                    echo '</form>';
                                    echo '</div>';
                                }

                                $db_connection = null;
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
                                    <input type="text" name="name" id="name" value="<?php if (isset($userData['first_name'])) echo $userData['first_name']; ?>">
                                    <label for="sName">Nazwisko</label>
                                    <input type="text" name="sName" id="sName" value="<?php if (isset($userData['last_name'])) echo $userData['last_name']; ?>">
                                    <label for="tel">Telefon</label>
                                    <input type="tel" name="tel" id="tel" value="<?php if (isset($userData['phone_number'])) echo $userData['phone_number']; ?>">
                                    <label for="email">Adres e-mail</label>
                                    <input type="email" name="email" id="email" value="<?php if (isset($userData['email'])) echo $userData['email']; ?>">
                                    <div class="buttons">
                                        <button type="submit">Potwierdź</button>
                                        <button type="reset">Anuluj zmiany</button>
                                    </div>
                                </form>
                            </div>
                            <div class="option">
                                <a href="user/changeLogin.php">
                                    <button class="option-button ch-login">
                                        <span>Zmień login</span>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="user/changePasswd.php">
                                    <button class="option-button ch-passwd">
                                        <span>Zmień hasło</span>
                                        <span class="icon"><i class="fas fa-chevron-right"></i></span>
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
                                <span>Motyw panelu</span>
                                <form action="" method="POST">
                                    <label>
                                        <select name="theme">
                                            <option value="default">Domyślny</option>
                                            <option value="system">Użyj motywu urządzenia</option>
                                            <option value="light">Jasny</option>
                                            <option value="dark">Ciemny</option>
                                        </select>
                                    </label>
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
    <script src="js/user.js"></script>
    <?php
    include_once('./inc/theme.php');
    include_once('./inc/logged.php');

    if (isset($consoleLog)) {
        if ($consoleLog->show) {
            if ($consoleLog->is_error) {
                echo '<script src="js/log.js" value="' . $consoleLog->content . '" name="error"></script>';
            } else {
                echo '<script src="js/log.js" value="' . $consoleLog->content . '" name="log"></script>';
            }
        }
    }
    ?>
</body>

</html>