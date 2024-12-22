<?php
require_once($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
include_once($_SERVER['DOCUMENT_ROOT']."/inc/consoleMessage.php");
session_start();

/**
 * Ustawienie pliku cookie dla motywu panelu
 * @return void
 */
function setPanelThemeCookie(): void
{
    if (isset($_POST['theme'])) {
        $theme = htmlentities($_POST['theme']);
        if ($theme == "default" || $theme == "system" || $theme == "dark" || $theme == "light")
            setcookie('theme', $theme, time() + (5 * 365 * 24 * 60 * 60));
    }
}
