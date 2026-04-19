<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "../includes/db.php";
require_once __DIR__ . '/../includes/models/FollowModel.php';
require_once __DIR__ . '/../includes/models/StudentModel.php';
require_once __DIR__ . '/../includes/models/LikeModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user']['id'];
if(!$student_id){
    header("Location:login.php");
    exit();
}
$student_model = new StudentModel($connection);
$follow_model = new FollowModel($connection);
$like_model = new LikeModel($connection);

// --- TRAITEMENT DU FORMULAIRE (POST) ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $major = $_POST['major'];

    $current_data = $student_model->findById($student_id);
    $profile_img = $current_data['profile_img'];

    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/user/profile_img/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $ext = pathinfo($_FILES['profile_img']['name'], PATHINFO_EXTENSION);
        $profile_img_name = $student_id . "." . $ext;

        if (move_uploaded_file($_FILES['profile_img']['tmp_name'], $uploadDir . $profile_img_name)) {
            $profile_img = $uploadDir . $profile_img_name;
        }
    }

    if ($student_model->editProfile($student_id, $profile_img, $name, $major, $birthday)) {
        header('Location: profile.php?success=1');
        exit();
    } else {
        die("Failed to update profile");
    }
}

// --- RÉCUPÉRATION DES DONNÉES ---
$student = $student_model->findById($student_id);

if (!$student) {
    die("Erreur : Profil étudiant introuvable.");
}

