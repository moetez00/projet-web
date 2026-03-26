<?php
require_once realpath(__DIR__ . "/vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(realpath(__DIR__ . "/.."));
$dotenv->load();

// 1. On change ici pour correspondre à ton .env
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

// 2. On récupère les bonnes clés
$servername = $_ENV['DB_HOST'];
$dbname     = $_ENV['DB_NAME'];
$username   = $_ENV['DB_USER']; // <--- Changé
$password   = $_ENV['DB_PASS']; // <--- Changé

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) { 
    die("Connection error : " . $connection->connect_error);
}
?>