<?php
session_start();
require_once '../../includes/db.php';
require_once '../../includes/autoloader.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
}

$q = trim($_GET['q'] ?? '');
if (strlen($q) < 1) {
    echo json_encode([]);
    exit();
}

$userModel = new UserModel($connection);
$result = $userModel->searchUsers($q);
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
header('Content-Type: application/json');
echo json_encode($users);
