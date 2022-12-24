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

    if (isset($_POST['id'])) {
        $rentID = htmlentities($_POST['id']);
        if ($rentID > 0) {
            require('../db/db_connection.php');
            $query = "DELETE FROM rezerwacja WHERE id=?";
            $stmt = $db_connection->prepare($query);
            $stmt->bind_param('i', $rentID);
            $stmt->execute();

            if ($db_connection->affected_rows > 0)
                $_SESSION['msg'] = 'Udało się usunąć rezerwację.';
            else 
                $_SESSION['msg'] = 'Nie udało się usunąć rezerwacji.';

            $stmt->close();
            $db_connection->close();
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
                    <a href="../admin/inbox.php"><li>Wiadomości</li></a>
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
                    <div class="vehicles">
                        <header>
                            <h2><a href="../admin.php#vehicles">Pojazdy</a></h2> 
                            <i class="fas fa-chevron-right"></i> 
                            <h2>Rezerwacja pojazdów</h2>
                        </header>
                        <section>
                            <div class="option">
                                <h3>Usuwanie rezerwacji</h3>
                                <form action="" method="POST">
                                    <label for="id">Wpisz ID rezerwacji:</label>
                                    <input type="number" name="id" min="1" required>
                                    <button type="submit">Usuń</button>
                                </form>
                            </div>
                            <h3 style="margin-bottom: 10px;">Lista rezerwacji</h3>
                            <div class="table">
                                <table>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID pojazdu</th>
                                        <th>ID użytkownika</th>
                                        <th>Data rezerwacji</th>
                                        <th>Na ile godzin</th>
                                    </tr>
                                    <?php 
                                        require('../db/db_connection.php');
                                        $query = "SELECT * FROM rezerwacja";

                                        $stmt = $db_connection->prepare($query);
                                        $stmt->execute();

                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>'.$row['id'].'</td>';
                                            echo '<td>'.$row['id_pojazdu'].'</td>';
                                            echo '<td>'.$row['id_klienta'].'</td>';
                                            echo '<td>'.$row['data_rezerwacji'].'</td>';
                                            echo '<td>'.$row['na_ile'].'</td>';
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
        for (let i=0; i<input.length; i++) {
            checkInput(input[i]);
        }
    </script>
    <?php include_once('./inc/logged.php'); ?>
</body>
</html>