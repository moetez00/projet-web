<?php
session_start();
require_once "connection.php";

// 1. Sécurité : On vérifie que les données viennent bien d'un formulaire POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // (Session ou 1 pour test)
    $club_id = $_SESSION['club_id'] ?? 1;
    
    $title = $_POST['title'] ?? 'Untitled Event';
    $loc = $_POST['loc'] ?? '';
    $startDate = $_POST['startDate'] ?? null;
    $endDate = $_POST['endDate'] ?? null;
    $description = $_POST['description'] ?? '';
    
    $imageURL = "";

    // 2. Gestion de l'Upload de l'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "../uploads/";
        
        // On crée un nom unique pour éviter d'écraser des images qui ont le même nom
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $new_file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $new_file_name;

        // On déplace le fichier du dossier temporaire vers /uploads
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $imageURL = $new_file_name;
        }
    }

    // 3. Insertion SÉCURISÉE en base de données (Prepared Statement)
    $sql = "INSERT INTO EVENT (title, description, startDate, endDate, imageURL, loc, id_Club) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $connection->prepare($sql);
    
    // "ssssssi" veut dire : 6 strings (s) et 1 integer (i) pour l'ID du club
    $stmt->bind_param("ssssssi", $title, $description, $startDate, $endDate, $imageURL, $loc, $club_id);

    if ($stmt->execute()) {
        // Succès ! On redirige vers la page de profil pour voir le nouveau post
        header("Location: publish_event.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$connection->close();
?>