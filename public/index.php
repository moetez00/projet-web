<?php
/*
 * public/index.php — Home / Feed
 * --------------------------------
 * What the user sees: a feed of recent events from all clubs,
 * a sidebar listing clubs the student follows, and a discovery section.
 * Data needed: EventModel::getRecent(), ClubModel::getAll(),
 *              FollowModel::getFollowedClubs() for logged-in student.
 * Includes: includes/auth.php, header.php, footer.php, event-card.php, club-card.php
 */

?>
<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/autoloader.php'; 
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['user']['role'] !== 'student') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSAT Pulse - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/header.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/templates/header.php'; ?>

    <?php 
    $studentId = $_SESSION['user']['id'];

    //$followModel = new FollowModel($connection);
    //$followed =  $followModel -> getFollowedClubs($studentId);

    // les posts de ces clubs en premier
    $eventModel = new EventModel($connection);
    $posts = $eventModel->getFeedPosts($studentId);
    ?>
    <div class="container mt-4">
    <?php if ($posts->num_rows > 0): ?>
        <?php while ($post = $posts->fetch_assoc()): ?>
            <div class="card mb-3">
                <?php if (!empty($post['image'])): ?>
                    <img src="uploads/<?php echo $post['image']; ?>" class="card-img-top">
                <?php endif; ?>
                <div class="card-body">
                    <h5><?php echo $post['title']; ?></h5>
                    <p><?php echo $post['description']; ?></p>
                    <small>
                        <?php echo $post['username']; ?> | 
                        <?php echo $post['club_name']; ?> | 
                        <?php echo $post['event_date']; ?>
                    </small>
                    <form action="actions/do-follow.php" method="POST">
                        <input type="hidden" name="club_id" value="<?php echo $post['club_id']; ?>">
                        <button type="submit" class="btn btn-sm mt-2" style="background-color:#8F1402; color:white;">
                            Follow
                        </button>
                    </form>

                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts yet.</p>
    <?php endif; ?>
</div>

</body>
</html>

