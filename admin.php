<?php 
    session_start();
    if (isset($_SESSION['isLogged']) && isset($_SESSION['isAdmin'])) {
        if (!$_SESSION['isAdmin']) {
            header('Location: index.php');
            exit;
        }
    }
    else {
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['action']) && isset($_POST['user-id'])) {
        $userID = htmlentities($_POST['user-id']);
        require('db/db_connection.php');

        if ($_POST['action'] === 'grant')
            $query = "UPDATE users SET is_admin=1 WHERE id=?";
        else 
            $query = "UPDATE users SET is_admin=0 WHERE id=?";
        
        $stmt = $db_connection->prepare($query);
        $stmt->bind_param('i', $userID);
        $stmt->execute();
        $stmt->close();
        $db_connection->close();
    }

    // Ustawienie pliku cookie dla motywu panelu
    if (isset($_POST['theme'])) {
        $theme = htmlentities($_POST['theme']);
        if ($theme == "default" || $theme == "system" || $theme == "dark" || $theme == "light")
            setcookie('theme', $theme, time() + (5 * 365 * 24 * 60 * 60));
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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        .access-buttons {
            display: flex;
            column-gap: 10px;
        }
        .access-buttons button {
            width: 100%;
        }
    </style>
    <?php 
        if (isset($_POST['theme'])) {
            if ($_POST['theme'] != "default")
                echo '<link rel="stylesheet" href="styles/'.$_POST['theme'].'.css">';
        }
        elseif (isset($_COOKIE['theme'])) {
            if ($_COOKIE['theme'] != "default")
                echo '<link rel="stylesheet" href="styles/'.$_COOKIE['theme'].'.css">';
        }
    ?>
</head>
<body>
    <div class="page-wrapper">
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <a href="admin.php"><li>Home</li></a>
                    <a class="veh-link" href="admin.php#vehicles"><li>Pojazdy</li></a>
                    <a class="users-link" href="admin.php#users"><li>Użytkownicy</li></a>
                    <a href="admin/inbox.php"><li>Wiadomości</li></a>
                    <a class="settings-link" href="admin.php#settings"><li>Ustawienia</li></a>
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
                    <h1><a href="admin.php">Panel administracyjny</a></h1>
                    <div class="user">
                        <a href="login.php" class="login">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="login-caption">Zaloguj się</span>
                        </a>
                        <div class="logged">
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
                </header>
                <main>
                    <div class="home">
                        <section>
                            <div class="home-option manage-veh">
                                <i class="fas fa-car"></i>
                                <span>Zarządzanie pojazdami</span>
                            </div>
                            <div class="home-option manage-users">
                                <i class="fas fa-users"></i>
                                <span>Zarządzanie użytkownikami</span>
                            </div>
                            <div class="home-option manage-settings">
                                <i class="fas fa-cog"></i>
                                <span>Zmiana ustawień serwisu</span>
                            </div>
                            <a href="admin/inbox.php" style="color: inherit;">
                                <div class="home-option inbox">
                                    <i class="fas fa-inbox"></i>
                                    <span>Wiadomości</span>
                                </div>
                            </a>
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
                                        <h3>Dodawanie nowych pojazdów</h3>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/vehicleslist.php">
                                    <button class="option-button veh-list">
                                        <h3>Lista pojazdów</h3>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/vehaccess.php">
                                    <button class="option-button veh-access">
                                        <h3>Dostępność pojazdów</h3>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/delvehicle.php">
                                    <button class="option-button del-veh">
                                        <h3>Usuwanie pojazdów</h3>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/vehiclerent.php">
                                    <button class="option-button veh-res">
                                        <h3>Rezerwacja pojazdów</h3>
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
                                        <h3>Resetowanie haseł</h3>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <div class="option">
                                <a href="admin/delusers.php">
                                    <button class="option-button user-stats">
                                        <h3>Usuwanie użytkowników</h3>
                                        <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                    </button>
                                </a>
                            </div>
                            <h3 style="margin-bottom: 10px;">Lista użytkowników</h3>
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
                                        require('db/db_connection.php');
                                        $query = "SELECT * FROM users";

                                        $stmt = $db_connection->prepare($query);
                                        $stmt->execute();

                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>'.$row['id'].'</td>';
                                            echo '<td>'.$row['login'].'</td>';
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
                                        $stmt->close();
                                        $db_connection->close();
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
                            <div class="option">
                                <h3>Zarządzanie dostępem</h3>
                                <form action="" method="POST">
                                    <input type="number" name="user-id" placeholder="Wpisz ID użytkownika">
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
                                                require('db/db_connection.php');

                                                $query = "SELECT * FROM admins";

                                                $stmt = $db_connection->prepare($query);
                                                $stmt->execute();
            
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<tr>';
                                                    echo '<td>'.$row['id'].'</td>';
                                                    echo '<td>'.$row['login'].'</td>';
                                                    echo '<td>';
                                                        if ($row['email'] != '') 
                                                            echo $row['email'];
                                                        else 
                                                            echo 'Brak adresu';
                                                    echo '</td>';
                                                    echo '<tr>';
                                                }
                                                $stmt->close();
                                                $db_connection->close();
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
                    <div class="bottom-text">&copy;2021 by Paweł Poremba</div>
                </section>
            </footer>
        </div>
    </div>
    <script src="js/panelHandler.js"></script>
    <script>
        const selectTheme = (mode) => {
            document.querySelector('main select option[value="'+mode+'"]').setAttribute('selected', 'selected');
        }
    </script>
    <?php 
        if (isset($_POST['theme']))
            echo '<script>selectTheme("'.$_POST['theme'].'");</script>';
        elseif (isset($_COOKIE['theme']))
            echo '<script>selectTheme("'.$_COOKIE['theme'].'");</script>';
    ?>
    <?php include_once('inc/logged.php'); ?>
</body>
</html>