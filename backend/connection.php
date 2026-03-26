<?php

require_once realpath(__DIR__ . "/vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USERNAME', 'DB_PASSWORD']);

$servername =$_ENV['DB_HOST'];
$dbname=$_ENV['DB_NAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

$connection = new mysqli($servername, $username,$password,$dbname);
if ($connection->connect_error) { die("connection error : " . $connection->connect_error);}
?>

