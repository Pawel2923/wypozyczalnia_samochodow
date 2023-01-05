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

if (isset($_POST['message-id'])) {
    if ($_POST['message-id'] > 0) {
        $messageID = htmlentities($_POST['message-id']);

        try {
            require('../db/db_connection.php');

            $query = 'DELETE FROM mailboxes WHERE message_id=?';
            $stmt = $db_connection->prepare($query);
            $stmt->bind_param('i', $messageID);
            $stmt->execute();
            $stmt->close();

            $query = 'DELETE FROM messages WHERE id=?';
            $stmt = $db_connection->prepare($query);
            $stmt->bind_param('i', $messageID);
            $stmt->execute();
            $stmt->close();

            $_SESSION['msg'] = 'Pomyślnie usunięto wiadomość.';

            $db_connection->close();
            unset($_POST['message-id']);
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
    <link rel="stylesheet" href="styles/inbox.css">
    <link rel="Shortcut Icon" href="../img/logo.svg" />
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
                    <a href="inbox.php">
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
                    <div class="messages">
                        <header>
                            <h2>Wiadomości</h2>
                        </header>
                        <section>
                            <?php
                            require('../db/db_connection.php');

                            $query = "SELECT messages.* FROM messages INNER JOIN mailboxes ON mailboxes.message_id=messages.id WHERE user=? AND direction='in' ORDER BY date DESC";
                            $stmt = $db_connection->prepare($query);
                            $stmt->bind_param('s', $_SESSION['login']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $stmt->close();

                            echo '<h3>Odebrane</h3>';
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="box-msg">';
                                    echo '<form action="" method="POST">';
                                    echo '<input type="hidden" name="message-id" value="' . $row['id'] . '">';
                                    echo '<span>Od:</span> ' . $row['email'];
                                    echo '<br>';
                                    echo $row['imie'] . ' ' . $row['nazwisko'];
                                    echo '<br>';
                                    if ($row['tel'] != 0) {
                                        echo '<span>Telefon:</span> ' . $row['tel'];
                                        echo '<br>';
                                    }
                                    echo '<span>Dostarczono:</span> ' . $row['date'];
                                    echo '<br>';
                                    echo '<span>Treść wiadomości:</span> ' . $row['message'];
                                    echo '<br>';
                                    echo '<button type="submit">Usuń wiadomość</button>';
                                    echo '</form>';
                                    echo '</div>';
                                }
                            } else
                                echo 'Nie masz żadnych wiadomości.';

                            $query = "SELECT messages.*, mailboxes.user FROM messages INNER JOIN mailboxes ON mailboxes.message_id=messages.id WHERE user=? AND direction='out' ORDER BY date DESC";
                            $stmt = $db_connection->prepare($query);
                            $stmt->bind_param('s', $_SESSION['login']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $stmt->close();

                            echo '<h3>Wysłane</h3>';
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="box-msg">';
                                    echo '<form action="" method="POST">';
                                    echo '<input type="hidden" name="message-id" value="' . $row['id'] . '">';
                                    echo '<span>Do:</span> ' . $row['user'];
                                    echo '<br>';
                                    echo '<span>Dostarczono:</span> ' . $row['date'];
                                    echo '<br>';
                                    echo '<span>Treść wiadomości:</span> ' . $row['message'];
                                    echo '<br>';
                                    echo '<button type="submit">Usuń wiadomość</button>';
                                    echo '</form>';
                                    echo '</div>';
                                }
                            } else
                                echo 'Nie wysłałeś żadnych wiadomości.';
                            ?>
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
    <script src="js/main.js" type="module"></script>
    <?php
    include_once('./inc/logged.php');
    if (isset($consoleLog)) {
        if ($consoleLog->show) {
            if ($consoleLog->is_error) {
                echo '<script src="../js/log.js" value="' . $consoleLog->content . '" name="error"></script>';
            } else {
                echo '<script src="../js/log.js" value="' . $consoleLog->content . '" name="log"></script>';
            }
        }
    }
    ?>
</body>

</html>