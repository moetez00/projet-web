<?php
// On charge l'autoloader de Composer (le dossier que tu viens de créer)
require_once __DIR__ . '/../vendor/autoload.php';

// On utilise Dotenv pour lire ton fichier .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// On récupère les accès depuis le fichier .env
$host = $_ENV['DB_HOST'];
$db   = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

try {
    // Connexion PDO standard
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Si tu veux vérifier que ça marche, tu peux décommenter la ligne suivante :
    // echo "Connexion réussie avec la méthode Dotenv !";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}