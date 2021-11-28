<?php
//Połączenie z baza danych
$path = $_SERVER['REQUEST_URI'];     // Pobranie ścieżki z URL
if (strpos($path, '/admin') !== false)            // Sprawdzenie czy ściezka zawiera '/admin'
    require('../db/db_connection.php');
else 
    require('db/db_connection.php');
//Pobranie danych z tabeli vehicles
$query = "SELECT * FROM vehicles";
$stmt = $db_connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$vehicles = $result->fetch_all(); //Przypisanie wszystkich rekordów do $vehicles
$stmt->close();
$db_connection->close();

class Vehicle
{
    public $id;
    public $brand;
    public $model;
    public $price;
    public $img_url;
    public $isAvailable;

    function setProperty($value, $propertyName)
    {
        $this->$propertyName = $value;
    }
}

//Ustawienie właściwości dla pojazdów
$vehNum = sizeof($vehicles); // Zmienna zawiera liczbę pojazdów

//Stworzenie obiektów vehicle i ustawienie ich właściwości
if ($vehNum > 0)
{
    for ($i=0; $i<$vehNum; $i++)
    {
        $vehicle[$i] = new Vehicle();
        $properties = get_object_vars($vehicle[$i]);  // Pobranie właściwości
        $properties = array_keys($properties);  // Pobranie nazw kluczy
        for ($j=0; $j<6; $j++)
        {
            $vehicle[$i]->setProperty($vehicles[$i][$j], $properties[$j]);  // Ustawienie właściwości
        }
    }
}

//Wyświetlanie informacji o pojazdach jako karty
function printCarInfo($buttonCaption, $vehNum, $vehicle, $printUnavailable = false, $limit = 0)
{
    if (isset($vehicle))
    {
        if ($limit > 0 && $limit <= $vehNum)
        {
            $n = $limit;
            if (!$printUnavailable)
            {
                for ($i=0; $i<$limit; $i++)
                {
                    if (!($vehicle[$i]->isAvailable))
                    {
                        $n++;
                    }
                }
            }
        }
        else 
        {
            $n = $vehNum;
        }

        for ($i=0; $i<$n; $i++) 
        {
            if (!$printUnavailable)
            {
                if ($vehicle[$i]->isAvailable) 
                {
?>
                    <div class="car">
                    <div class="image-wrapper">
                        <img src="<?php 
                            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                            if (strpos($path, 'admin/') || strpos($path, 'user/'))
                            {
                                if (filter_var($vehicle[$i]->img_url, FILTER_VALIDATE_URL))
                                    echo $vehicle[$i]->img_url;
                                else 
                                    echo '../'.$vehicle[$i]->img_url;
                            }
                            else 
                                echo $vehicle[$i]->img_url;
                        ?>" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="img-overlay"></div>
                    </div>
                    <span class="car-name"><?php echo $vehicle[$i]->brand.' '.$vehicle[$i]->model ?></span>
                    <div class="divider"></div>
                    <div class="car-price">
                        <span>1 godz.</span>
                        <span><?php echo $vehicle[$i]->price ?> zł</span>
                    </div>
                    <button class="car-button"><?php echo $buttonCaption ?></button>
                    </div>
<?php
                }
            }
            else 
            {
?>
                <div class="car">
                <div class="image-wrapper">
                    <img src="<?php 
                        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                        if (strpos($path, 'admin/') || strpos($path, 'user/'))
                        {
                            if (filter_var($vehicle[$i]->img_url, FILTER_VALIDATE_URL))
                                echo $vehicle[$i]->img_url;
                            else 
                                echo '../'.$vehicle[$i]->img_url;
                        }
                        else 
                            echo $vehicle[$i]->img_url;
                     ?>" alt="Zdjęcie samochodu" width="100%" height="100%">
                    <div class="img-overlay"></div>
                </div>
                <span class="car-name"><?php echo $vehicle[$i]->brand.' '.$vehicle[$i]->model ?></span>
                <div class="divider"></div>
                <div class="car-price">
                    <span>1 godz.</span>
                    <span><?php echo $vehicle[$i]->price ?> zł</span>
                </div>
                <button class="car-button">
                    <?php 
                        if ($buttonCaption === "availabilityCheck")
                        {
                            if ($vehicle[$i]->isAvailable)
                                echo 'Dostępny';
                            else 
                                echo 'Niedostępny';
                        } 
                        else 
                            echo $buttonCaption;
                    ?>
                </button>
                </div>
<?php
            }
        }
    }
}

