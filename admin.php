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
        <nav class="desktop-panel">
            <div class="list-wrapper">
                <ul>
                    <a href="index.php"><li>Home</li></a>
                    <a class="veh-link"><li>Pojazdy</li></a>
                    <a class="users-link"><li>Użytkownicy</li></a>
                    <a class="settings-link"><li>Ustawienia</li></a>
                </ul>
            </div>
            <div class="back"><i class="fas fa-angle-double-left"></i> <a href="index.php">Powrót</a></div>
        </nav>
        <nav class="mobile-panel"></nav>
        <div class="content">
            <div class="all-settings">
                <header>
                    <h1>Panel administracyjny</h1>
                </header>
                <div class="vehicles">
                    <header>
                        <h2>Pojazdy</h2>
                    </header>
                    <main>
                        <div class="option">
                            <button class="option-button add-veh">
                                <h3>Dodawanie nowych pojazdów</h3>
                                <div class="icon"><i class="fas fa-chevron-right"></i></div>
                            </button>
                            <div class="option-content">
                                <h3>test</h3>
                                <span>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia quis officiis provident exercitationem illo culpa praesentium minima quos. Assumenda repellendus quos voluptate, aliquam quis soluta cumque maxime dolores provident ipsa?
                                </span>
                            </div>
                        </div>
                        <div class="option">
                            <button class="option-button veh-list">
                                <h3>Lista pojazdów</h3>
                                <div class="icon"><i class="fas fa-chevron-right"></i></div>
                            </button>
                            <div class="option-content">
                                test2
                            </div>
                        </div>
                        <div class="option">
                            <button class="option-button veh-res">
                                <h3>Rezerwacja pojazdów</h3>
                                <div class="icon"><i class="fas fa-chevron-right"></i></div>
                            </button>
                            <div class="option-content">
                                test3
                            </div>
                        </div>
                        <div class="option">
                            <button class="option-button del-veh">
                                <h3>Usuwanie pojazdów</h3>
                                <div class="icon"><i class="fas fa-chevron-right"></i></div>
                            </button>
                            <div class="option-content">
                                test4
                            </div>
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
</body>
</html>