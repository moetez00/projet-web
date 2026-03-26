<?php
session_start();
#if (!isset($_SESSION['club_id'])) {
    #header("Location: login.php"); 
    #exit(); // On arrête l'exécution du script ici
#}
require_once "connection.php"; 

// 1. On récupère l'ID (depuis la session ou 1 par défaut)
$club_id = $_SESSION['club_id'] ?? 1; 

// 2. PROTECTION ANTI-INJECTION : Requête préparée pour le COUNT
$sql_count = "SELECT COUNT(*) as total FROM EVENT WHERE id_Club = ?";
$stmt_count = $connection->prepare($sql_count);
$stmt_count->bind_param("i", $club_id);
$stmt_count->execute();
$res_count = $stmt_count->get_result();
$row_count = $res_count->fetch_assoc();
$post_count = $row_count['total'];

$stmt_count->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>INSAT Pulse – Publish Event</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../frontend/club-profile/style.css" />
</head>
<body>

  <nav class="insat-navbar">
    <a class="brand-logo" href="#">
      <i class="bi bi-activity pulse-icon"></i>
      <span class="brand-text">INSAT<span>-PULSE</span></span>
    </a>
    <div class="nav-icons ms-3">
      <a href="#" title="Home"><i class="bi bi-house-door"></i></a>
      <a href="#" title="Calendar"><i class="bi bi-calendar3"></i></a>
    </div>
    <div class="search-wrap ms-3">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Search…" />
    </div>
    <div class="user-badge">
      <div class="user-info">
        <div class="name">AeRobotix INSAT</div>
        <div class="handle">aerobotix</div>
      </div>
      <div class="avatar-circle">
        <img src="https://placehold.co/42x42/f0e0e0/8B0000?text=AR" alt="AeRobotix avatar" />
      </div>
    </div>
  </nav>

  <div class="page-body">
    <div class="row g-4">

      <div class="col-12 col-md-4 col-lg-3">
        <div class="sidebar-card">
          <div class="club-avatar">
            <img src="https://placehold.co/110x110/fce8e8/8B0000?text=AeRobotix" alt="AeRobotix INSAT logo" />
          </div>
          <div class="club-name">AeRobotix INSAT</div>
          <div class="club-handle">aerobotix</div>

          <div class="stats-row">
            <div class="stat-item">
              <div class="stat-num">11K</div>
              <div class="stat-lbl">Followers</div>
            </div>
            <div class="stat-item">
              <div class="stat-num"><?php echo (int)$post_count; ?></div>
              <div class="stat-lbl">Posts</div>
            </div>
          </div>

          <p class="club-bio">The common ground for Robotics &amp; Aeronautics.</p>

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
            <div class="posts-actions">
              <button class="btn-action" data-bs-toggle="modal" data-bs-target="#addPostModal">
                <i class="bi bi-plus"></i> Add post
              </button>
              <button class="btn-action" type="button">
                <i class="bi bi-bell"></i> Collaboration requests
              </button>
            </div>

            <div id="posts-feed" class="mt-4">
              <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success d-flex align-items-center mb-4" role="alert" style="border-radius: 12px; background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
                  <i class="bi bi-check-circle-fill me-2"></i>
                  <div>Your event has been successfully published!</div>
                </div>
              <?php endif; ?>

              <div class="text-center py-5 border rounded bg-light" style="border-style: dashed !important; border-width: 2px;">
                <i class="bi bi-megaphone fs-1 text-secondary"></i>
                <h4 class="mt-3 text-dark">Management Dashboard</h4>
                <p class="text-secondary">Click the <b>"Add post"</b> button to create a new event.</p>
              </div>
            </div>
          </div>

          <div id="panel-calendar" class="d-none blank-panel text-center py-5">
            <i class="bi bi-calendar3 text-secondary d-block fs-1 mb-2"></i>
            <span class="text-secondary">My Calendar — coming soon</span>
          </div>

          <div id="panel-profile" class="d-none blank-panel text-center py-5">
            <i class="bi bi-person-circle text-secondary d-block fs-1 mb-2"></i>
            <span class="text-secondary">Profile — coming soon</span>
          </div>

        </div>
      </div>

    </div>
  </div>

  <div class="modal fade" id="addPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" style="border-radius:18px;">
        <div class="modal-header">
          <h5 class="modal-title">New Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="create_event.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
              <div class="col-12"><label class="form-label">Title</label><input type="text" class="form-control" name="title" required /></div>
              <div class="col-12 col-sm-6"><label class="form-label">Place</label><input type="text" class="form-control" name="loc" /></div>
              <div class="col-12 col-sm-3"><label class="form-label">Start Date</label><input type="date" class="form-control" name="startDate" /></div>
              <div class="col-12 col-sm-3"><label class="form-label">End Date</label><input type="date" class="form-control" name="endDate" /></div>
              <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="4"></textarea></div>
              <div class="col-12"><label class="form-label">Photo</label><input type="file" class="form-control" name="photo" accept="image/*" /></div>
              <div class="col-12 d-flex justify-content-end gap-3 mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-maroon" style="background-color: #8B0000; color: white; border:none; padding: 8px 20px; border-radius: 8px;">Post</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function switchPanel(btn) {
      document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      ['myposts', 'calendar', 'profile'].forEach(id => {
        document.getElementById('panel-' + id).classList.add('d-none');
      });
      document.getElementById('panel-' + btn.dataset.panel).classList.remove('d-none');
    }
  </script>
</body>
</html>

