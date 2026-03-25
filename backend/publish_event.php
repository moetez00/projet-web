
<?php
// On inclut la connexion au début pour vérifier que tout fonctionne
require_once "connection.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>INSAT Pulse – AeRobotix INSAT</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="../frontend/club-profile/style.css" />
</head>
<body>

  <!-- ══════════ NAVBAR ══════════ -->
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

  <!-- ══════════ PAGE BODY ══════════ -->
  <div class="page-body">
    <div class="row g-4">

      <!-- ── Left Sidebar ── -->
      <div class="col-12 col-md-4 col-lg-3">
        <div class="sidebar-card">

          <!-- Club avatar -->
          <div class="club-avatar">
            <img src="https://placehold.co/110x110/fce8e8/8B0000?text=AeRobotix" alt="AeRobotix INSAT logo" />
          </div>

          <div class="club-name">AeRobotix INSAT</div>
          <div class="club-handle">aerobotix</div>

          <!-- Stats -->
          <div class="stats-row">
            <div class="stat-item">
              <div class="stat-num">11K</div>
              <div class="stat-lbl">Followers</div>
            </div>
            <div class="stat-item">
              <div class="stat-num">50</div>
              <div class="stat-lbl">Posts</div>
            </div>
          </div>

          <!-- Bio -->
          <p class="club-bio">The common ground for Robotics &amp; Aeronautics.</p>

          <!-- Nav buttons -->
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

      <!-- ── Right Content ── -->
      <div class="col-12 col-md-8 col-lg-9">
        <div class="content-card">

          <!-- My Posts feed panel -->
          <div id="panel-myposts">

            <!-- Top action buttons -->
            <div class="posts-actions">
              <button class="btn-action" data-bs-toggle="modal" data-bs-target="#addPostModal">
                <i class="bi bi-plus"></i> Add post
              </button>
              <button class="btn-action" type="button">
                <i class="bi bi-bell"></i> Collaboration requests
              </button>
            </div>

            <!-- Posts feed (empty) -->
            <div id="posts-feed"></div>

          </div>

          <!-- Calendar blank panel -->
          <div id="panel-calendar" class="d-none blank-panel">
            <i class="bi bi-calendar3 text-secondary"></i>
            <span class="text-secondary">My Calendar — coming soon</span>
          </div>

          <!-- Profile blank panel -->
          <div id="panel-profile" class="d-none blank-panel">
            <i class="bi bi-person-circle text-secondary"></i>
            <span class="text-secondary">Profile — coming soon</span>
          </div>

        </div>
      </div>

    </div>
  </div>

  <!-- ══════════ ADD POST MODAL ══════════ -->
  <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" style="border-radius:18px; border:none;">
        <div class="modal-header" style="border-bottom:1px solid #f0f0f0; padding:1.2rem 1.6rem;">
          <h5 class="modal-title" id="addPostModalLabel" style="font-weight:700; font-size:1rem;">New Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding:1.6rem;">
          <form id="addPostForm" action="create_event.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3">

              <!-- Category -->
              <div class="col-12 col-sm-6">
                <label class="form-label"><i class="bi bi-flag"></i> Category</label>
                <select class="form-select" name="category">
                  <option selected>Event</option>
                  <option>Workshop</option>
                  <option>Competition</option>
                  <option>Announcement</option>
                  <option>Other</option>
                </select>
              </div>

              <!-- Content -->
              <div class="col-12 col-sm-6">
                <label class="form-label"><i class="bi bi-pencil"></i> Content</label>
                <input type="text" class="form-control" name="content" />
              </div>

              <!-- Place -->
              <div class="col-12 col-sm-6">
                <label class="form-label"><i class="bi bi-geo-alt"></i> Place</label>
                <input type="text" class="form-control" name="place" />
              </div>

              <!-- Date -->
              <div class="col-12 col-sm-6">
                <label class="form-label"><i class="bi bi-clock"></i> Date</label>
                <input type="date" class="form-control" name="date" />
              </div>

              <!-- Caption -->
              <div class="col-12">
                <label class="form-label">Caption</label>
                <textarea class="form-control" name="caption" rows="4"></textarea>
              </div>

              <!-- Photo -->
              <div class="col-12 col-sm-6">
                <label class="form-label">Photo</label>
                <label class="photo-upload-label" for="photoInput">
                  <i class="bi bi-camera"></i>
                  <span>Add/ preview photo</span>
                </label>
                <input type="file" id="photoInput" name="photo" accept="image/*" />
              </div>

              <!-- In collaboration with -->
              <div class="col-12 col-sm-6">
                <label class="form-label">In collaboration with</label>
                <select class="form-select" name="collaboration">
                  <option selected>None</option>
                  <option>IEEE INSAT</option>
                  <option>GDSC INSAT</option>
                  <option>Enactus INSAT</option>
                  <option>Other</option>
                </select>
              </div>

              <!-- Action buttons -->
              <div class="col-12 d-flex justify-content-end gap-3 mt-2">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal"
                  onclick="document.getElementById('addPostForm').reset()">Cancel</button>
                <button type="submit" class="btn-maroon">Post</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function switchPanel(btn) {
      document.querySelectorAll('.sidebar-nav .nav-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      ['myposts', 'calendar', 'profile'].forEach(id => {
        document.getElementById('panel-' + id).classList.add('d-none');
      });

      document.getElementById('panel-' + btn.dataset.panel).classList.remove('d-none');
    }
  </script>

</body>
</html>
