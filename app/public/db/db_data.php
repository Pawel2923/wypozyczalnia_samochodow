<?php 
$db_host = '192.168.176.1';
$db_user = 'dbuser';
$db_password = 'klDiuG81bvxc';
$db_name = 'wypozyczalnia';

$dsn = "mysql:host=".$db_host.";dbname=".$db_name.";";
$options = [
    PDO::ATTR_EMULATE_PREPARES => false
];