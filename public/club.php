<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';
require_once __DIR__ . '/../includes/models/FollowModel.php';
require_once __DIR__ . '/../includes/models/ClubModel.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_profile') {
        $club_id = $_SESSION['user']['id'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $description = $_POST['description'];
    $club = $_SESSION['user']; // Assuming club info is stored in session after login
        // Handle profile image upload
        $profile_img = $club['profile_img'];
        if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "uploads/users/profile_img/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $ext = pathinfo($_FILES['profile_img']['name'], PATHINFO_EXTENSION);
            $profile_img_name = $club['id'] . "." . $ext;
            move_uploaded_file($_FILES['profile_img']['tmp_name'], $uploadDir . $profile_img_name);
            $profile_img = $uploadDir . $profile_img_name;
        }
        // Handle cover image upload
       // $cover_img = $club['cover_img'];
        if (isset($_FILES['cover_img']) && $_FILES['cover_img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "uploads/users/cover_img/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $ext = pathinfo($_FILES['cover_img']['name'], PATHINFO_EXTENSION);
            $cover_img_name = $club['id'] . "." . $ext;
            move_uploaded_file($_FILES['cover_img']['tmp_name'], $uploadDir . $cover_img_name);
            $cover_img = $uploadDir . $cover_img_name;
        }
        $clubModel = new ClubModel($connection);
        if ($clubModel->editClub($club_id, $name, $description, $category, $cover_img, $profile_img)) {
            header("Location: club.php?success=1");
            exit();
        } else {
            die("Failed to update profile.");
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSAT Pulse – <?php echo htmlspecialchars($club['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/club.css">
    <link rel="stylesheet" href="assets/css/header.css">

</head>

<body style="background: linear-gradient(135deg, #fde8e0 0%, #f9d5d3 40%, #f5c6c8 100%); min-height: 100vh;">
    <?php include __DIR__ . '/../includes/templates/header.php'; ?>
    <?php
    $club_id = $_SESSION['user']['id'] ?? null;
    $followModel=new FollowModel($connection);
    $clubModel = new ClubModel($connection);
    $club = $clubModel->findById($club_id);
    $events = $clubModel->getEvents($club_id);
    $followers=$followModel->getFollowingStudents($club_id);
    if (!$club) {
        die("Club introuvable.");
    }
    ?>
    <div class="page-body">
        <div class="row g-4">

            <div class="col-12 col-md-4 col-lg-3">
                <div class="sidebar-card">
                    <div class="club-avatar">
                        <img src="<?php echo $club['cover_img'] ?: 'https://placehold.co/110x110?text=Logo'; ?>" alt="Logo">
                    </div>

                    <div class="club-name"><?php echo htmlspecialchars($club['name']); ?></div>
                    <div class="club-handle">@<?php echo htmlspecialchars($club['username']); ?></div>

                    <div class="stats-row">
                        <div class="stat-item">
                            <div class="stat-num"><?php echo $followers->num_rows; ?></div>
                            <div class="stat-lbl">Followers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-num"><?php echo $events->num_rows; ?></div>
                            <div class="stat-lbl">Posts</div>
                        </div>
                    </div>

                    <p class="club-bio"><?php echo htmlspecialchars($club['description'] ?? 'No bio available.'); ?></p>

                    <div class="sidebar-nav">

                        <button class="nav-btn" data-panel="profile" onclick="switchPanel(this)">
                            <i class="bi bi-person"></i> Profile
                        </button>
                        <button class="nav-btn active" data-panel="myposts" onclick="switchPanel(this)">
                            <i class="bi bi-pencil-square"></i> My posts
                        </button>
                        <button class="nav-btn" data-panel="calendar" onclick="switchPanel(this)">
                            <i class="bi bi-bookmark"></i> My calendar
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-9">
                <div class="content-card">

                    <div id="panel-myposts">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 style="font-weight: 800; margin: 0; color: #1a1a1a; font-size: 1.4rem;">Club Feed</h2>
                            <div class="d-flex gap-2">
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $club_id): ?>
                                    <a href="create-event.php" class="btn-maroon" style="text-decoration: none;">
                                        <i class="bi bi-plus-lg me-1"></i> Add post
                                    </a>
                                <?php endif; ?>
                                <button class="btn-action"><i class="bi bi-bell"></i> Requests</button>
                            </div>
                        </div>

                        <div id="posts-feed">
                            <?php if ($events->num_rows > 0): ?>
                                <?php while ($e = $events->fetch_assoc()): ?>
                                    <div class="card mb-3 border-0 shadow-sm" style="border-radius:15px; overflow:hidden;">
                                        <?php if (!empty($e['image'])): ?>
                                            <img src="uploads/<?php echo $e['image']; ?>" class="card-img-top" style="max-height:300px; object-fit:cover;">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="fw-bold"><?php echo htmlspecialchars($e['title']); ?></h5>
                                            <p class="text-muted small">
                                                <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($e['place']); ?> |
                                                <i class="bi bi-clock"></i> <?php echo $e['event_date']; ?>
                                            </p>
                                            <p><?php echo htmlspecialchars($e['description']); ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="blank-panel">
                                    <i class="bi bi-megaphone text-secondary" style="font-size: 2.5rem;"></i>
                                    <span class="text-secondary mt-2">No posts published yet.</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div id="panel-calendar" class="d-none">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div style="background: #fbeaea; padding: 10px; border-radius: 12px;">
                                <i class="bi bi-calendar3" style="color: #8B0000; font-size: 1.5rem;"></i>
                            </div>
                            <h2 style="font-weight: 800; margin: 0; color: #1a1a1a; font-size: 1.4rem;">My Calendar</h2>
                        </div>
                        <div id="calendar"></div>
                    </div>

                    <div id="panel-profile" class="d-none">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div style="background: #fbeaea; padding: 10px; border-radius: 12px;">
                                <i class="bi bi-person-circle" style="color: #8B0000; font-size: 1.5rem;"></i>
                            </div>
                            <h2 style="font-weight: 800; margin: 0; color: #1a1a1a; font-size: 1.4rem;">Profile Settings</h2>
                        </div>

                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                <i class="bi bi-check-circle me-2"></i> Profile updated successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="club.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update_profile">

                            <!-- Profile Image -->
                            <div class="text-center mb-4">
                                <img
                                    src="<?php echo $club['profile_img'] ?: 'https://placehold.co/120x120?text=Profile'; ?>"
                                    alt="Profile"
                                    class="rounded-circle mb-3"
                                    style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #8F1402;">
                                <div class="mb-3">
                                    <label for="profile_img" class="form-label fw-semibold text-muted">Change Profile Image</label>
                                    <input type="file" name="profile_img" id="profile_img" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Club Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold text-muted">Club Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="<?php echo htmlspecialchars($club['name']); ?>" required>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label for="category" class="form-label fw-semibold text-muted">Category</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                        <input type="text" name="category" id="category" class="form-control"
                                            value="<?php echo htmlspecialchars($club['category'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold text-muted">Description</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <textarea name="description" id="description" class="form-control" rows="4"><?php echo htmlspecialchars($club['description'] ?? ''); ?></textarea>
                                </div>
                            </div>

                            <!-- Cover Image -->
                            <div class="mb-3">
                                <label for="cover_img" class="form-label fw-semibold text-muted">Cover Image</label>
                                <?php if (!empty($club['cover_img'])): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo $club['cover_img']; ?>" alt="Cover"
                                            class="img-fluid rounded-3" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="cover_img" id="cover_img" class="form-control" accept="image/*">
                            </div>

                            <!-- Save Button -->
                            <div class="d-grid mt-4 mb-3">
                                <button type="submit" class="btn btn-lg fw-bold"
                                    style="background-color: #8F1402; color: #fff;">
                                    <i class="bi bi-check-lg me-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let calendarRendered = false;

        function switchPanel(btn) {
            document.querySelectorAll('.sidebar-nav .nav-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            document.getElementById('panel-myposts').classList.add('d-none');
            document.getElementById('panel-calendar').classList.add('d-none');
            document.getElementById('panel-profile').classList.add('d-none');

            document.getElementById('panel-' + btn.dataset.panel).classList.remove('d-none');

            if (btn.dataset.panel === 'calendar' && !calendarRendered) {
                var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                    initialView: 'dayGridMonth',
                    displayEventTime: false,
                    events: <?php
                            $events->data_seek(0);
                            $calendarEvents = [];
                            while ($e = $events->fetch_assoc()) {
                                $calendarEvents[] = [
                                    'title' => $e['title'],
                                    'start' => $e['event_date'],
                                    'color' => '#8F1402'
                                ];
                            }
                            echo json_encode($calendarEvents);
                            ?>
                });
                calendar.render();
                calendarRendered = true;
            }
        }
    </script>
</body>

</html>