<?php 
    session_start();
    // if (!$_SESSION['logged'] && !$_SESSION['adminMode']) {
    //     header('Location: index.php');
    //     exit;
    // }
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
    <link rel="stylesheet" href="styles/admin.css">
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="page-wrapper">
        <nav class="panel">
            <div class="list-wrapper">
                <ul>
                    <a href="admin.php"><li>Home</li></a>
                    <a class="veh-link" href="admin.php#vehicles"><li>Pojazdy</li></a>
                    <a class="users-link" href="admin.php#users"><li>Użytkownicy</li></a>
                    <a class="settings-link" href="admin.php#settings"><li>Ustawienia</li></a>
                </ul>
            </div>
            <div class="back"><i class="fas fa-angle-double-left"></i> <a href="index.php">Wyjdź</a></div>
        </nav>
        <div class="content">
            <div class="mobile-nav">
                <div class="open"><i class="fas fa-bars"></i></div>
                <div class="user">
                    <a href="login.php" class="login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="login-caption">Zaloguj się</span>
                    </a>
                    <a href="admin.php" class="logged">
                        <i class="fas fa-user"></i>
                        <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                    </a>
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
                        <a href="admin.php" class="logged">
                            <i class="fas fa-user"></i>
                            <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                        </a>
                    </div>
                </header>
                <div class="home">
                    <main>
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
                    </main>
                </div>
                <div class="vehicles">
                    <header>
                        <h2>Pojazdy</h2>
                    </header>
                    <main>
                        <div class="option">
                            <a href="addvehicles.php">
                                <button class="option-button add-veh">
                                    <h3>Dodawanie nowych pojazdów</h3>
                                    <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                </button>
                            </a>
                        </div>
                        <div class="option">
                            <a href="vehicleslist.php">
                                <button class="option-button veh-list">
                                    <h3>Lista pojazdów</h3>
                                    <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                </button>
                            </a>
                        </div>
                        <div class="option">
                            <a href="vehreservation.php">
                                <button class="option-button veh-res">
                                    <h3>Rezerwacja pojazdów</h3>
                                    <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                </button>
                            </a>
                        </div>
                        <div class="option">
                            <a href="delvehicle.php">
                                <button class="option-button del-veh">
                                    <h3>Usuwanie pojazdów</h3>
                                    <div class="icon"><i class="fas fa-chevron-right"></i></div>
                                </button>
                            </a>
                        </div>
                    </main>
                </div>
                <div class="users">
                    <header>
                        <h2>Użytkownicy</h2>
                    </header>
                    <main>
                        <button class="option-button user-stats">
                            <h3>Statystyki użytkowników</h3>
                            <div class="icon"><i class="fas fa-chevron-right"></i></div>
                        </button>
                        <h3 style="margin-bottom: 10px;">Lista użytkowników</h3>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Login</th>
                                <th>Rezerwowane pojazdy</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>user1</td>
                                <td>Nazwa pojazdu</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>user2</td>
                                <td>Nazwa pojazdu</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>user3</td>
                                <td>Nazwa pojazdu</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>user4</td>
                                <td>Nazwa pojazdu</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>user5</td>
                                <td>Nazwa pojazdu</td>
                            </tr>
                        </table>
                    </main>
                </div>
                <div class="settings">
                    <header>
                        <h2>Ustawienia</h2>
                    </header>
                    <main>
                        <button class="option-button add-veh">
                            <h3>Dodawanie nowych pojazdów</h3>
                            <div class="icon"><i class="fas fa-chevron-right"></i></div>
                        </button>
                        <button class="option-button veh-list">
                            <h3>Lista pojazdów</h3>
                            <div class="icon"><i class="fas fa-chevron-right"></i></div>
                        </button>
                        <button class="option-button veh-list">
                            <h3>Rezerwacja pojazdów</h3>
                            <div class="icon"><i class="fas fa-chevron-right"></i></div>
                        </button>
                        <button class="option-button del-veh">
                            <h3>Usuwanie pojazdów</h3>
                            <div class="icon"><i class="fas fa-chevron-right"></i></div>
                        </button>
                    </main>
                </div>
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
    <script src="adminHandler.js"></script>
    <?php include_once('logged.php'); ?>
</body>
</html>