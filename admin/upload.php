<?php
$allowedExt = array("jpg", "jpeg", "gif", "png");

$dir = '../img/';
$target = $dir.basename($_FILES['vehicle-img']['name']);

if (!file_exists($target)) // Sprawdzenie czy plik istnieje
{
    if ($_FILES['vehicle-img']['size'] > (1048576 * 2))
    {
        $_SESSION['error'] = 'Plik nie może być większy niż 2 MB.';
    }
    else 
    {
        $ext = explode('.', strtolower($_FILES['vehicle-img']['name']));    // Rozszerzenie pliku

        if (in_array(end($ext), $allowedExt)) // Sprawdzenie czy rozszerzenie jest obsługiwane
        {
            if (move_uploaded_file($_FILES['vehicle-img']['tmp_name'], $target))
            {
                $_SESSION['msg'] = 'Plik został pomyślnie przesłany.';
                $_SESSION['vehicle-img-name'] = $_FILES['vehicle-img']['name'];
            }
            else 
            {
                $_SESSION['error'] = 'Wystąpił błąd podczas przesyłania pliku.';
            }
        }
        else
        {
            $_SESSION['error'] = 'Dopuszczalne rozszerzenia zdjęcia to jpg, jpeg, gif i png.';
        }
    }
}
else 
{
    $_SESSION['msg'] = 'Ten plik już istnieje. Wybrano istniejący plik.';
    $_SESSION['vehicle-img-name'] = $_FILES['vehicle-img']['name'];
}
header('Location: addvehicles.php');
exit;