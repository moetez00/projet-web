<?php
session_start();
// Vérifie si le club est connecté
#if (!isset($_SESSION['club_id'])) {
    #header("Location: login.php"); 
    #exit(); // On arrête l'exécution du script ici
#}
require_once "connection.php"; 

// On utilise l'ID de session, ou 1 (AeRobotix) pour tes tests
$club_id = $_SESSION['club_id'] ?? 1; 
$query = "SELECT * FROM EVENT WHERE id_Club = $club_id ORDER BY id DESC";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>INSAT Pulse – AeRobotix INSAT</title>

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
              <div class="stat-num"><?php echo $result ? $result->num_rows : 0; ?></div>
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
            </div>

            <div id="posts-feed" class="mt-4">
              <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                  
                  <div class="post-item mb-4 p-3 border rounded shadow-sm bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-danger">Event</span>
                      <small class="text-muted">From: <?php echo $row['startDate']; ?></small>
                    </div>
                    
                    <h5 class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="text-secondary"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>

                    <?php if (!empty($row['imageURL'])): ?>
                      <div class="post-img-container mb-3">
                        <img src="../uploads/<?php echo htmlspecialchars($row['imageURL']); ?>" class="img-fluid rounded" alt="Post image" style="max-height: 400px; width: 100%; object-fit: cover;">
                      </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center border-top pt-2">
                      <span class="small text-muted"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['loc']); ?></span>
                      <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-heart"></i> Like
                      </button>
                    </div>
                  </div>

                <?php endwhile; ?>
              <?php else: ?>
                <p class="text-center text-muted py-5">Aucun événement publié pour le moment.</p>
              <?php endif; ?>
            </div>
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
              <div class="col-12">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required />
              </div>
              <div class="col-12 col-sm-6">
                <label class="form-label">Location (loc)</label>
                <input type="text" class="form-control" name="loc" />
              </div>
              <div class="col-12 col-sm-3">
                <label class="form-label">Start Date</label>
                <input type="date" class="form-control" name="startDate" />
              </div>
              <div class="col-12 col-sm-3">
                <label class="form-label">End Date</label>
                <input type="date" class="form-control" name="endDate" />
              </div>
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4"></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Photo (imageURL)</label>
                <input type="file" class="form-control" name="photo" accept="image/*" />
              </div>
              <div class="col-12 d-flex justify-content-end gap-3 mt-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Post</button>
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
        document.getElementById('panel-' + id)?.classList.add('d-none');
      });
      document.getElementById('panel-' + btn.dataset.panel)?.classList.remove('d-none');
    }
  </script>
</body>
</html>


