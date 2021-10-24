<?php session_start(); ?>
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
    <style>
        main {
            align-items: unset;
        }
        .vehicles {
            display: flex;
            flex-direction: column;
        }
        .vehicles .vehicle {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin-bottom: 20px;
        }
        .vehicles .vehicle:last-child {
            margin-bottom: 0;
        }
        .vehicles .vehicle>* {
            margin-right: 20px;
        }
        .vehicles .vehicle .vehicle-price {
            display: flex;
        }
        .vehicles .vehicle .vehicle-price div {
            margin-right: 20px;
        }
        .vehicles .vehicle .vehicle-image {
            width: 400px;
        }
        .vehicles button {
            width: fit-content;
            margin: 0;
        }
        @media screen and (max-width: 800px) {
            .vehicles .vehicle,
            .vehicles .vehicle .vehicle-price {
                flex-direction: column;
                align-items: center;
            }
            .vehicles .vehicle .vehicle-image {
                width: 100%;
                margin: 0;
            }
            .vehicles .vehicle .vehicle-price,
            .vehicles .vehicle .vehicle-price div {
                margin-right: 0;
                margin-left: 0;
            }
            .vehicles .vehicle div {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <?php require_once("nav.php") ?>
    <main>
        <section>
            <h2>Wybierz pojazd</h2>
            <div class="vehicles">
                <div class="vehicle">
                    <div class="vehicle-image">
                        <img src="https://ireland.apollo.olxcdn.com/v1/files/eyJmbiI6IjByc3gyc3BrZzQ4YjMtT1RPTU9UT1BMIiwidyI6W3siZm4iOiJ3ZzRnbnFwNnkxZi1PVE9NT1RPUEwiLCJzIjoiMTYiLCJwIjoiMTAsLTEwIiwiYSI6IjAifV19.hXuoemts_h7soE7DwcsvGnYuHhVCV0y0sCWXJ0ZzIVE/image;s=732x488" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="vehicle-name">
                            Toyota Yaris
                        </div>
                    </div>
                    <div class="vehicle-price">
                        <div>
                            <span>1 godz.</span>
                            <br>
                            <span>65,00zł</span>
                        </div>
                        <button>Wypożycz</button>
                    </div>
                </div>
                <div class="vehicle">
                    <div class="vehicle-image">
                        <img src="https://i.wpimg.pl/600x0/m.autokult.pl/ford-fusion-4-3ddb5b2d153e08d106.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="vehicle-name">
                            Ford Fusion
                        </div>
                    </div>
                    <div class="vehicle-price">
                        <div>
                            <span>1 godz.</span>
                            <br>
                            <span>55,00zł</span>
                        </div>
                        <button>Wypożycz</button>
                    </div>
                </div>
                <div class="vehicle">
                    <div class="vehicle-image">
                        <img src="https://www.auto-gazda.pl/application/files/8816/2861/3097/1.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="vehicle-name">
                            Volkswagen Gof
                        </div>
                    </div>
                    <div class="vehicle-price">
                        <div>
                            <span>1 godz.</span>
                            <br>
                            <span>65,00zł</span>
                        </div>
                        <button>Wypożycz</button>
                    </div>
                </div>
                <div class="vehicle">
                    <div class="vehicle-image">
                    <img src="https://image.ceneostatic.pl/data/products/95699167/i-mercedes-sprinter-313-2013-r.jpg" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="vehicle-name">
                            Mercedes Sprinter
                        </div>
                    </div>
                    <div class="vehicle-price">
                        <div>
                            <span>1 godz.</span>
                            <br>
                            <span>80,00zł</span>
                        </div>
                        <button>Wypożycz</button>
                    </div>
                </div>
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
    <?php include_once('logged.php'); ?>
</body>
</html>