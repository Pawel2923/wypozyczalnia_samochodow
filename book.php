<?php
session_start();
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
        $query = "SELECT * FROM vehicles WHERE id=?";
        $stmt = $db_connection->prepare($query);
        $stmt->bind_param('i', $vehicleID);
        $stmt->execute();
        $result = $stmt->get_result();

        $attribute = $result->fetch_assoc();

        $stmt->close();
        $db_connection->close();
        $_SESSION['vehicle-id'] = $vehicleID;
    } catch (Exception $error) {
        $error = addslashes($error);
        $error = str_replace("\n", "", $error);
        $consoleLog->show = true;
        $consoleLog->content = $error;
        $consoleLog->is_error = true;
    } catch (mysqli_sql_exception $error) {
        $consoleLog->show = true;
        $consoleLog->content = $error;
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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once("inc/nav.php") ?>
    <main>
        <section>
            <div class="vehicle">
                <div class="vehicle-name">
                    <h2><?php echo $attribute['marka'] . ' ' . $attribute['model']; ?></h2>
                </div>
                <div class="vehicle-image">
                    <img src="img/cars/<?php echo $attribute['img_url'] ?>" alt="Zdjęcie samochodu" width="100%" height="100%">
                </div>
                <div class="description">
                    <div class="vehicle-price"><?php echo $attribute['cena'] ?>zł za 1 godzinę</div>
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
                <label for="amount">Ilość godzin wynajmu</label>
                <input type="number" name="amount" value="1" min="1" required>
                <label for="date">Data wynajmu</label>
                <input type="date" name="date" required>
                <div class="summary">
                    <h2>Podsumowanie zamówienia</h2>
                    <div class="carName">
                        Nazwa pojazdu:
                        <h3><?php echo $attribute['marka'] . ' ' . $attribute['model']; ?></h3>
                    </div>
                    <div class="amount">
                        Liczba godzin wynajmu:
                        <h3>1</h3>
                    </div>
                    <div class="date">
                        Data wynajmu:
                        <h3>dd.mm.rrrr</h3>
                    </div>
                    <div class="price">
                        W sumie do zapłaty:
                        <h3><?php echo $attribute['cena'] ?>zł</h3>
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
    <script src="js/book.js" type="module" value="<?php echo $attribute['cena']; ?>"></script>
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