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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style>
        body {
            display: flex;
            height: 90vh;
            align-items: center;
            justify-content: center;
        }
        main {
            width: 80%;
            text-align: center;
        }
        button {
            margin-top: 10px;
            width: 50%;
        }
        footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            grid-template-rows: auto;
            padding: 20px;
        }
    </style>
</head>
<body>
<main>
    <?php
        if (isset($_POST['newsletter-mail'])) {
            if (filter_var($_POST['newsletter-mail'], FILTER_VALIDATE_EMAIL)) {
                $email = htmlentities($_POST['newsletter-mail']);
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);

                require('db/db_connection.php');
                
                $query = "SELECT email FROM newsletter WHERE email=?";
                $stmt = $db_connection->prepare($query);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if ($result->num_rows > 0)
                    $_SESSION['msg'] = 'Podany adres e-mail jest już zapisany na newsletterze.';
                else {
                    $query = "INSERT INTO newsletter (email) VALUES (?)";
                    $stmt = $db_connection->prepare($query);

                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    
                    $_SESSION['msg'] = 'Dziękujemy za zapisanie się na nasz newsletter!';

                    $stmt->close();
                }

                $db_connection->close();
            }
            else 
                echo '<script>history.go(-1)</script>';
        }
        else 
            echo '<script>history.go(-1)</script>';
    ?>
    <h1>
        <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
    </h1>
    <a href="index.php"><button>Wróć na stronę główną</button></a>
</main>
<footer>
    <section class="bottom-content">
        <div class="footer-socials">
            <i class="fab fa-facebook"></i>
            <i class="fab fa-youtube"></i>
            <i class="fab fa-linkedin-in"></i>
        </div>
        <div class="bottom-text">&copy;2022 by Paweł Poremba</div>
    </section>
</footer>
</body>
</html>