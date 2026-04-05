<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../../includes/db.php';
require_once '../../includes/models/ClubModel.php';
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
    $model = new ClubModel($connection);
    if ($model->addEvent($club_id, $title, $description, $event_date, $place, $imageName)) {
        header("Location: ../club.php?id=$club_id&success=1");
    } else {
        header("Location: ../club.php?id=$club_id&error=sql");
    }
    exit();
}
