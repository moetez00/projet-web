<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - INSAT Pulse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/club.css">
</head>
<body>

    <nav class="insat-navbar">
        <a class="brand-logo" href="club.php?id=<?= $_SESSION['user']['id'] ?>">
            <i class="bi bi-activity pulse-icon"></i>
            <span class="brand-text">INSAT<span>-PULSE</span></span>
        </a>
        <div class="user-badge ms-auto">
            <div class="user-info">
                <div class="name"><?= htmlspecialchars($_SESSION['user']['username']) ?></div>
            </div>
            <div class="avatar-circle">
                <img src="https://placehold.co/42x42/f0e0e0/8B0000?text=CB" alt="avatar">
            </div>
        </div>
    </nav>

    <div class="page-body">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                
                <div class="content-card">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="background: #fbeaea; padding: 10px; border-radius: 12px;">
                            <i class="bi bi-megaphone-fill" style="color: #8B0000; font-size: 1.5rem;"></i>
                        </div>
                        <h2 style="font-weight: 800; margin: 0; color: #1a1a1a; font-size: 1.4rem;">Publish New Event</h2>
                    </div>

                    <form action="actions/do-create-event.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label"><i class="bi bi-type"></i> Event Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter a catchy title" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-geo-alt"></i> Location</label>
                                <input type="text" name="place" class="form-control" placeholder="Where is it?" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-calendar-check"></i> Event Date</label>
                                <input type="date" name="event_date" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><i class="bi bi-justify-left"></i> Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Tell the students what to expect..."></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><i class="bi bi-image"></i> Event Poster</label>
                                <label class="photo-upload-label" for="photoInput" style="height: 120px; flex-direction: column; justify-content: center;">
                                    <i class="bi bi-cloud-arrow-up" style="font-size: 2rem;"></i>
                                    <span>Click to upload your image</span>
                                </label>
                                <input type="file" id="photoInput" name="image" accept="image/*" style="display: none;">
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-3 pt-3">
                                <a href="club.php?id=<?= $_SESSION['user']['id'] ?>" class="btn-cancel" style="text-decoration: none;">
                                    Cancel
                                </a>
                                <button type="submit" class="btn-maroon">
                                    <i class="bi bi-send-fill me-2"></i>Publish Post
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>