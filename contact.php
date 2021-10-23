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
    <nav class="mobile-nav">
        <div class="open"><i class="fas fa-bars"></i></div>
        <div class="nav-wrapper">
            <div class="top-content">
                <div></div>
                <div class="close"><i class="fas fa-times"></i></div>
                <div class="user">
                    <a href="login.php" class="login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="login-caption">Zaloguj się</span>
                    </a>
                    <a href="admin.php" class="logged">
                        <i class="fas fa-user"></i>
                        <span class="login-caption"><?php echo $_SESSION['login'] ?></span>
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
                <a href="login.php" class="login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="login-caption">Zaloguj się</span>
                </a>
                <a href="admin.php" class="logged">
                    <i class="fas fa-user"></i>
                    <span class="login-caption"><?php echo $_SESSION['login'] ?></span>
                </a>
            </div>
        </div>
    </nav>
    <main>
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
    <?php 
        if ($_SESSION['logged'])
            echo '<script src="logged.js"></script>';
    ?>
</body>
</html>