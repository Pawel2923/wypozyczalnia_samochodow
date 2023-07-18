<?php
$fetch_is_success = false;

function fetchVehicleData()
{
    $path = $_SERVER['REQUEST_URI'];     // Pobranie ścieżki z URL
    if (strpos($path, '/admin') !== false)            // Sprawdzenie czy ściezka zawiera '/admin'
        require('../db/db_connection.php');
    else
        require('db/db_connection.php');

    if (!isset($_SESSION['connectionError'])) {
        //Pobranie danych z tabeli vehicles
        $query = "SELECT * FROM vehicles";
        $stmt = $db_connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $vehicles = $result; //Przypisanie wszystkich rekordów do $vehicles
        $db_connection = null;
        $result = null;
        $fetch_is_success = true;
        return $vehicles;
    }

    return null;
}

#[AllowDynamicProperties]
class PrintOptions
{
    public $caption = 'button content';
    public $method = 'print method';
    public $available = true;
    public $recent = false;
    public $limit = -1;
    public $index = -1;

    function __construct($caption = 'Wypożycz', $method = 'card', $available = true, $recent = false, $limit = -1, $index = -1)
    {
        $this->caption = $caption;
        $this->method = $method;
        $this->available = $available;
        $this->$recent = $recent;
        $this->limit = $limit;
        $this->index = $index;
    }
};

