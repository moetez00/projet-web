<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';
require_once __DIR__ . '/../includes/models/ClubModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$club_id = $_GET['id'] ?? 1;
$clubModel = new ClubModel($connection);
$club = $clubModel->findById($club_id);
$events = $clubModel->getEvents($club_id);

if (!$club) {
    die("Club introuvable.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSAT Pulse – <?php echo htmlspecialchars($club['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/club.css">
</head>
<body style="background: linear-gradient(135deg, #fde8e0 0%, #f9d5d3 40%, #f5c6c8 100%); min-height: 100vh;">

    <nav class="insat-navbar">
        <a class="brand-logo" href="index.php" style="text-decoration: none;">
            <i class="bi bi-activity pulse-icon"></i>
            <span class="brand-text">INSAT<span>-PULSE</span></span>
        </a>
        
        <div class="user-badge ms-auto">
            <div class="user-info">
                <div class="name"><?php echo htmlspecialchars($club['name']); ?></div>
            </div>
            <div class="avatar-circle">
                <img src="<?php echo $club['profile_img'] ?: 'https://placehold.co/42x42/f0e0e0/8B0000?text=CB'; ?>" alt="avatar" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </nav>

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
                            <div class="stat-num">11K</div>
                            <div class="stat-lbl">Followers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-num"><?php echo $events->num_rows; ?></div>
                            <div class="stat-lbl">Posts</div>
                        </div>
                    </div>

                    <p class="club-bio"><?php echo htmlspecialchars($club['description'] ?? 'No bio available.'); ?></p>

                    <div class="sidebar-nav">
                        <button class="nav-btn" data-panel="calendar" onclick="switchPanel(this)">
                            <i class="bi bi-bookmark"></i> My calendar
                        </button>
                        <button class="nav-btn" data-panel="profile" onclick="switchPanel(this)">
                            <i class="bi bi-person"></i> Profile
                        </button>
                        <button class="nav-btn active" data-panel="myposts" onclick="switchPanel(this)">
                            <i class="bi bi-pencil-square"></i> My posts
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
                                <?php while($e = $events->fetch_assoc()): ?>
                                    <div class="card mb-3 border-0 shadow-sm" style="border-radius:15px; overflow:hidden;">
                                        <?php if(!empty($e['image'])): ?>
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
                        <div class="blank-panel">
                            <span class="text-secondary">Coming soon...</span>
                        </div>
                    </div>

                    <div id="panel-profile" class="d-none">
                        <div class="d-flex align-items-center gap-3 mb-4">
                             <div style="background: #fbeaea; padding: 10px; border-radius: 12px;">
                                <i class="bi bi-person-circle" style="color: #8B0000; font-size: 1.5rem;"></i>
                             </div>
                             <h2 style="font-weight: 800; margin: 0; color: #1a1a1a; font-size: 1.4rem;">Profile Settings</h2>
                        </div>
                        <div class="blank-panel">
                            <span class="text-secondary">Coming soon...</span>
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
            
            document.getElementById('panel-myposts').classList.add('d-none');
            document.getElementById('panel-calendar').classList.add('d-none');
            document.getElementById('panel-profile').classList.add('d-none');
            
            document.getElementById('panel-' + btn.dataset.panel).classList.remove('d-none');
        }
    </script>
</body>
</html>