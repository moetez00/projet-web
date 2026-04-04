<?php
/*
 * includes/config.php
 * -------------------
 * App boot file — the first include in every entry point.
 * 1. Loads vendor/autoload.php (Composer, gives access to phpdotenv).
 * 2. Uses Dotenv\Dotenv to parse .env from the project root into $_ENV.
 * Required by: includes/db.php (must be included first)
 */

require_once __DIR__ . '/../vendor/autoload.php';
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/..');
        $dotenv->load();
    } 
    catch (Exception $e) {die('Error: .env file not found in the project root.');
    }
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);
    
    $servername =$_ENV['DB_HOST'];
    $dbname=$_ENV['DB_NAME'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];


?>
