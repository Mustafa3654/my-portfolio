<?php
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/../connection.php';

// Get counts
$projects_count = $pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn();
$skills_count = $pdo->query('SELECT COUNT(*) FROM skills')->fetchColumn();
$services_count = $pdo->query('SELECT COUNT(*) FROM services')->fetchColumn();

// Try to get messages count if table exists
$messages_count = 0;
try {
    $messages_count = $pdo->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
} catch (PDOException $e) {
    // Table might not exist
}

$settings = $pdo->query('SELECT name, title, profile_img FROM settings WHERE id = 1')->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/admin.css">
  <script src="assets/js/admin-nav.js" defer></script>
</head>
<body>
  <div class="container">
    <div class="admin-header">
      <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
      <div style="display: flex; gap: 1rem; align-items: center;">
        <button class="theme-toggle" onclick="toggleAdminTheme()" aria-label="Toggle theme">
            <i class="fas fa-moon" id="theme-icon"></i>
        </button>
        <a href="logout.php" class="btn-back" style="border-color: #ef4444; color: #ef4444;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </div>
    
    <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; padding: 1.5rem; background: var(--input-bg); border-radius: 12px;">
      <?php if (!empty($settings['profile_img'])): ?>
        <img src="../<?= htmlspecialchars($settings['profile_img']) ?>" alt="Profile" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent);">
      <?php else: ?>
        <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
          <i class="fas fa-user"></i>
        </div>
      <?php endif; ?>
      <div>
        <h2 style="margin-bottom: 0.25rem;">Welcome, <?= htmlspecialchars($_SESSION['admin_user']) ?>!</h2>
        <p style="color: var(--muted); margin: 0;">
          <strong><?= htmlspecialchars($settings['name'] ?? 'No Name Set') ?></strong><br>
          <?= htmlspecialchars($settings['title'] ?? 'No Title Set') ?>
        </p>
      </div>
    </div>

    <div class="stats">
      <div class="stats-card">
        <i class="fas fa-project-diagram"></i>
        <h3><?= $projects_count ?></h3>
        <p>Projects</p>
      </div>
      <div class="stats-card">
        <i class="fas fa-code"></i>
        <h3><?= $skills_count ?></h3>
        <p>Skills</p>
      </div>
      <div class="stats-card">
        <i class="fas fa-concierge-bell"></i>
        <h3><?= $services_count ?></h3>
        <p>Services</p>
      </div>
      <?php if ($messages_count > 0): ?>
      <div class="stats-card" style="border-color: var(--warning);">
        <i class="fas fa-envelope" style="color: var(--warning);"></i>
        <h3><?= $messages_count ?></h3>
        <p>New Messages</p>
      </div>
      <?php endif; ?>
    </div>

    <h3 style="margin-top: 2rem; margin-bottom: 1rem;"><i class="fas fa-cog"></i> Quick Actions</h3>
    
    <div class="dashboard-grid">
      <a href="settings.php" class="dashboard-card">
        <i class="fas fa-user-edit"></i>
        <h3>Edit Profile</h3>
        <p>Update your personal information</p>
      </a>
      <a href="projects.php" class="dashboard-card">
        <i class="fas fa-folder-open"></i>
        <h3>Manage Projects</h3>
        <p>Add, edit, or remove projects</p>
      </a>
      <a href="add_project.php" class="dashboard-card">
        <i class="fas fa-plus-circle"></i>
        <h3>Add New Project</h3>
        <p>Create a new project entry</p>
      </a>
      <a href="../index.php" class="dashboard-card" target="_blank">
        <i class="fas fa-external-link-alt"></i>
        <h3>View Website</h3>
        <p>See your portfolio live</p>
      </a>
    </div>
  </div>
  <script src="JS/admin-theme.js"></script>
</body>
</html>