<?php
include 'connection.php';
// $settings is now available from connection.php

$stmt = $pdo->query("SELECT * FROM projects ORDER BY start_date DESC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Projects by <?= htmlspecialchars($settings['name'] ?? 'Portfolio') ?> - View my web development and software projects">
  <title>Projects | <?= htmlspecialchars($settings['name'] ?? 'Portfolio') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/main.js"></script>
</head>
<body>
  <?php include 'header.php'; ?>
  <main class="projects-section">
    <div class="container">
      <h2 class="section-title">My Projects</h2>
      <p>Here are some of the projects I've worked on. Each project represents my dedication to creating functional and user-friendly solutions.</p>
      
      <?php if (empty($projects)): ?>
        <p style="text-align: center; color: var(--text-secondary); padding: 3rem 0;">No projects found. Check back soon!</p>
      <?php else: ?>
        <div class="projects-grid">
          <?php foreach ($projects as $p): ?>
            <div class="project-card">
              <img src="<?= htmlspecialchars($p['image']) ?: 'assets/images/default.jpg' ?>" alt="<?= htmlspecialchars($p['title']) ?>">
              <div class="project-content">
                <h3><?= htmlspecialchars($p['title']) ?></h3>
                <p><?= htmlspecialchars($p['description']) ?></p>
                <p class="tech-stack"><i class="fas fa-code"></i> <?= htmlspecialchars($p['tech_stack']) ?></p>
                <p class="duration">
                  <i class="fas fa-calendar-alt"></i> 
                  <?= htmlspecialchars($p['start_date']) ?> - 
                  <?php if ($p['end_date']): ?>
                    <?= htmlspecialchars($p['end_date']) ?>
                  <?php else: ?>
                    <span class="in-progress">In Progress</span>
                  <?php endif; ?>
                </p>
                <?php if (!empty($p['github_link']) || !empty($p['live_link'])): ?>
                  <div class="project-links">
                    <?php if (!empty($p['github_link'])): ?>
                      <a href="<?= htmlspecialchars($p['github_link']) ?>" target="_blank" title="View on GitHub">
                        <i class="fab fa-github"></i>
                      </a>
                    <?php endif; ?>
                    <?php if (!empty($p['live_link'])): ?>
                      <a href="<?= htmlspecialchars($p['live_link']) ?>" target="_blank" title="View Live Demo">
                        <i class="fas fa-external-link-alt"></i>
                      </a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </main>
  
  <?php include 'footer.php'; ?>
  
  <!-- Scroll to Top Button -->
  <button id="scroll-to-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
  </button>
</body>
</html>
