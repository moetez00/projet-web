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

    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->safeLoad();
    }

    $requiredVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
    foreach ($requiredVars as $var) {
        $value = $_ENV[$var] ?? getenv($var);
        if ($value === false || $value === null || $value === '') {
            die('Error: missing required environment variable ' . $var);
        }
    }

    $servername = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
    $dbport = (int)($_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: 3306);
    $dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME');
    $username = $_ENV['DB_USER'] ?? getenv('DB_USER');
    $password = $_ENV['DB_PASS'] ?? getenv('DB_PASS');


?>
