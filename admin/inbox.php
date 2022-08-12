<?php 
    session_start();
    if (isset($_SESSION['isLogged']) && isset($_SESSION['isAdmin'])) {
        if (!$_SESSION['isAdmin']) {
            header('Location: ../index.php');
            exit;
        }
    }
    else {
        header('Location: ../login.php');
        exit;
    }

    if (isset($_POST['message-id'])) {
        if ($_POST['message-id'] > 0) {
            $messageID = htmlentities($_POST['message-id']);

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
    <?php 
        if (isset($_POST['theme'])) {
            if ($_POST['theme'] != "default")
                echo '<link rel="stylesheet" href="../styles/'.$_POST['theme'].'.css">';
        }
        elseif (isset($_COOKIE['theme'])) {
            if ($_COOKIE['theme'] != "default")
                echo '<link rel="stylesheet" href="../styles/'.$_COOKIE['theme'].'.css">';
        }
    ?>
    <style>
        .messages h3 {
            margin-top: 20px;
        }
        .messages h3:first-child {
            margin-top: 0;
        }
        .box-msg {
            border: 1px solid #000;
            width: 60%;
            max-width: 100%;
            margin-top: 10px;
            padding: 20px;
        }
        @media screen and (max-width: 800px) {
            .box-msg {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="message-wrapper" <?php if (isset($_SESSION['msg']) || isset($_SESSION['error'])) echo 'style="display: flex;"'?>>
        <div class="overlay"></div>
        <div class="message">
            <div class="close"><i class="fas fa-times"></i></div>
            <div class="msg">
                <?php 
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
            </div>
            <div class="error">
                <?php 
                    if (isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                ?>
            </div>
        </div>
    </div>
    <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <a href="../admin.php"><li>Home</li></a>
                    <a class="veh-link" href="../admin.php#vehicles"><li>Pojazdy</li></a>
                    <a class="users-link" href="../admin.php#users"><li>Użytkownicy</li></a>
                    <a href="inbox.php"><li>Wiadomości</li></a>
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
                    <div class="messages">
                        <header>
                            <h2><a href="../admin.php">Wiadomości</a></h2>
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
                                        echo '<form action="" method="POST" style="display: block; width: 100%;">';
                                        echo '<input type="hidden" name="message-id" value="'.$row['id'].'">';
                                        echo '<span style="font-weight: bold;">Od:</span> '.$row['email'];
                                        echo '<br>';
                                        echo $row['imie'].' '.$row['nazwisko'];
                                        echo '<br>';
                                        if ($row['tel'] != 0) {
                                            echo '<span style="font-weight: bold;">Telefon:</span> '.$row['tel'];
                                            echo '<br>';
                                        }
                                        echo '<span style="font-weight: bold;">Dostarczono:</span> '.$row['date'];
                                        echo '<br>';
                                        echo '<span style="font-weight: bold;">Treść wiadomości:</span> '.$row['message'];
                                        echo '<br>';
                                        echo '<button type="submit" style="margin-bottom: 0;">Usuń wiadomość</button>';
                                        echo '</form>';
                                        echo '</div>';
                                    }
                                }
                                else
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
                                        echo '<form action="" method="POST" style="display: block; width: 100%;">';
                                        echo '<input type="hidden" name="message-id" value="'.$row['id'].'">';
                                        echo '<span style="font-weight: bold;">Do:</span> '.$row['user'];
                                        echo '<br>';
                                        echo '<span style="font-weight: bold;">Dostarczono:</span> '.$row['date'];
                                        echo '<br>';
                                        echo '<span style="font-weight: bold;">Treść wiadomości:</span> '.$row['message'];
                                        echo '<br>';
                                        echo '<button type="submit" style="margin-bottom: 0;">Usuń wiadomość</button>';
                                        echo '</form>';
                                        echo '</div>';
                                    }
                                }
                                else 
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