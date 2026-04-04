<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../../includes/db.php';
session_start();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $club_id=$_SESSION['user']['id'];
    $title=$_POST['title'];
    $description=$_POST['description'];
    $event_date=$_POST['event_date'];
    $place=$_POST['place'];
    $imageName = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . "." . $ext;
        // Dossier de destination
        move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/" . $imageName);
    }

    $sql="insert into event (club_id,title,description,event_date,place,image) values(?,?,?,?,?,?)";
    $stmt=$connection->prepare($sql);
    $stmt->bind_param("isssss",$club_id, $title, $description, $event_date, $place, $imageName);
    if ($stmt->execute()) {
        header("Location: ../club.php?id=$club_id&success=1");
        exit();
    } else {
        die("Erreur SQL : " . $stmt->error);
    }
}