//Wyświetlanie informacji o pojazdach jako karty
function printCarInfo($options = null)
{
    $vehicles = fetchVehicleData();

    echo "Siup";

    if ($options === null) {
        $options = new PrintOptions;
    }

    if ($vehicles !== null) {
        foreach ($vehicles as $vehicle) {
            //Ustawienie liczby pojazdów do wyświetlenia
            if ($options->limit > 0 && $options->limit <= sizeof($vehicles)) { // Sprawdzenie czy limit został nadany i jest poprawny
                if ($vehicle->id >= $options->limit) break;
            }

            if ($options->method === 'card') {
                if ($options->recent) {
                    if ($options->available) {
                        if ($vehicle->is_available) { // Wypisanie tylko dostępnych pojazdów
?>
                            <div class="car">
                                <div class="image-wrapper">
                                    <img src="<?php
                                                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                                if (strpos($path, 'admin/') || strpos($path, 'user/'))
                                                    echo '../img/cars/' . $vehicle->img_url;
                                                else
                                                    echo 'img/cars/' . $vehicle->img_url;

                                                ?>" alt="Zdjęcie samochodu" width="1024" height="687">
                                </div>
                                <span class="car-name"><?php echo $vehicle->brand . ' ' . $vehicle->model ?></span>
                                <div class="divider"></div>
                                <div class="car-price">
                                    <span>1 godz.</span>
                                    <span><?php echo str_replace(".", ",", $vehicle->price) ?> zł</span>
                                </div>
                                <button class="car-button" value="<?php echo $vehicle->id ?>"><?php echo $options->caption ?></button>
                            </div>
                        <?php
                        }
                    } else { // Wypisanie wszystkich pojazdów
                        ?>
                        <div class="car">
                            <div class="image-wrapper">
                                <img src="<?php
                                            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                            if (strpos($path, 'admin/') || strpos($path, 'user/'))
                                                echo '../img/cars/' . $vehicle->img_url;
                                            else
                                                echo 'img/cars/' . $vehicle->img_url;
                                            ?>" alt="Zdjęcie samochodu" width="1024" height="687">
                            </div>
                            <span class="car-name"><?php echo $vehicle->brand . ' ' . $vehicle->model ?></span>
                            <div class="divider"></div>
                            <div class="car-price">
                                <span>1 godz.</span>
                                <span><?php echo str_replace(".", ",", $vehicle->price) ?> zł</span>
                            </div>
                            <button class="car-button" value="<?php echo $vehicle->id ?>">
                                <?php
                                if ($options->caption === "availabilityCheck") {
                                    if ($vehicle->isAvailable)
                                        echo 'Dostępny';
                                    else
                                        echo 'Niedostępny';
                                } else
                                    echo $options->caption;
                                ?>
                            </button>
                        </div>
                        <?php
                    }
                } else {
                    if ($options->available) {
                        if ($vehicle->isAvailable) { // Wypisanie tylko dostępnych pojazdów
                        ?>
                            <div class="car">
                                <div class="image-wrapper">
                                    <img src="<?php
                                                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                                if (strpos($path, 'admin/') || strpos($path, 'user/'))
                                                    echo '../img/cars/' . $vehicle->img_url;
                                                else
                                                    echo 'img/cars/' . $vehicle->img_url;
                                                ?>" alt="Zdjęcie samochodu" width="1024" height="687">
                                </div>
                                <span class="car-name"><?php echo $vehicle->brand . ' ' . $vehicle->model ?></span>
                                <div class="divider"></div>
                                <div class="car-price">
                                    <span>1 godz.</span>
                                    <span><?php echo str_replace(".", ",", $vehicle->price) ?> zł</span>
                                </div>
                                <button class="car-button" value="<?php echo $vehicle->id ?>"><?php echo $options->caption ?></button>
                            </div>
                        <?php
                        }
                    } else { // Wypisanie wszystkich pojazdów
                        ?>
                        <div class="car">
                            <div class="image-wrapper">
                                <img src="<?php
                                            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                            if (strpos($path, 'admin/') || strpos($path, 'user/'))
                                                echo '../img/cars/' . $vehicle->img_url;
                                            else
                                                echo 'img/cars/' . $vehicle->img_url;
                                            ?>" alt="Zdjęcie samochodu" width="1024" height="687">
                            </div>
                            <span class="car-name"><?php echo $vehicle->brand . ' ' . $vehicle->model ?></span>
                            <div class="divider"></div>
                            <div class="car-price">
                                <span>1 godz.</span>
                                <span><?php echo str_replace(".", ",", $vehicle->price) ?> zł</span>
                            </div>
                            <button class="car-button" value="<?php echo $vehicle->id ?>">
                                <?php
                                if ($options->caption === "availabilityCheck") {
                                    if ($vehicle->isAvailable)
                                        echo 'Dostępny';
                                    else
                                        echo 'Niedostępny';
                                } else
                                    echo $options->caption;
                                ?>
                            </button>
                        </div>
                    <?php
                    }
                }
            }

            if ($options->method === 'list') {
                if ($options->available) {
                    if ($vehicle->isAvailable) {
                    ?>
                        <div class="vehicle">
                            <div class="vehicle-name">
                                <?php echo $vehicle->brand . ' ' . $vehicle->model ?>
                            </div>
                            <div class="vehicle-content">
                                <div class="vehicle-image">
                                    <img src="<?php
                                                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                                if (strpos($path, 'admin/') || strpos($path, 'user/'))
                                                    echo '../img/cars/' . $vehicle->img_url;
                                                else
                                                    echo 'img/cars/' . $vehicle->img_url;
                                                ?>" alt="Zdjęcie samochodu" width="1024" height="687">
                                </div>
                                <div class="vehicle-price">
                                    <div>
                                        <span>1 godz.</span>
                                        <br>
                                        <span><?php echo str_replace(".", ",", $vehicle->price) ?> zł</span>
                                    </div>
                                    <button class="car-button" value="<?php echo $vehicle->id ?>">
                                        <?php
                                        if ($options->caption === "availabilityCheck") {
                                            if ($vehicle->isAvailable)
                                                echo 'Dostępny';
                                            else
                                                echo 'Niedostępny';
                                        } else
                                            echo $options->caption;
                                        ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="vehicle">
                        <div class="vehicle-name">
                            <?php echo $vehicle->brand . ' ' . $vehicle->model ?>
                        </div>
                        <div class="vehicle-content">
                            <div class="vehicle-image">
                                <img src="<?php
                                            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                            if (strpos($path, 'admin/') || strpos($path, 'user/'))
                                                echo '../img/cars/' . $vehicle->img_url;
                                            else
                                                echo 'img/cars/' . $vehicle->img_url;
                                            ?>" alt="Zdjęcie samochodu" width="1024" height="687">
                            </div>
                            <div class="vehicle-price">
                                <div>
                                    <span>1 godz.</span>
                                    <br>
                                    <span><?php echo str_replace(".", ",", $vehicle->price) ?> zł</span>
                                </div>
                                <button class="car-button" value="<?php echo $vehicle->id ?>">
                                    <?php
                                    if ($options->caption === "availabilityCheck") {
                                        if ($vehicle->isAvailable)
                                            echo 'Dostępny';
                                        else
                                            echo 'Niedostępny';
                                    } else
                                        echo $options->caption;
                                    ?>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }

            if ($options->method === 'table') {
                ?>
                <div class="table">
                    <table>
                        <tr>
                            <?php if ($options->index) echo '<th>ID</th>'; ?>
                            <th>Nazwa</th>
                            <th>Cena za 1 godz.</th>
                            <th>Dostępność</th>
                        </tr>
                        <?php
                        echo '<tr>';
                        if ($options->index) echo '<td>' . $vehicle->id . '</td>';
                        echo '<td>' . $vehicle->brand . ' ' . $vehicle->model . '</td>';
                        echo '<td>' . str_replace(".", ",", $vehicle->price) . '</td>';
                        echo '<td>';
                        if ($vehicle->isAvailable)
                            echo "Dostępny";
                        else
                            echo "Niedostępny";

                        echo '</td>';
                        echo '</tr>';
                        ?>
                    </table>
                </div>
<?php
            }
        }
    }
}
