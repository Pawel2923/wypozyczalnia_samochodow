<?php
global $db_connection, $consoleLog;
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

if (isset($_POST['amount']) && isset($_POST['date']) && isset($_SESSION['vehicle-id'])) {
    $vehicleID = $_SESSION['vehicle-id'];
    $amount = htmlentities($_POST['amount']);
    $date = htmlentities($_POST['date']);
    if ($amount > 0) {
        $today = date('Y-m-d');

        require('db/db_connection.php');

        $query = "SELECT id FROM users WHERE login=:login";
        $stmt = $db_connection->prepare($query);
        $stmt->bindParam('login', $_SESSION['login']);
        $stmt->execute();

        $result = $stmt->fetch();
        $id = $result['id'];

        $query = "SELECT vehicle_id FROM reservations WHERE vehicle_id=:vehId AND date=:date";
        $stmt = $db_connection->prepare($query);
        $stmt->bindParam('vehId', $vehicleID);
        $stmt->bindParam('date', $date);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($stmt->rowCount() > 0) {
            $_SESSION['msg'] = 'Podany pojazd w tym dniu jest już zajęty.';
            $rentError = true;
        } else {
            if ($date > $today) {
                $query = "INSERT INTO reservations (vehicle_id, client_id, date, days_count) VALUES (:vehId, :clientId, :date, :days)";
                $stmt = $db_connection->prepare($query);
                $stmt->bindParam('vehId', $vehicleID);
                $stmt->bindParam('clientId', $id);
                $stmt->bindParam('date', $date);
                $stmt->bindParam('days', $amount);
                $stmt->execute();

                $query = "SELECT rented_vehicles FROM users WHERE id=:id";
                $stmt = $db_connection->prepare($query);
                $stmt->bindParam('id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $rentedVehs = $stmt->fetch();
                $rentedVehs = $rentedVehs['rented_vehicles'];
                $rentedVehs++;

                $query = "UPDATE users SET rented_vehicles=:vehiclesCount WHERE id=:id";
                $stmt = $db_connection->prepare($query);
                $stmt->bindParam('vehiclesCount', $rentedVehs);
                $stmt->bindParam('id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $_SESSION['msg'] = 'Dziękujemy za korzystanie z naszych usług!';
            } else {
                echo "<script nonce='alertScript'>alert('Wprowadzono datę która minęła.')</script>";
                echo "<script nonce='historyPrev'>history.go(-1);</script>";
            }
        }

        $db_connection = null;
    } else {
        $_SESSION['msg'] = 'Liczba godzin powinna być większa niż 0.';
        $rentError = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Paweł Poremba">
    <meta name="description"
          content="Wypożycz samochód szybko i wygodnie, sprawdź kiedy masz zwrócić samochód i wiele więcej funkcji.">
    <meta name="keywords"
          content="samochód, auto, wypożyczalnia, wypożycz, szybko, wygodnie, łatwo, duży wybór, polska">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wypożyczalnia samochodów</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/newsletter.css">
    <link rel="Shortcut Icon" href="./img/logo.svg"/>
    <script src="https://kit.fontawesome.com/32373b1277.js" nonce="kitFontawesome" crossorigin="anonymous"></script>
</head>

<body>
<main>
    <h1>
        <?php echo $_SESSION['msg'];
        unset($_SESSION['msg']); ?>
    </h1>
    <?php
    if (isset($rentError)) echo '<a href="javascript:void(0)" onclick="history.go(-1);"><button>Wróć</button></a>'; else
        echo '<a href="index.php"><button>Wróć na stronę główną</button></a>';
    ?>
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
