<?php
include 'connection.php';
// $settings, $skills, $services are now available from connection.php

// Fetch education data if table exists
$education = [];
try {
    $stmt = $pdo->query("SELECT * FROM education ORDER BY priority ASC");
    $education = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
} catch (PDOException $e) {
    // Table might not exist yet
}

// Fetch experience data if table exists
$experience = [];
try {
    $stmt = $pdo->query("SELECT * FROM experience ORDER BY priority ASC");
    $experience = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
} catch (PDOException $e) {
    // Table might not exist yet
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="About <?= htmlspecialchars($settings['name'] ?? 'Portfolio') ?> - <?= htmlspecialchars($settings['title'] ?? 'Web Developer') ?>">
  <title>About | <?= htmlspecialchars($settings['name'] ?? 'Portfolio') ?></title>
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
    <!-- About Me Section -->
    <section class="about-section">
      <div class="container">
        <h2 class="section-title">About Me</h2>
        
        <?php if (!empty($settings['cv_file'])): ?>
          <div class="center-btn" style="margin-bottom: 2rem;">
            <a href="<?= htmlspecialchars($settings['cv_file']) ?>" target="_blank" class="btn-primary">
              <i class="fas fa-download"></i> Download My CV
            </a>
          </div>
        <?php endif; ?>
        
        <div class="about-content">
          <div class="about-bio">
            <p><?= nl2br(htmlspecialchars($settings['bio'] ?? '')) ?></p>
          </div>
          
          <ul class="contact-list">
            <li>
              <i class="fas fa-envelope"></i>
              <strong>Email:</strong>
              <a href="mailto:<?= htmlspecialchars($settings['email'] ?? '') ?>"><?= htmlspecialchars($settings['email'] ?? 'N/A') ?></a>
            </li>
            <li>
              <i class="fas fa-phone"></i>
              <strong>Phone:</strong>
              <a href="tel:<?= htmlspecialchars($settings['phone'] ?? '') ?>"><?= htmlspecialchars($settings['phone'] ?? 'N/A') ?></a>
            </li>
            <li>
              <i class="fas fa-map-marker-alt"></i>
              <strong>Location:</strong>
              <span><?= htmlspecialchars($settings['location'] ?? 'N/A') ?></span>
            </li>
            <li>
              <i class="fab fa-linkedin"></i>
              <strong>LinkedIn:</strong>
              <a href="<?= htmlspecialchars($settings['linkedin'] ?? '#') ?>" target="_blank">View Profile</a>
            </li>
            <li>
              <i class="fab fa-github"></i>
              <strong>GitHub:</strong>
              <a href="<?= htmlspecialchars($settings['github'] ?? '#') ?>" target="_blank">View Profile</a>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- What I Do Section -->
    <section class="about-section what-i-do">
      <div class="container">
        <h2 class="section-title">What I Do</h2>
        <div class="services-grid">
          <?php if (is_array($services) && !empty($services)): ?>
            <?php foreach ($services as $service): ?>
              <div class="service-card">
                <i class="<?= htmlspecialchars($service['icon_class']) ?>"></i>
                <h3><?= htmlspecialchars($service['title']) ?></h3>
                <p><?= htmlspecialchars($service['description']) ?></p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="text-align: center; color: var(--text-secondary);">Services information coming soon.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Technical Skills Section -->
    <section class="about-section skills-full">
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
            <p style="text-align: center; color: var(--text-secondary);">Skills information coming soon.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <?php if (!empty($education)): ?>
    <!-- Education Section -->
    <section class="about-section">
      <div class="container">
        <h2 class="section-title">Education</h2>
        <div class="services-grid">
          <?php foreach ($education as $edu): ?>
            <div class="service-card">
              <i class="fas fa-graduation-cap"></i>
              <h3><?= htmlspecialchars($edu['degree']) ?></h3>
              <p><strong><?= htmlspecialchars($edu['institution']) ?></strong></p>
              <p><?= htmlspecialchars($edu['start_year']) ?> - <?= $edu['end_year'] ? htmlspecialchars($edu['end_year']) : 'Present' ?></p>
              <?php if (!empty($edu['description'])): ?>
                <p><?= htmlspecialchars($edu['description']) ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($experience)): ?>
    <!-- Experience Section -->
    <section class="about-section what-i-do">
      <div class="container">
        <h2 class="section-title">Experience</h2>
        <div class="services-grid">
          <?php foreach ($experience as $exp): ?>
            <div class="service-card">
              <i class="fas fa-briefcase"></i>
              <h3><?= htmlspecialchars($exp['position']) ?></h3>
              <p><strong><?= htmlspecialchars($exp['company']) ?></strong></p>
              <p><?= htmlspecialchars($exp['start_date']) ?> - <?= $exp['is_current'] ? '<span style="color: var(--accent-cyan);">Present</span>' : htmlspecialchars($exp['end_date']) ?></p>
              <?php if (!empty($exp['description'])): ?>
                <p><?= htmlspecialchars($exp['description']) ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>
  </main>
  
  <?php include 'footer.php'; ?>
  
  <!-- Scroll to Top Button -->
  <button id="scroll-to-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
  </button>
</body>
</html>
