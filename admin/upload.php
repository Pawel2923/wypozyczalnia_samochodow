<?php
session_start();
$allowedTypes = array("jpg", "jpeg", "gif", "png");

if (!!$_FILES['vehicle-img']['tmp_name']) // Sprawdzenie czy plik istnieje
{
    $ext = explode('.', strtolower($_FILES['vehicle-img']['name']));    // Rozszerzenie pliku

    $dir = '../img/';

    if (in_array(end($ext), $allowedTypes)) // Sprawdzenie czy rozszerzenie jest obsługiwane
    {
        if (move_uploaded_file($_FILES['vehicle-img']['tmp_name'], $dir.basename($_FILES['vehicle-img']['name'])))
        {
            $_SESSION['msg'] = 'Plik został pomyślnie przesłany.';
            $_SESSION['vehicle-img-name'] = $_FILES['vehicle-img']['name'];
        }
        else 
        {
            $_SESSION['msg'] = 'Wystąpił błąd podczas przesyłania pliku.';
        }
    }
    else
    {
        $_SESSION['msg'] = 'Dopuszczalne rozszerzenia zdjęcia to jpg, jpeg, gif i png.';
    }
}
header('Location: addvehicles.php');
exit;