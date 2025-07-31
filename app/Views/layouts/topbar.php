<div class="topbar">
    Welcome, <span class="username"><?= htmlspecialchars(session()->get('username')) ?></span>
    <a href="/logout" class="logout-btn">Logout</a>
</div>