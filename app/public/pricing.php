<?php 
    require_once("./initial.php");
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Paweł Poremba" />
    <meta name="description" content="Wypożycz samochód szybko i wygodnie, sprawdź kiedy masz zwrócić samochód i wiele więcej funkcji." />
    <meta name="keywords" content="samochód, auto, wypożyczalnia, wypożycz, szybko, wygodnie, łatwo, duży wybór, polska" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wypożyczalnia samochodów</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles/main.css" />
    <link rel="stylesheet" href="styles/index.css" />
    <link rel="stylesheet" href="styles/pricing.css" />
    <link rel="Shortcut Icon" href="./img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once("inc/nav.php") ?>
    <main>
        <?php if (isset($_SESSION['error']) || isset($_SESSION['msg'])) include_once("./inc/message.php"); ?>
        <section>
            <h2>Uzyskaj wycenę</h2>
            <p>Chcesz wypożyczyć pojazd na swoją następną przygodę? Wpisz poniżej swoje dane, a ktoś z naszego zespołu wkrótce skontaktuje się, aby przekazać Ci wycenę.</p>
            <form action="send.php" method="POST">
                <input type="text" name="name" placeholder="Imię*" required>
                <input type="text" name="sName" placeholder="Nazwisko*" required>
                <div class="contact">
                    <input type="email" name="email" placeholder="Adres e-mail*" required>
                    <input type="tel" name="tel" placeholder="Nr telefonu">
                </div>
                <textarea name="message" placeholder="Wiadomość*" required></textarea>
                <button type="submit">Wyślij</button>
            </form>
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
            <div class="bottom-text">&copy;2022 by Paweł Poremba</div>
        </section>
    </footer>
    <script src="js/pricing.js" type="module"></script>
    <script src="js/message.js"></script>
    <?php include_once('inc/logged.php'); ?>
    <?php
    if (isset($consoleLog)) {
        if ($consoleLog->show) {
            if ($consoleLog->is_error) {
                echo '<script src="js/log.js" value="' . $consoleLog->content . '" name="error"></script>';
            } else {
                echo '<script src="js/log.js" value="' . $consoleLog->content . '" name="log"></script>';
            }
        }
    }
    ?>
</body>

</html>