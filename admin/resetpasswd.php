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

include_once("../inc/consoleMessage.php");

if (isset($_POST['user-id'])) {
    $userID = htmlentities($_POST['user-id']);

    try {
        require('../db/db_connection.php');
        $query = "UPDATE users SET change_passwd=1 WHERE id=? AND is_admin=0";
        $stmt = $db_connection->prepare($query);
        $stmt->bind_param('i', $userID);
        $stmt->execute();

        if ($db_connection->affected_rows > 0)
            $_SESSION['msg'] = 'Użytkownik musi ustawić nowe hasło przy następnym logowaniu.';
        else
            $_SESSION['error'] = 'Nie udało się zresetować hasła. Pamiętaj, że nie można resetować hasła administratorów lub użytkowników, których hasła zostały już zresetowane.';

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
                        <div class="logged-menu">
                            <ul>
                                <?php
                                if (isset($_SESSION['login'])) {
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
                                    if (isset($_SESSION['isAdmin'])) {
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
                    <div class="users">
                        <header>
                            <h2><a href="../admin.php#users">Użytkownicy</a></h2>
                            <i class="fas fa-chevron-right"></i>
                            <h2>Resetowanie haseł</h2>
                        </header>
                        <section>
                            <form action="" method="POST">
                                <label>ID użytkownika</label>
                                <input type="number" name="user-id" min="1" required>
                                <button type="submit">Resetuj</button>
                            </form>
                            <h3 style="margin-bottom: 10px;">Lista użytkowników</h3>
                            <div class="table">
                                <table>
                                    <tr>
                                        <th>ID</th>
                                        <th>Login</th>
                                    </tr>
                                    <?php
                                    // Wylistowanie użytkowników w tabeli
                                    require('../db/db_connection.php');
                                    $query = "SELECT id, login FROM users WHERE is_admin=0";

                                    $stmt = $db_connection->prepare($query);
                                    $stmt->execute();

                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row['id'] . '</td>';
                                        echo '<td>' . $row['login'] . '</td>';
                                        echo '<tr>';
                                    }
                                    $stmt->close();
                                    $db_connection->close();
                                    ?>
                                </table>
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
        for (let i = 0; i < input.length; i++) {
            checkInput(input[i]);
        }
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