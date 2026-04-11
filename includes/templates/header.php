
<?php
include __DIR__ . '/../auth.php';
checkAuth();
$sessionUser = $_SESSION['user'];
?>

<nav class="navbar-home">

    <div class="navbar-logo">
        <img src="assets/images/logo.png" alt="INSAT PULSE">
    </div>

    <div class="nav-icons">
        <button class="nav-icon-btn active" title="Home">
            <img src="assets/images/icon-home.png" alt="Home">
        </button>
        <button class="nav-icon-btn" title="Calendar">
            <img src="assets/images/icon-calender.png" alt="Calendar">
        </button>
    </div>

    <div class="navbar-search">
        <svg class="search-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" placeholder="Search clubs, events…">
>>>>>>> da1d6e1bc283607896ed09ef3fb3fbe1f7cd166f
    </div>

    <div class="user-section">
        <div class="user-handle"><?php echo $sessionUser['username']; ?></div>
        <div class="user-avatar">
            <?php if (!empty($sessionUser['profile_img'])): ?>
                <img src="<?php echo $sessionUser['profile_img']; ?>" alt="Profile">
            <?php else: ?>
                <i class="bi bi-person-circle"></i>
            <?php endif; ?>
        </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