$followedClubs  = $follow_model->getFollowedClubs($student_id);
$likedEvents    = $like_model->getLikedEvents($student_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSAT Pulse – My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/club.css">
    <link rel="stylesheet" href="assets/css/header.css">
</head>

<body style="background: linear-gradient(135deg, #fde8e0 0%, #f9d5d3 40%, #f5c6c8 100%); min-height: 100vh;">
    <?php include __DIR__ . '/../includes/templates/header.php'; ?>

    <div class="page-body">
        <div class="row g-4">
            <div class="col-12 col-md-4 col-lg-3">
                <div class="sidebar-card">
                    <div class="club-avatar">
                        <img src="<?= $student['profile_img'] ?: 'https://placehold.co/110x110?text=User'; ?>" alt="Avatar">
                    </div>

                    <div class="club-name"><?= htmlspecialchars($student['fullname']); ?></div>
                    <div class="club-handle"><?= htmlspecialchars($student['email']); ?></div>

                    <div class="stats-row">
                        <div class="stat-item">
                            <div class="stat-num"><?= $followedClubs ? $followedClubs->num_rows : 0; ?></div>
                            <div class="stat-lbl">Following</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-num"><?= $likedEvents ? $likedEvents->num_rows : 0; ?></div>
                            <div class="stat-lbl">Likes</div>
                        </div>
                    </div>

                    <p class="club-bio">
                        <i class="bi bi-mortarboard"></i> <?= htmlspecialchars($student['major'] ?: 'Non spécifié'); ?><br>
                        <i class="bi bi-calendar-event"></i> <?= htmlspecialchars($student['birthday'] ?: 'Non spécifiée'); ?>
                    </p>

                    <div class="sidebar-nav">
                        <button class="nav-btn active" data-panel="profile" onclick="switchPanel(this)">
                            <i class="bi bi-person-gear"></i> My profile
                        </button>
                        <button class="nav-btn" data-panel="followed-clubs" onclick="switchPanel(this)">
                            <i class="bi bi-people"></i> Followed Clubs
                        </button>
                        <button class="nav-btn" data-panel="liked-events" onclick="switchPanel(this)">
                            <i class="bi bi-heart"></i> Liked Events
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-9">
                <div class="content-card">

                    <!-- PANEL: Paramètres -->
                    <div id="panel-profile">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div style="background: #fbeaea; padding: 10px; border-radius: 12px;">
                                <i class="bi bi-person-circle" style="color: #8B0000; font-size: 1.5rem;"></i>
                            </div>
                            <h2 style="font-weight: 800; margin: 0; color: #1a1a1a; font-size: 1.4rem;">Modifier mon profil</h2>
                        </div>

                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                <i class="bi bi-check-circle me-2"></i> profile updated !
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="profile.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update_profile">
                            <div class="text-center mb-4">
                                <img src="<?= $student['profile_img'] ?: 'https://placehold.co/120x120?text=Profile'; ?>"
                                     class="rounded-circle mb-3 shadow-sm"
                                     style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #8B0000;">
                                <div class="mb-3">
                                    <input type="file" name="profile_img" id="profile_img" class="form-control form-control-sm" accept="image/*">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['fullname']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Major</label>
                                    <input type="text" name="major" class="form-control" value="<?= htmlspecialchars($student['major'] ?? ''); ?>">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Birthday</label>
                                    <input type="date" name="birthday" class="form-control" value="<?= $student['birthday'] ? date('Y-m-d', strtotime($student['birthday'])) : ''; ?>">
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn-maroon">Save Changes</button>
                            </div>
                        </form>
                    </div>

                    <!-- PANEL: Clubs suivis -->
                    <div id="panel-followed-clubs" class="d-none">
                        <h2 style="font-weight: 800; color: #1a1a1a; font-size: 1.4rem;" class="mb-4">Clubs i'm following</h2>
                        <div class="row g-3">
                            <?php if ($followedClubs && $followedClubs->num_rows > 0): ?>
                                <?php while($c = $followedClubs->fetch_assoc()): ?>
                                    <div class="col-md-6">
                                        <div class="card p-3 border-0 shadow-sm rounded-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="<?= $c['profile_img'] ?: 'https://placehold.co/50x50'; ?>" class="rounded-circle" style="width:50px; height:50px; object-fit:cover;">
                                                <div><h6 class="mb-0 fw-bold"><?= htmlspecialchars($c['name']); ?></h6></div>
                                                <a href="club.php?id=<?= $c['user_id']; ?>" class="btn btn-sm btn-outline-danger ms-auto">Voir</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="blank-panel"><i class="bi bi-people"></i><span>No followed club</span></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- PANEL: Événements likés -->
                    <div id="panel-liked-events" class="d-none">
                        <h2 style="font-weight: 800; color: #1a1a1a; font-size: 1.4rem;" class="mb-4">Events I Liked</h2>
                        <div class="row g-3" id="liked-events-container">
                            <?php if ($likedEvents && $likedEvents->num_rows > 0): ?>
                                <?php while($ev = $likedEvents->fetch_assoc()): ?>
                                    <div class="col-md-6" id="liked-event-<?= $ev['id']; ?>">
                                        <div class="card p-3 border-0 shadow-sm rounded-4">
                                            <div class="d-flex align-items-start gap-3">
                                                <div style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow:hidden;">
                                                    <?php if ($ev['image']): ?>
                                                        <img src="<?= htmlspecialchars($ev['image']); ?>" style="width:100%;height:100%;object-fit:cover;">
                                                    <?php else: ?>
                                                        <i class="bi bi-calendar-check" style="font-size: 1.5rem; color: #8B0000;"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold"><?= htmlspecialchars($ev['title']); ?></h6>
                                                    <p class="small text-muted mb-2"><?= htmlspecialchars($ev['club_name']); ?></p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-light text-dark">
                                                            <?= date('d/m/Y', strtotime($ev['event_date'])); ?>
                                                        </span>
                                                        <form action="actions/do-like.php" method="POST" class="unlike-form" data-id="<?= $ev['id']; ?>">
                                                            <input type="hidden" name="event_id" value="<?= $ev['id']; ?>">
                                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                                                <i class="bi bi-heart-fill"></i> Unlike
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="blank-panel" id="no-liked-msg">
                                    <i class="bi bi-heart"></i>
                                    <span>No Liked Events</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchPanel(btn) {
            document.querySelectorAll('.sidebar-nav .nav-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            document.getElementById('panel-profile').classList.add('d-none');
            document.getElementById('panel-followed-clubs').classList.add('d-none');
            document.getElementById('panel-liked-events').classList.add('d-none');

            const panelId = 'panel-' + btn.dataset.panel;
            document.getElementById(panelId).classList.remove('d-none');
        }
    </script>
</body>
</html>