//Wyświetlenie informacji o pojazdach jako tabela
function printCarInfoTable($vehNum, $vehicle, $limit = 0, $printIndex = false)
{
    if (isset($vehicle))
    {
        if ($limit > 0 && $limit <= $vehNum)
            $n = $limit;
        else 
            $n = $vehNum;
    ?>
        <table>
            <tr>
                <?php if ($printIndex) echo '<th>ID</th>' ?>
                <th>Nazwa</th>
                <th>Cena za 1 godz.</th>
                <th>Dostępność</th>
            </tr>
            <?php
                for ($i=0; $i<$n; $i++) 
                {
                    echo '<tr>';
                        if ($printIndex) echo '<td>'.$vehicle[$i]->id.'</td>';
                        echo '<td>'.$vehicle[$i]->brand.' '.$vehicle[$i]->model.'</td>';
                        echo '<td>'.$vehicle[$i]->price.'</td>';
                        echo '<td>';
                        if ($vehicle[$i]->isAvailable)
                            echo "Dostępny";
                        else 
                            echo "Niedostępny";
                        echo '</td>';
                    echo '</tr>';
                }
            ?>
        </table>
<?php
    }
}

//Wyświetlenie informacji o pojazdach jako lista
function printCarInfoList($buttonCaption, $vehNum, $vehicle, $printUnavailable = false, $limit = 0)
{
    if (isset($vehicle))
    {
        if ($limit > 0 && $limit <= $vehNum)
        {
            $n = $limit;
            if (!$printUnavailable)
            {
                for ($i=0; $i<$limit; $i++)
                {
                    if (!($vehicle[$i]->isAvailable))
                    {
                        $n++;
                    }
                }
            }
        }
        else 
        {
            $n = $vehNum;
        }

        for ($i=0; $i<$n; $i++) 
        {
            if (!$printUnavailable) 
            {
                if ($vehicle[$i]->isAvailable) 
                {
?>
                    <div class="vehicle">
                        <div class="vehicle-image">
                        <img src="<?php 
                            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                            if (strpos($path, 'admin/') || strpos($path, 'user/'))
                            {
                                if (filter_var($vehicle[$i]->img_url, FILTER_VALIDATE_URL))
                                    echo $vehicle[$i]->img_url;
                                else 
                                    echo '../'.$vehicle[$i]->img_url;
                            }
                            else 
                                echo $vehicle[$i]->img_url;
                        ?>" alt="Zdjęcie samochodu" width="100%" height="100%">
                            <div class="vehicle-name">
                                <?php echo $vehicle[$i]->brand.' '.$vehicle[$i]->model ?>
                            </div>
                        </div>
                        <div class="vehicle-price">
                            <div>
                                <span>1 godz.</span>
                                <br>
                                <span><?php echo $vehicle[$i]->price ?> zł</span>
                            </div>
                            <button class="car-button" name="vehicle-id" value="<?php echo $vehicle[$i]->id ?>"><?php echo $buttonCaption ?></button>
                        </div>
                    </div>
<?php
                }
            }
            else 
            {
?>
                <div class="vehicle">
                    <div class="vehicle-image">
                    <img src="<?php 
                        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                        if (strpos($path, 'admin/') || strpos($path, 'user/'))
                        {
                            if (filter_var($vehicle[$i]->img_url, FILTER_VALIDATE_URL))
                                echo $vehicle[$i]->img_url;
                            else 
                                echo '../'.$vehicle[$i]->img_url;
                        }
                        else 
                            echo $vehicle[$i]->img_url;
                     ?>" alt="Zdjęcie samochodu" width="100%" height="100%">
                        <div class="vehicle-name">
                            <?php echo $vehicle[$i]->brand.' '.$vehicle[$i]->model ?>
                        </div>
                    </div>
                    <div class="vehicle-price">
                        <div>
                            <span>1 godz.</span>
                            <br>
                            <span><?php echo $vehicle[$i]->price ?> zł</span>
                        </div>
                        <button class="car-button">
                            <?php 
                                if ($buttonCaption === "availabilityCheck")
                                {
                                    if ($vehicle[$i]->isAvailable)
                                        echo 'Dostępny';
                                    else 
                                        echo 'Niedostępny';
                                } 
                                else 
                                    echo $buttonCaption;
                            ?>
                        </button>
                    </div>
                </div>
<?php
            }
        }
    }
}