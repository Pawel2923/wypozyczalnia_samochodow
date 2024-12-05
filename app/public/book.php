<?php
global $db_connection, $consoleLog, $attribute;
require_once("./initial.php");
if (isset($_SESSION['isLogged'])) {
    if (!$_SESSION['isLogged']) {
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

if (isset($_GET['vehicle-id']) && isset($_SESSION['vehicle-id']))
    unset($_SESSION['vehicle-id']);

if (isset($_GET['vehicle-id']) || isset($_SESSION['vehicle-id'])) {
    if (isset($_GET['vehicle-id']))
        $vehicleID = htmlentities($_GET['vehicle-id']);
    else
        $vehicleID = htmlentities($_SESSION['vehicle-id']);

    try {
        require('db/db_connection.php');
        $query = "SELECT * FROM vehicles WHERE id=:vehicleID";
        $stmt = $db_connection->prepare($query);
        $stmt->bindParam('vehicleID', $vehicleID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        $attribute = $result;

        $_SESSION['vehicle-id'] = $vehicleID;
        $db_connection = null;
    } catch (PDOException $Exception) {
        $consoleLog->show = true;
        $consoleLog->content = $Exception;
        $consoleLog->is_error = true;
    } catch (Exception $Exception) {
        $Exception = addslashes($Exception);
        $Exception = str_replace("\n", "", $Exception);
        $consoleLog->show = true;
        $consoleLog->content = $Exception;
        $consoleLog->is_error = true;
    }
} else {
    $_SESSION['error'] = 'Nie wybrano samochodu.';
    header('Location: rental.php');
    exit;
}
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
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/book.css">
    <link rel="Shortcut Icon" href="./img/logo.svg" />
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once("inc/nav.php") ?>
    <main>
        <section>
            <div class="vehicle">
                <div class="vehicle-name">
                    <h2><?php echo $attribute['brand'] . ' ' . $attribute['model']; ?></h2>
                </div>
                <div class="vehicle-image">
                    <img src="img/cars/<?php echo $attribute['img_url'] ?>" alt="Zdjęcie samochodu" width="100%" height="100%">
                </div>
                <div class="description">
                    <div class="vehicle-price"><?php echo $attribute['price_per_day'] ?>zł za 1 dobę</div>
                </div>
            </div>
            <div class="message">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </div>
            <div class="error">
                <?php
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
                ?>
            </div>
            <h2>Wypełnij formularz</h2>
            <form action="rentsubmit.php" method="POST">
                <label for="amount">Ilość dni wynajmu</label>
                <input type="number" name="amount" id="amount" value="1" min="1" required>
                <label for="date">Data wynajmu</label>
                <input type="date" name="date" id="date" required>
                <div class="summary">
                    <h2>Podsumowanie zamówienia</h2>
                    <div class="carName">
                        Nazwa pojazdu:
                        <h3><?php echo $attribute['brand'] . ' ' . $attribute['model']; ?></h3>
                    </div>
                    <div class="amount">
                        Ilość dni wynajmu:
                        <h3>1</h3>
                    </div>
                    <div class="date">
                        Data wynajmu:
                        <h3>dd.mm.rrrr</h3>
                    </div>
                    <div class="price">
                        W sumie do zapłaty:
                        <h3><?php echo $attribute['price_per_day'] ?>zł</h3>
                    </div>
                </div>
                <button type="submit">Zarezerwuj</button>
            </form>
        </section>
    </main>
    <footer>
        <section class="subscription-form">
            <form action="newsletter.php" method="POST">
                <h3>Zapisz się na nasz newsletter</h3>
                <label for="newsletter-mail"></label>
                <input type="email" placeholder="Adres e-mail" name="newsletter-mail" id="newsletter-mail" required>
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
    <script src="js/book.js" type="module" value="<?php echo $attribute['price_per_day']; ?>"></script>
    <?php
    include_once('./inc/logged.php');
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