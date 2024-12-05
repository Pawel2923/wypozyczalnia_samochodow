<?php
require_once($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
include_once($_SERVER['DOCUMENT_ROOT']."/inc/consoleMessage.php");
session_start(); 