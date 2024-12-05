<?php
require_once("../initial.php");
$allowedExt = array("jpg", "jpeg", "gif", "png", "webp", "avif", "bmp", "xbm");

$dir = '../img/cars/';
$target = $dir . basename($_FILES['vehicle-img']['name']);
$newFilename = htmlentities($_POST['vehicle-img-name']);
$newFilename = explode('.', $newFilename);
$newFilename = $newFilename[0];

$ext = explode('.', strtolower($_FILES['vehicle-img']['name']));    // Rozszerzenie pliku
if (empty($newFilename)) {
    $targetWebp = str_replace("." . end($ext), ".webp", $target);
    $targetWebp = $dir . basename($targetWebp);
} else {
    $targetWebp = $dir . $newFilename . '.webp';
}

if (!file_exists($targetWebp)) { // Sprawdzenie czy plik istnieje
    if ($_FILES['vehicle-img']['size'] > (1048576 * 10)) // Sprawdzenie rozmiaru pliku
        $_SESSION['error'] = 'Plik nie może być większy niż 10 MB.';
    else {
        if (in_array(end($ext), $allowedExt)) { // Sprawdzenie czy rozszerzenie jest obsługiwane
            $img = NULL;  // Konwersja na webp
            switch ($ext) {
                case "jpeg":
                case "jpg":
                    $img = imagecreatefromjpeg($target);
                    imagewebp($img);
                    imagedestroy($img);
                    break;
                case "gif":
                    $img = imagecreatefromgif($target);
                    imagewebp($img);
                    imagedestroy($img);
                    break;
                case "png":
                    $img = imagecreatefrompng($target);
                    imagewebp($img);
                    imagedestroy($img);
                    break;
                case "webp":
                    $img = imagecreatefromwebp($target);
                    imagewebp($img);
                    imagedestroy($img);
                    break;
                case "avif":
                    $img = imagecreatefromavif($target);
                    imagewebp($img);
                    imagedestroy($img);
                    break;
                case "bmp":
                    $img = imagecreatefrombmp($target);
                    imagewebp($img);
                    imagedestroy($img);
                    break;
                case "xbm":
                    $img = imagecreatefromxbm($target);
                    imagewebp($img);
                    imagedestroy($img);
                    break;
                default:
                    unset($img);
            }

            if (move_uploaded_file($_FILES['vehicle-img']['tmp_name'], $targetWebp)) {
                $_SESSION['msg'] = 'Plik został pomyślnie przesłany.';

                $_SESSION['vehicle-img-name'] = $targetWebp;
            } else
                $_SESSION['error'] = 'Wystąpił błąd podczas przesyłania pliku.';
        } else
            $_SESSION['error'] = 'Plik musi być zdjęciem';
    }
} else {
    $_SESSION['msg'] = 'Ten plik już istnieje. Wybrano istniejący plik.';
    $_SESSION['vehicle-img-name'] = $targetWebp;
}

header('Location: addvehicles.php');
exit;
