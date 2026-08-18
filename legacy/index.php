<?php
include 'connection.php';

// $settings, $skills, $services are now available from connection.php

// Fetch top 3 featured projects
$stmt = $pdo->query("
  SELECT *, DATEDIFF(COALESCE(end_date, CURDATE()), start_date) AS duration
  FROM projects
  ORDER BY duration DESC
  LIMIT 3
");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($settings['title'] ?? 'Web Developer Portfolio') ?> - <?= htmlspecialchars(substr($settings['bio'] ?? '', 0, 150)) ?>">
  <title><?= htmlspecialchars($settings['name'] ?? 'Portfolio') ?> | Portfolio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/main.js"></script>
</head>
<body>
  <?php include 'header.php'; ?>
  <main>
    <!-- Hero Section -->
    <section class="home-section">
      <div class="container hero-content-wrapper">
        <div class="hero-text">
          <h2>Hello, I'm <span><?= htmlspecialchars($settings['name'] ?? 'User') ?></span></h2>
          <p><?= htmlspecialchars($settings['title'] ?? 'Web Developer') ?></p>
          <div class="hero-buttons">
            <a href="projects.php" class="btn-primary">View My Work</a>
            <a href="<?= !empty($settings['cv_file']) ? htmlspecialchars($settings['cv_file']) : '#' ?>" 
               download="<?= !empty($settings['cv_file']) ? '' : 'false' ?>" 
               class="btn-secondary btn-cv"
               onclick="<?= empty($settings['cv_file']) ? "alert('No CV uploaded yet! Please upload one in the admin dashboard.'); return false;" : '' ?>">
              <i class="fas fa-download"></i> Download CV
            </a>
          </div>
        </div>
        <div class="hero-image">
          <img src="<?= htmlspecialchars($settings['profile_img'] ?? 'assets/uploads/Profile Pic.jpg') ?>" alt="<?= htmlspecialchars($settings['name'] ?? 'Profile') ?> Profile Picture" class="profile-pic">
        </div>
      </div>
    </section>

    <!-- Technical Skills Section -->
    <section class="mini-section skills-mini">
      <div class="container">
        <h2 class="section-title">Technical Skills</h2>
        <div class="skills-grid">
          <?php if (is_array($skills) && !empty($skills)): ?>
            <?php foreach ($skills as $skill): ?>
              <div class="skill-item">
                <i class="<?= htmlspecialchars($skill['icon_class']) ?>"></i>
                <?= htmlspecialchars($skill['name']) ?>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Skills information coming soon.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>
    
    <!-- About Preview Section -->
    <section class="mini-section about-mini">
      <div class="container">
        <h2 class="section-title">About Me</h2>
        <p><?= nl2br(htmlspecialchars(substr($settings['bio'] ?? '', 0, 300))) ?>...</p>
        <div class="center-btn">
          <a href="about.php" class="btn-secondary">Learn More</a>
        </div>
      </div>
    </section>

    <!-- Popular Projects Section -->
    <section class="mini-section projects-mini">
      <div class="container">
        <h2 class="section-title">Popular Projects</h2>
        <div class="projects-grid">
          <?php foreach ($projects as $p): ?>
            <div class="project-card">
              <img src="<?= htmlspecialchars($p['image']) ?: 'assets/images/default.jpg' ?>" alt="<?= htmlspecialchars($p['title']) ?>">
              <div class="project-content">
                <h3><?= htmlspecialchars($p['title']) ?></h3>
                <p><?= htmlspecialchars(substr($p['description'], 0, 100)) ?>...</p>
                <p class="tech-stack"><?= htmlspecialchars($p['tech_stack']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="center-btn">
          <a href="projects.php" class="btn-secondary">View All Projects</a>
        </div>
      </div>
    </section>

    <!-- Contact Preview Section -->
    <section class="mini-section contact-mini">
      <div class="container">
        <h2 class="section-title">Let's Connect</h2>
        <p>Want to collaborate or hire me? Feel free to reach out.</p>
        <div class="contact-buttons">
          <a href="mailto:<?= htmlspecialchars($settings['email'] ?? '') ?>" class="btn-primary">
            <i class="fas fa-envelope"></i> Email Me
          </a>
          <a href="contact.php" class="btn-secondary">Contact Page</a>
        </div>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>
  
  <!-- Scroll to Top Button -->
  <button id="scroll-to-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
  </button>
</body>
</html>
