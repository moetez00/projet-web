<?php
/*
 * includes/templates/header.php
 * -----------------------------
 * Common header template for all pages.
 * Contains: <head> with meta tags, CSS links, and opening <body>.
 *            Also includes the navigation bar with links to Home, Clubs, Events,
 *            and conditional links for Login/Register or Profile/Logout based on auth status.
 * Required by: All public/*.php files (must be included first)
 */
include __DIR__ . '/../auth.php';
checkAuth();

?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Header CSS -->
<link href="header.css" rel="stylesheet">

<nav class="navbar navbar-pulse py-2">
  <div class="container d-flex align-items-center justify-content-between">

    <!-- Logo -->
    <a href="index.php">
  <img src="../../public/assets/images/logo.png" alt="INSAT Pulse" height="60">
</a>


    <!-- Center: Nav Icons + Search -->
    <div class="d-flex align-items-center gap-4">
      <a href="index.php" class="nav-link" title="Home">
        <i class="bi bi-house-door-fill fs-5"></i>
      </a>
      <a href="events.php" class="nav-link" title="Calender">
        <i class="bi bi-calendar-event-fill fs-5"></i>
      </a>
      <input type="text" class="search-input" placeholder="Search...">
    </div>

    <!-- Right: User Info -->
    <div class="user-section">
      <div class="text-end">
        
        <div class="user-handle"><?php echo $_SESSION['user']['username']; ?></div>
      </div>
      <?php 
      
      if ($_SESSION['user']['profile_img']){ 
        echo '

        <div class="user-avatar">
          <img src="' . $_SESSION['user']['profile_img'] . '" alt="Profile Image" class="rounded-circle" height="40" width="40">
        </div>';
      } else {
        echo '
        
        <div class="user-avatar">
          
          <i class="bi bi-person-circle fs-2"></i>
        </div>';
      }
     ?>
