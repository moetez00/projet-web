
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
        <input type="text" id="global-search" placeholder="Search users, clubs, events…" autocomplete="off">
        <ul id="search-results" style="display:none; position:absolute; top:110%; left:0; right:0; background:#fff; border:1px solid #ddd; border-radius:8px; list-style:none; margin:0; padding:4px 0; z-index:200;"></ul>

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
<script>
const input = document.getElementById('global-search');
const results = document.getElementById('search-results');

// quand l'utilisateur tape dans la barre
input.addEventListener('input', function () {
    const q = this.value.trim();

    // si vide, cacher les résultats
    if (q === '') {
        results.style.display = 'none';
        return;
    }

    // envoyer la recherche au serveur
    fetch('actions/search-users.php?q=' + q)
        .then(function(res) { return res.json(); })
        .then(function(users) {
            results.innerHTML = '';

            if (users.length === 0) {
                results.innerHTML = '<li style="padding:8px 16px;">No users found</li>';
            } else {
                users.forEach(function(u) {
                    results.innerHTML += '<li onclick="window.location.href=\'profile.php?id=' + u.id + '\'" style="padding:8px 16px; cursor:pointer;">' + u.username + '</li>';
                });
            }

            results.style.display = 'block';
        });
});

// cacher si on clique ailleurs
document.addEventListener('click', function(e) {
    if (e.target !== input) results.style.display = 'none';
});
</script>