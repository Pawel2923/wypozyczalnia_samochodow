<?php 
session_start();

if (isset($_POST['isLogged']))
{
    echo $_POST['isLogged'];
    if (!$_POST['isLogged'])
    {
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['vehicle-id']))
{
    $vehicleID = htmlentities($_POST['vehicle-id']);
    require('db/db_connection.php');
    $query = "SELECT * FROM vehicles WHERE id=?";
    $stmt = $db_connection->prepare($query);
    $stmt->bind_param('i', $vehicleID);
    $stmt->execute();
    $result = $stmt->get_result();

    $attribute = $result->fetch_assoc();

    $stmt->close();
    $db_connection->close();
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
    <script src="https://kit.fontawesome.com/32373b1277.js" crossorigin="anonymous"></script>
    <style> 
        .vehicle {
            margin-bottom: 50px;
        }
        .vehicle-name h2 {
            margin-bottom: 10px;
        }
        form input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            outline: none;
            margin-bottom: 10px;
            margin-top: 5px;
        }
        form button {
            width: 50%;
            margin-top: 50px;
        }
        .summary {
            margin-top: 40px;
        }
        .summary div {
            margin-top: 20px;
            border: 1px solid #000;
            padding: 10px;
        }
        .summary div:first-child {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <?php require_once("inc/nav.php") ?>
    <main>
        <section>
            <div class="vehicle">
                <div class="vehicle-name">
                    <h2><?php echo $attribute['marka'].' '.$attribute['model'];?></h2>
                </div>
                <div class="vehicle-image">
                    <img src="<?php echo $attribute['img_url']?>" alt="Zdjęcie samochodu" width="60%" height="60%">
                </div>
                <div class="description">
                    <div class="vehicle-price"><?php echo $attribute['cena']?>zł za 1 godzinę</div>
                </div>
            </div>
            <h2>Wypełnij formularz</h2>
            <form action="" method="POST">
                <label for="amount">Ilość godzin wynajmu</label>
                <input type="number" name="amount" value="1" min="0" required>
                <label for="date">Data wynajmu</label>
                <input type="date" name="date" required>
                <div class="summary">
                    <h2>Podsumowanie zamówienia</h2>
                    <div class="carName">
                        Nazwa pojazdu: 
                        <h3><?php echo $attribute['marka'].' '.$attribute['model'];?></h3>
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
                        <h3>00,00zł</h3>
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
        const input = document.querySelectorAll('input');
        for (let i=0; i<input.length; i++) {
            checkInput(input[i]);
        }

        const rentInput = document.querySelectorAll('section form input');

        for (let i=0; i<rentInput.length; i++) {
            rentInput[i].addEventListener('change', () => {
                const amount = document.querySelector('form input[name="amount"]').value;
                document.querySelector('.summary .amount').innerHTML = 'Liczba godzin wynajmu: <h3>'+amount+'</h3>';
                const date = document.querySelector('form input[name="date"]').value;
                document.querySelector('.summary .date').innerHTML = 'Data wynajmu: <h3>'+date+'</h3>'
                let total = amount * <?php echo $attribute['cena'] ?>;
                document.querySelector('.summary .price').innerHTML = 'W sumie do zapłaty: <h3>'+total.toFixed(2)+'</h3>';
            });
        }
    </script>
    <script src="js/nav.js"></script>
    <?php include_once('inc/logged.php'); ?>
</body>
</html>