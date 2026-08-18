<?php
// Prevent multiple includes of connection.php
if (!isset($pdo)) {
    include 'connection.php';
}
// $settings is now available from connection.php
?>
<header class="site-header">
  <div class="container header-inner">
    <div class="logo">
      <h1><?= htmlspecialchars($settings['name'] ?? 'My Portfolio') ?></h1>
    </div>
    <nav class="nav-links" id="primary-nav">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="projects.php">Projects</a>
      <a href="contact.php">Contact</a>
      <a href="admin/dashboard.php" class="btn-admin">Admin</a>
    </nav>
    <div class="header-controls">
      <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
        <i class="fas fa-moon" id="theme-icon"></i>
      </button>
      <button class="menu-toggle" id="menu-toggle" aria-label="Toggle navigation" aria-controls="primary-nav" aria-expanded="false">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </div>
</header>
