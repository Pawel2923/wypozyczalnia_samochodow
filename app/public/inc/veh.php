<?php
function fetchVehicleData(): ?array
{
    global $db_connection;
    $path = $_SERVER['REQUEST_URI'];     // Pobranie ścieżki z URL
    if (str_contains($path, '/admin'))            // Sprawdzenie czy ściezka zawiera '/admin'
        require('../db/db_connection.php'); else
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
        return $vehicles;
    }

    return null;
}

enum PrintMethod: string
{
    case Card = "card";
    case Table = "table";
    case List = "list";
}

class PrintOptions
{
    public PrintMethod $method = PrintMethod::Card;
    public string $caption = 'button content';
    public int $limit = -1;
    public bool $available = true;
    public bool $recent = false;
    public bool $index = false;

    function __construct(PrintMethod $method = PrintMethod::Card, $caption = 'Wypożycz', $limit = -1, $available = true, $recent = false, $index = false)
    {
        $this->caption = $caption;
        $this->method = $method;
        $this->available = $available;
        $this->recent = $recent;
        $this->limit = $limit;
        $this->index = $index;
    }
}

function setImgUrlAndBtnCaption(object $vehicle, string $caption): array
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $img_url = ((strpos($path, 'admin/') || strpos($path, 'user/')) ? '../img/cars/' . $vehicle->img_url : 'img/cars/' . $vehicle->img_url);
    $buttonCaption = $caption === "availabilityCheck" ? ($vehicle->is_available ? 'Dostępny' : 'Niedostępny') : $caption;

    return [$img_url, $buttonCaption];
}

function printCard($vehicle, $caption): void
{
    [$img_url, $buttonCaption] = setImgUrlAndBtnCaption($vehicle, $caption);

    echo '<div class="car">
    <div class="image-wrapper">
            <img src="' . $img_url . '" alt="Zdjęcie samochodu" width="1024" height="687">
        </div>
        <span class="car-name">' . $vehicle->brand . ' ' . $vehicle->model . '</span>
        <div class="divider"></div>
        <div class="car-price">
            <span>1 doba</span>
            <span>' . str_replace(".", ",", $vehicle->price_per_day) . ' zł</span>
        </div>
        <button class="car-button" value="' . $vehicle->id . '">' . $buttonCaption . '</button>
    </div>';
}

function printList($vehicle, $caption): void
{
    [$img_url, $buttonCaption] = setImgUrlAndBtnCaption($vehicle, $caption);

    echo '<div class="vehicle">
        <div class="vehicle-name">
            ' . $vehicle->brand . ' ' . $vehicle->model . '
        </div>
        <div class="vehicle-content">
            <div class="vehicle-image">
                <img src="' . $img_url . '" alt="Zdjęcie samochodu" width="1024" height="687">
            </div>
            <div class="vehicle-price">
                <div>
                    <span>1 doba</span>
                    <br>
                    <span>' . str_replace(".", ",", $vehicle->price_per_day) . 'zł</span>
                </div>
                <button class="car-button" value="' . $vehicle->id . '">' . $buttonCaption . '</button>
            </div>
        </div>
    </div>';
}

function printTable(array $vehicles, object $options): void
{
    echo '<div class="table">
                    <table>
                        <tr>
            <th>ID</th>
            <th>Nazwa</th>
            <th>Cena za 1 dobę</th>
            <th>Dostępność</th>
        </tr>
                        ';
    foreach ($vehicles as $index => $vehicle) {
        //Ustawienie liczby pojazdów do wyświetlenia
        if ($options->limit >= 0 && $options->limit <= sizeof($vehicles)) { // Sprawdzenie czy limit został nadany i jest poprawny
            if ($index >= $options->limit) break;
        }

        echo '
        <tr>' .
            (($index + 1) ? ('<td>' . $vehicle->id . '</td>') : '') . '
            <td>' . $vehicle->brand . ' ' . $vehicle->model . '</td>
            <td>' . str_replace('.', ',', $vehicle->price_per_day) . '</td>
            <td>' . (($vehicle->is_available) ? 'Dostępny' : 'Niedostępny') . '</td>
        </tr>';
    }
    echo ' </table>
            </div>';
}

//Wyświetlanie informacji o pojazdach jako karty
function printCarInfo($options = null): ?true
{
    $vehicles = fetchVehicleData();

    if ($options === null) {
        $options = new PrintOptions;
    }

    if ($vehicles !== null) {
        if ($options->recent) {
            $vehicles = array_reverse($vehicles);
        }

        if ($options->method === PrintMethod::Table) {
            printTable($vehicles, $options);

            return true;
        }

        foreach ($vehicles as $index => $vehicle) {
            //Ustawienie liczby pojazdów do wyświetlenia
            if ($options->limit > 0 && $options->limit <= sizeof($vehicles)) { // Sprawdzenie czy limit został nadany i jest poprawny
                if ($index >= $options->limit) break;
            }

            if ($options->method === PrintMethod::Card) {
                printCard($vehicle, $options->caption);
            }

            if ($options->method === PrintMethod::List) {
                printList($vehicle, $options->caption);
            }
        }
        return true;
    } else {
        return null;
    }
}
