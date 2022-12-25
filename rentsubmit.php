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

if (isset($_POST['amount']) && isset($_POST['date']) && isset($_SESSION['vehicle-id'])) {
    $vehicleID = $_SESSION['vehicle-id'];
    $amount = htmlentities($_POST['amount']);
    $date = htmlentities($_POST['date']);
    if ($amount > 0) {
        $today = date('Y-m-d');

        try {
            require('db/db_connection.php');

            $query = "SELECT id FROM users WHERE login=?";
            $stmt = $db_connection->prepare($query);
            $stmt->bind_param('s', $_SESSION['login']);
            $stmt->execute();

            $result = $stmt->get_result();
            $id = $result->fetch_assoc();
            $id = $id['id'];

            $stmt->close();

            $query = "SELECT id_pojazdu FROM rezerwacja WHERE id_pojazdu=? AND data_rezerwacji=?";
            $stmt = $db_connection->prepare($query);
            $stmt->bind_param('is', $vehicleID, $date);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $_SESSION['msg'] = 'Podany pojazd w tym dniu jest już zajęty.';
                $rentError = true;
            } else {
                if ($date > $today) {
                    $query = "INSERT INTO rezerwacja (id_pojazdu, id_klienta, data_rezerwacji, na_ile) VALUES(?, ?, ?, ?)";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param('iisi', $vehicleID, $id, $date, $amount);
                    $stmt->execute();
                    $stmt->close();

                    $query = "SELECT rented_vehicles FROM users WHERE id=?";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $rentedVehs = $stmt->get_result();
                    $rentedVehs = $rentedVehs->fetch_assoc();
                    $rentedVehs = $rentedVehs['rented_vehicles'];
                    $rentedVehs++;
                    $stmt->close();

                    $query = "UPDATE users SET rented_vehicles=? WHERE id=?";
                    $stmt = $db_connection->prepare($query);
                    $stmt->bind_param('ii', $rentedVehs, $id);
                    $stmt->execute();
                    $stmt->close();

                    $_SESSION['msg'] = 'Dziękujemy za korzystanie z naszych usług!';
                } else {
                    echo "<script>alert('Wprowadzono datę która minęła.')</script>";
                    echo "<script>history.go(-1);</script>";
                }
            }

            $db_connection->close();
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
        <h1>
            <?php echo $_SESSION['msg'];
            unset($_SESSION['msg']); ?>
        </h1>
        <?php
        if (isset($rentError))
            echo '<a href="javascript:void(0)" onclick="history.go(-1);"><button>Wróć</button></a>';
        else
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
                echo '<script>console.error("' . $consoleLog->content . '")</script>';
            } else {
                echo '<script>console.log("' . $consoleLog->content . '")</script>';
            }
        }
    }
    ?>
</body>

</html>