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

    if (isset($_POST['user-id']))
    {
        $userID = htmlentities($_POST['user-id']);

        require('../db/db_connection.php');
        $query = "DELETE FROM users WHERE id=? AND is_admin=0";
        $stmt = $db_connection->prepare($query);
        $stmt->bind_param('i', $userID);
        $stmt->execute();

        if ($db_connection->affected_rows > 0)
        {
            $_SESSION['msg'] = 'Udało się usunąć użytkownika.';
        }
        else 
        {
            $_SESSION['error'] = 'Nie udało się usunąć użytkownika. Pamiętaj, że nie można usuwać administratorów.';
        }

        $stmt->close();
        $db_connection->close();
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
        .content .users header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
        }
        .content .users header>* {
            margin-right: 20px;
        }
        .content .users header>*:last-child {
            margin-right: 0;
        }
        .content .users header>* a {
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
        @media screen and (max-width: 800px) {
            .content .users header>* {
                margin-right: 10px;
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
                    <div class="users">
                        <header>
                            <h2><a href="../admin.php#users">Użytkownicy</a></h2> 
                            <i class="fas fa-chevron-right"></i> 
                            <h2>Usuń użytkowników</h2>
                        </header>
                        <section>
                            <form action="" method="POST">
                                <label>ID użytkownika</label>
                                <input type="number" name="user-id" min="1" required>
                                <button type="submit">Usuń</button>
                            </form>
                            <h3 style="margin-bottom: 10px;">Lista użytkowników</h3>
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Login</th>
                                </tr>
                                <?php 
                                    // Wylistowanie użytkowników w tabeli

                                    require('../db/db_connection.php');
                                    $query = "SELECT id, login FROM all_users WHERE is_admin=0";

                                    $stmt = $db_connection->prepare($query);
                                    $stmt->execute();

                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc())
                                    {
                                        echo '<tr>';
                                        echo '<td>'.$row['id'].'</td>';
                                        echo '<td>'.$row['login'].'</td>';
                                        echo '<tr>';
                                    }
                                    $stmt->close();
                                    $db_connection->close();
                                ?>
                            </table>
                        </section>
                        <div class="message">
                            <?php 
                                if (isset($_SESSION['msg']))
                                {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                            ?>
                        </div>
                        <div class="error" style="color: #ff6c6c;">
                            <?php 
                                if (isset($_SESSION['error']))
                                {
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                }
                            ?>
                        </div>
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