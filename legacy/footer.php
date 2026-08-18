<?php
// Use the global $settings if already loaded, otherwise fetch
if (!isset($settings) || empty($settings)) {
    $stmt = $pdo->query("SELECT linkedin, github, name FROM settings LIMIT 1");
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<footer class="site-footer">
  <div class="container footer-inner">
    <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['name'] ?? 'Portfolio') ?>. All rights reserved.</p>
    <div class="social-links">
      <?php if (!empty($settings['linkedin'])): ?>
        <a href="<?= htmlspecialchars($settings['linkedin']) ?>" target="_blank" aria-label="LinkedIn Profile">
          <i class="fab fa-linkedin"></i>
        </a>
      <?php endif; ?>
      <?php if (!empty($settings['github'])): ?>
        <a href="<?= htmlspecialchars($settings['github']) ?>" target="_blank" aria-label="GitHub Profile">
          <i class="fab fa-github"></i>
        </a>
      <?php endif; ?>
      <?php if (!empty($settings['twitter'])): ?>
        <a href="<?= htmlspecialchars($settings['twitter']) ?>" target="_blank" aria-label="Twitter Profile">
          <i class="fab fa-twitter"></i>
        </a>
      <?php endif; ?>
      <?php if (!empty($settings['instagram'])): ?>
        <a href="<?= htmlspecialchars($settings['instagram']) ?>" target="_blank" aria-label="Instagram Profile">
          <i class="fab fa-instagram"></i>
        </a>
      <?php endif; ?>
    </div>
  </div>
</footer>
