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
    <link rel="stylesheet" href="styles/index.css">
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="mobile-nav">
        <div class="open"><i class="fas fa-bars"></i></div>
        <div class="nav-wrapper">
            <div class="top-content">
                <div></div>
                <div class="close"><i class="fas fa-times"></i></div>
                <div class="user">
                    <a href="login.php">
                        <i class="fas fa-user-circle"></i>
                        <span class="login-caption">Zaloguj się</span>
                    </a>
                </div>
            </div>
            <div class="list-wrapper">
                <ul>
                    <a href="index.php"><li>Home</li></a>
                    <a href="rezerwacja.php"><li>Rezerwacja online</li></a>
                    <a href="wycena.php"><li>Uzyskaj wycenę</li></a>
                    <a href="vehicles.php"><li>Nasze pojazdy</li></a>
                    <a href="contact.php"><li>Kontakt</li></a>
                </ul>
            </div>
        </div>
    </nav>
    <nav class="desktop-nav">
        <div class="nav-header">
            <a href="index.php"><h2>Wypożyczalnia</h2></a>
        </div>
        <div class="list-wrapper">
            <div class="spacer"></div>
            <ul>
                <a href="index.php"><li>Home</li></a>
                <a href="rezerwacja.php"><li>Rezerwacja online</li></a>
                <a href="wycena.php"><li>Uzyskaj wycenę</li></a>
                <a href="vehicles.php"><li>Nasze pojazdy</li></a>
                <a href="contact.php"><li>Kontakt</li></a>
            </ul>
            <div class="user">
                <a href="login.php">
                    <i class="fas fa-user-circle"></i>
                    <span class="login-caption">Zaloguj się</span>
                </a>
            </div>
        </div>
    </nav>
    <main>
        <section class="main-header">
            <h1>Wypożyczalnia — witamy!</h1>
            <span>Nowy wymiar wynajmu</span>
        </section>
        <div class="img"></div>
        <section class="info">
            <h2>Wypożyczalnia samochodów — informacje</h2>
            <span>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim mollitia, aliquid rem facere quo consequuntur ullam iste voluptatem corporis tempore, consequatur, recusandae beatae! Architecto reprehenderit saepe omnis vero officia ducimus!
            </span>
        </section>
        <section>
            <h2>Samochody do rezerwacji</h2>
            <div class="cars">
                <div class="car">
                    <div class="image-wrapper">
                        <img src="https://ireland.apollo.olxcdn.com/v1/files/eyJmbiI6IjByc3gyc3BrZzQ4YjMtT1RPTU9UT1BMIiwidyI6W3siZm4iOiJ3ZzRnbnFwNnkxZi1PVE9NT1RPUEwiLCJzIjoiMTYiLCJwIjoiMTAsLTEwIiwiYSI6IjAifV19.hXuoemts_h7soE7DwcsvGnYuHhVCV0y0sCWXJ0ZzIVE/image;s=732x488" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="img-overlay"></div>
                    </div>
                    <span class="car-name">Toyota Yaris</span>
                    <div class="divider"></div>
                    <div class="car-price">
                        <span>1 godz.</span>
                        <span>65,00 zł</span>
                    </div>
                    <button type="button">Rezerwacja</button>
                </div>
                <div class="car">
                    <div class="image-wrapper">
                        <img src="https://i.wpimg.pl/600x0/m.autokult.pl/ford-fusion-4-3ddb5b2d153e08d106.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="img-overlay"></div>
                    </div>
                    <span class="car-name">Ford Fusion</span>
                    <div class="divider"></div>
                    <div class="car-price">
                        <span>1 godz.</span>
                        <span>55,00 zł</span>
                    </div>
                    <button type="button">Rezerwacja</button>
                </div>
                <div class="car">
                    <div class="image-wrapper">
                        <img src="https://www.auto-gazda.pl/application/files/8816/2861/3097/1.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="img-overlay"></div>
                    </div>
                    <span class="car-name">Volkswagen Golf</span>
                    <div class="divider"></div>
                    <div class="car-price">
                        <span>1 godz.</span>
                        <span>65,00 zł</span>
                    </div>
                    <button type="button">Rezerwacja</button>
                </div>
                <div class="car">
                    <div class="image-wrapper">
                        <img src="https://image.ceneostatic.pl/data/products/95699167/i-mercedes-sprinter-313-2013-r.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="img-overlay"></div>
                    </div>
                    <span class="car-name">Mercedes Sprinter</span>
                    <div class="divider"></div>
                    <div class="car-price">
                        <span>1 godz.</span>
                        <span>65,00 zł</span>
                    </div>
                    <button type="button">Rezerwacja</button>
                </div>
            </div>
        </section>
        <section class="contact-with-us">
            <div class="contact-wrapper">
                <div class="contact-text">
                    <h2>Skontaktuj się z nami</h2>
                    <ul>
                        <li>Puławska 11, 96-111 Warszawa</li>
                        <li>pawelporemba123@gmail.com</li>
                        <li>(+48) 123 456 789</li>
                    </ul>
                </div>
                <div class="image-wrapper"></div>
            </div>
        </section>
    </main>
    <footer>
        <section class="subscription-form">
            <form action="index.php" method="POST">
                <h3>Zapisz się na nasz newsletter</h3>
                <input type="email" placeholder="Adres e-mail" name="newsletter-mail" required>
                <br>
                <button type="submit">Zapisz się</button>
            </form>
        </section>
        <section class="bottom-content">
            <div class="footer-socials">
                <i class="fab fa-facebook"></i>
                <i class="fab fa-youtube"></i>
                <i class="fab fa-linkedin-in"></i>
            </div>
            <div class="bottom-text">&copy;2021 by Paweł Poremba</div>
        </section>
    </footer>
    <script>
        const checkInput = (name) => {
            name.addEventListener('invalid', () => {
                name.classList.add('subscription-input-invalid');
            });
            name.addEventListener('keyup', () => {
                name.classList.remove('subscription-input-invalid');
            });
        };
        const subscriptionInput = document.querySelector('.subscription-form form input[name="newsletter-mail"]');
        checkInput(subscriptionInput);
    </script>
    <script src="nav.js"></script>
</body>
</html>