<?php
/*
 * public/actions/do-follow.php — Follow/Unfollow Action (POST handler)
 * -----------------------------------------------------------------------
 * Processes: POST club_id; toggles follow state for session student
 * Uses: FollowModel::isFollowing(), ::follow(), ::unfollow()
 * Returns: JSON { following: bool, count: int } for fetch() in follow.js
 * Requires login with role='student'
 */?>
<?php
session_start();
require_once '../../includes/db.php';
require_once '../../includes/autoloader.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header('Location: ../login.php');
    exit();
}

$studentId = $_SESSION['user']['id'];
$clubId = $_POST['club_id'];

$followModel = new FollowModel($connection);
$followModel->follow($studentId, $clubId);

header('Location: ../index.php');
exit();
?>