<?php session_start();
include_once("./inc/consoleMessage.php");
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
    <link rel="stylesheet" href="styles/newsletter.css">
    <link rel="Shortcut Icon" href="./img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
</head>

<body>
    <main>
        <?php
        if (isset($_POST['newsletter-mail'])) {
            if (filter_var($_POST['newsletter-mail'], FILTER_VALIDATE_EMAIL)) {
                $email = htmlentities($_POST['newsletter-mail']);
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);

                try {
                    require('db/db_connection.php');

                    if (isset($db_connection)) {
                        $query = "SELECT email FROM newsletter WHERE email=:email";
                        $stmt = $db_connection->prepare($query);
                        $stmt->bindParam('email', $email, PDO::PARAM_STR);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_OBJ);

                        if ($stmt->rowCount() > 0)
                            $_SESSION['msg'] = 'Podany adres e-mail jest już zapisany na newsletterze.';
                        else {
                            $query = "INSERT INTO newsletter (email) VALUES (:email)";
                            $stmt = $db_connection->prepare($query);

                            $stmt->bindParam('email', $email, PDO::PARAM_STR);
                            $stmt->execute();

                            $_SESSION['msg'] = 'Dziękujemy za zapisanie się na nasz newsletter!';
                        }

                        $db_connection = null;
                    } else {
                        throw new Exception("Nie udało połączyć się z bazą danych");
                    }
                } catch (Exception $Exception) {
                    $Exception = addslashes($Exception);
                    $Exception = str_replace("\n", "", $Exception);
                    $consoleLog->show = true;
                    $consoleLog->content = $Exception;
                    $consoleLog->is_error = true;
                    $_SESSION["error"] = $Exception;
                } catch (PDOException $Exception) {
                    $consoleLog->show = true;
                    $consoleLog->content = $Exception;
                    $consoleLog->is_error = true;
                    $_SESSION["error"] = $Exception;
                }
            } else
                echo '<script nonce="historyPrev">history.go(-1)</script>';
        } else
            echo '<script nonce="historyPrev">history.go(-1)</script>';
        ?>
        <h1>
            <?php
            if (!$_SESSION["error"]) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            } else {
                echo "Wystąpił błąd podczas przetwarzania operacji.<br/>Spróbuj ponownie później.";
            }
            ?>
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