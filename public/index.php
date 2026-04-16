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
<body style="background: linear-gradient(135deg, #fde8e0 0%, #f9d5d3 40%, #f5c6c8 100%); min-height: 100vh;">

    <?php include __DIR__ . '/../includes/templates/header.php'; ?>

    <?php 
    $studentId = $_SESSION['user']['id'];

    $followModel = new FollowModel($connection);
    //$followed =  $followModel -> getFollowedClubs($studentId);

    // les posts de ces clubs en premier
    $eventModel = new EventModel($connection);
    $likeModel = new LikeModel($connection); 
    $posts = $eventModel->getFeedPosts($studentId);
    ?>
    <div class="container mt-4">
        <div class="row">
            <!-- COLONNE GAUCHE -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header" style="background-color:#8F1402; color:white;">
                        <h5 class="mb-0">Upcoming Schedule</h5>
                    </div>
                    <div class="card-body">
                        <?php $liked = $likeModel->getLikedEvents($studentId); ?>
                        <?php if ($liked->num_rows > 0): ?>
                            <?php while ($ev = $liked->fetch_assoc()): ?>
                                <div class="mb-2">
                                    <strong><?php echo $ev['title']; ?></strong><br>
                                    <small><?php echo date('d/m/Y', strtotime($ev['event_date'])); ?></small>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted">No liked events yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE = les posts -->
            <div class="col-md-9">
                <?php if ($posts->num_rows > 0): ?>
                    <?php while ($post = $posts->fetch_assoc()): ?>
                        <?php $isFollowing = $followModel->isFollowing($studentId, $post['club_id']); ?>
                        <div class="card mb-3">

                            <?php if (!empty($post['image'])): ?>
                                <img src="uploads/<?php echo $post['image']; ?>" class="card-img-top">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5><?php echo $post['title']; ?></h5>
                                <p><?php echo $post['description']; ?></p>
                                <small>
                                    <?php echo $post['username']; ?> |
                                    <span style="color:#8F1402;"><?php echo $post['club_name']; ?></span> |
                                    <?php echo $post['event_date']; ?>
                                </small>
                                <div class="d-flex gap-2">
                                    <form action="actions/do-follow.php" method="POST">
                                        <input type="hidden" name="club_id" value="<?php echo $post['club_id']; ?>">
                                        <button type="submit" class="btn btn-sm mt-2" style="background-color:#8F1402; color:white;">
                                            <?php echo $isFollowing ? 'Unfollow' : 'Follow'; ?>
                                        </button>
                                    </form>
                                    <form action="actions/do-like.php" method="POST">
                                        <input type="hidden" name="event_id" value="<?php echo $post['id']; ?>">
                                        <button type="submit" class="btn btn-sm mt-2" style="background-color:#8F1402; color:white;">
                                            <?php echo $likeModel->hasLiked($studentId, $post['id']) ? '❤️ Unlike' : '🤍 Like'; ?>
                                        </button>
                                    </form>
                                    <!-- hnaaa abd bech yamel l like w tetzed lel scedule! -->
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No posts yet.</p>
                <?php endif; ?>
            </div> <!-- fin col-md-8 -->
        </div> 
    </div>

</body>
</html>