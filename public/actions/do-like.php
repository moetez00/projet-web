<?php
/*
 * public/actions/do-like.php — Like/Unlike Action (POST handler)
 * ----------------------------------------------------------------
 * Processes: POST event_id; toggles like state for session student
 * Uses: LikeModel::hasLiked(), ::like(), ::unlike()
 * Returns: JSON { liked: bool, count: int } for fetch() in like.js
 * Requires login with role='student'
 */

session_start();
require_once '../../includes/db.php';
require_once '../../includes/autoloader.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header('Location: ../login.php');
    exit();
}

$studentId = $_SESSION['user']['id'];
$eventId = $_POST['event_id'];

$likeModel = new LikeModel($connection);
if ($likeModel->hasLiked($studentId, $eventId)) {
    $likeModel->unlike($studentId, $eventId);
} else {
    $likeModel->like($studentId, $eventId);
}

// Dans do-like.php, remplace le header par :
if(isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ../index.php');
}
exit();