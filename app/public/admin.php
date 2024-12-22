<?php
global $db_connection;
require_once("./initial.php");
$consoleLog = new ConsoleMessage();
if (isset($_SESSION['isLogged']) && isset($_SESSION['isAdmin'])) {
    if (!$_SESSION['isAdmin']) {
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}

if (isset($_POST['action']) && isset($_POST['user-id'])) {
    $userID = htmlentities($_POST['user-id']);

    try {
        require('db/db_connection.php');

        if ($_POST['action'] === 'grant')
            $query = "UPDATE users SET is_admin=1 WHERE id=:userID";
        else
            $query = "UPDATE users SET is_admin=0 WHERE id=:userID";

        $stmt = $db_connection->prepare($query);
        $stmt->bindParam('userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $db_connection = null;
    } catch (PDOException $Exception) {
        $consoleLog->show = true;
        $consoleLog->content = $Exception;
        $consoleLog->is_error = true;
    } catch (Exception $Exception) {
        $Exception = addslashes($Exception);
        $Exception = str_replace("\n", "", $Exception);
        $consoleLog->show = true;
        $consoleLog->content = $Exception;
        $consoleLog->is_error = true;
    }
}
else {
    $consoleLog->show = true;
    $consoleLog->content = "No action provided";
    $consoleLog->is_error = true;
}

setPanelThemeCookie();

require('db/db_connection.php');
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
    <link rel="stylesheet" href="styles/admin.css">
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
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <li><a href="admin.php">Home</a></li>
                    <li><a class="veh-link" href="admin.php#vehicles">Pojazdy</a></li>
                    <li><a class="users-link" href="admin.php#users">Użytkownicy</a></li>
                    <li><a href="admin/inbox.php">Wiadomości</a></li>
                    <li><a class="settings-link" href="admin.php#settings">Ustawienia</a></li>
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
                    <h1><a href="admin.php">Panel administracyjny</a></h1>
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
                                <span>Zarządzanie pojazdami</span>
                            </div>
                            <div class="home-option users">
                                <i class="fas fa-users"></i>
                                <span>Zarządzanie użytkownikami</span>
                            </div>
                            <div class="home-option settings">
                                <i class="fas fa-cog"></i>
                                <span>Zmiana ustawień serwisu</span>
                            </div>
                            <div class="home-option inbox">
                                <i class="fas fa-inbox"></i>
                                <span>Wiadomości</span>
                            </div>
                        </section>
                    </div>
                    <div class="vehicles">
                        <header>
                            <h2>Pojazdy</h2>
                        </header>
                        <section>
                            <div class="option">
                                <a href="admin/addvehicles.php">
                                    <button class="option-button add-veh">
                                        <span>Dodawanie nowych pojazdów</span>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/vehicleslist.php">
                                    <button class="option-button veh-list">
                                        <span>Lista pojazdów</span>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/vehaccess.php">
                                    <button class="option-button veh-access">
                                        <span>Dostępność pojazdów</span>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/delvehicle.php">
                                    <button class="option-button del-veh">
                                        <span>Usuwanie pojazdów</span>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/vehiclerent.php">
                                    <button class="option-button veh-res">
                                        <span>Rezerwacja pojazdów</span>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                        </section>
                    </div>
                    <div class="users">
                        <header>
                            <h2>Użytkownicy</h2>
                        </header>
                        <section>
                            <div class="option">
                                <a href="admin/resetpasswd.php">
                                    <button class="option-button user-stats">
                                        <span>Resetowanie haseł</span>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/delusers.php">
                                    <button class="option-button user-stats">
                                        <span>Usuwanie użytkowników</span>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <h3>Lista użytkowników</h3>
                            <div class="table">
                                <table>
                                    <tr>
                                        <th>ID</th>
                                        <th>Login</th>
                                        <th>E-mail</th>
                                        <th>Admin</th>
                                        <th>Wypożyczone pojazdy</th>
                                    </tr>
                                    <?php
                                    // Wylistowanie użytkowników w tabeli
                                    $query = "SELECT * FROM users";

                                    $stmt = $db_connection->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll();

                                    foreach ($result as $row) {
                                        echo '<tr>';
                                        echo '<td>' . $row['id'] . '</td>';
                                        echo '<td>' . $row['login'] . '</td>';
                                        echo '<td>';
                                        if ($row['email'] != '')
                                            echo $row['email'];
                                        else
                                            echo 'Brak email';
                                        echo '</td>';
                                        echo '<td>';
                                        if ($row['is_admin'])
                                            echo 'TAK';
                                        else
                                            echo 'NIE';
                                        echo '</td>';
                                        echo '<td>';
                                        if ($row['rented_vehicles'] > 0)
                                            echo $row['rented_vehicles'];
                                        else
                                            echo 'Brak pojazdów';
                                        echo '</td>';
                                        echo '<tr>';
                                    }
                                    ?>
                                </table>
                            </div>
                        </section>
                    </div>
                    <div class="settings">
                        <header>
                            <h2>Ustawienia</h2>
                        </header>
                        <section>
                            <div class="option">
                                <h3>Zarządzanie dostępem</h3>
                                <form action="" method="POST">
                                    <label>
                                        <input type="number" name="user-id" placeholder="Wpisz ID użytkownika">
                                    </label>
                                    <div class="access-buttons">
                                        <button type="submit" name="action" value="grant">Nadaj dostęp</button>
                                        <button type="submit" name="action" value="revoke">Usuń dostęp</button>
                                    </div>
                                </form>
                                <div class="access-list">
                                    <h4>Administratorzy</h4>
                                    <br>
                                    <div class="table">
                                        <table>
                                            <tr>
                                                <th>ID</th>
                                                <th>Login</th>
                                                <th>E-mail</th>
                                            </tr>
                                            <?php
                                            $query = "SELECT * FROM admins";

                                            $stmt = $db_connection->prepare($query);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll();

                                            foreach ($result as $row) {
                                                echo '<tr>';
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . $row['login'] . '</td>';
                                                echo '<td>';
                                                if ($row['email'] != '')
                                                    echo $row['email'];
                                                else
                                                    echo 'Brak adresu';
                                                echo '</td>';
                                                echo '<tr>';
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
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
    <?php
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

    $db_connection = null;
    ?>
</body>

</html>