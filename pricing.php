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
    <link rel="Shortcut Icon" href="./img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        section {
            width: 60%;
        }
        section h2 {
            margin-bottom: 5px;
        }
        section p {
            margin-bottom: 20px;
        }
        section form input,
        section form textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            outline: none;
            margin-top: 10px;
            border: 1px solid #000;
        }
        section form textarea {
            resize: none;
            font-family: inherit;
            font-size: inherit;
            height: 200px;
        }
        section .contact {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }
        section .contact>* {
            margin-right: 10px;
        }
        section .contact>*:last-child {
            margin-right: 0;
        }
        section form button {
            margin-top: 20px;
            width: 50%;
        }
        @media screen and (max-width: 800px) {
            section {
                width: 100%;
            }
        }
        .message-wrapper {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
            z-index: 3;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .message {
            background-color: #fff;
            border: 1px solid #000;
            position: absolute;
            padding: 50px;
            max-width: 55%;
            z-index: 1;
            display: flex;
            text-align: center;
        }

        .message-wrapper>.overlay {
            content: '';
            background-color: rgba(0,0,0,.5);
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .message-wrapper .close {
            position: absolute;
            top: 6px;
            right: 10px;
            font-size: 1.5em;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php require_once("inc/nav.php") ?>
    <main>
        <?php include_once("./inc/message.php"); ?>
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
        const formInput = document.querySelectorAll('main form input, main form textarea');
        for (let i=0; i<formInput.length; i++) {
            checkInput(formInput[i]);
        }
        const msgCloseButton = document.querySelector('.message .close');
        const msgWrapper = document.querySelector('.message-wrapper');
        const msgOverlay = document.querySelector('.message-wrapper .overlay');

        if (msgCloseButton != null && msgWrapper != null && msgOverlay != null) {
            msgCloseButton.addEventListener('click', () => {
                msgWrapper.style.display = 'none';
            });
            msgOverlay.addEventListener('click', () => {
                msgWrapper.style.display = 'none';
            });
        }
    </script>
    <script src="js/nav.js"></script>
    <?php include_once('inc/logged.php'); ?>
</body>
</html>