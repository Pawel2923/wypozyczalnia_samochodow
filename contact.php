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
</head>
<body>
    <?php require_once("inc/nav.php") ?>
    <main>
        <section class="contact-with-us">
            <div class="contact-wrapper">
                <div class="contact-text">
                    <h2>Skontaktuj się z nami</h2>
                    <ul>
                        <li><a title="Otwórz w mapach Google" target="_blank" href="https://goo.gl/maps/kNkyDjoN2y8zmx7A6">Jana Długosza 40, 33-300 Nowy Sącz</a></li>
                        <li><a title="Wyślij email" href="mailto:wypoztczalnia123@domena.pl">wypozyczalnia123@domena.pl</a></li>
                        <li><a title="Zadzwoń" href="tel:+48 123 456 789">+48 123 456 789</a></li>
                    </ul>
                </div>
                <div class="image-wrapper"></div>
            </div>
        </section>
    </main>
    <footer>
        <section class="subscription-form">
            <form action="newsletter.php" method="POST">
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
    <script src="js/nav.js"></script>
    <?php include_once('inc/logged.php'); ?>
</body>
</html>