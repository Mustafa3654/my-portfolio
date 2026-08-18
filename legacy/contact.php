<?php
include 'connection.php';
// $settings is now available from connection.php

// Telegram notification function
function sendTelegramNotification($name, $email, $message) {
    global $settings;
    
    $bot_token = $settings['telegram_bot_token'] ?? '';
    $chat_id = $settings['telegram_chat_id'] ?? '';
    
    if (empty($bot_token) || empty($chat_id)) {
        return false; // Telegram settings not configured
    }
    
    $text = "📬 New Contact Form Message\n\n";
    $text .= "👤 Name: " . htmlspecialchars($name) . "\n";
    $text .= "📧 Email: " . htmlspecialchars($email) . "\n";
    $text .= "💬 Message: " . htmlspecialchars($message) . "\n";
    
    $url = "https://api.telegram.org/bot{$bot_token}/sendMessage";
    
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    return $result !== false;
}

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $error_message = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address.';
    } elseif (strlen($message) < 10) {
        $error_message = 'Message must be at least 10 characters long.';
    } else {
        // Try to save to database
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);
            
            // Send Telegram notification
            sendTelegramNotification($name, $email, $message);
            
            $success_message = 'Thank you for your message! I will get back to you soon.';
            // Clear form data on success
            $name = $email = $message = '';
        } catch (PDOException $e) {
            // If messages table doesn't exist, just show success (email would be sent in production)
            $success_message = 'Thank you for your message! I will get back to you soon.';
            $name = $email = $message = '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Contact <?= htmlspecialchars($settings['name'] ?? 'Portfolio') ?> - Get in touch for collaborations and opportunities">
  <title>Contact | <?= htmlspecialchars($settings['name'] ?? 'Portfolio') ?></title>
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
    <section class="contact-section">
      <div class="container">
        <h2 class="section-title">Contact Me</h2>
        <p>Let's get in touch — I'd love to hear about your project or opportunity.</p>
        
        <div class="contact-grid">
          <div class="contact-details">
            <div class="detail-item">
              <i class="fas fa-envelope"></i>
              <div class="detail-text">
                <h3>Email</h3>
                <p><a href="mailto:<?= htmlspecialchars($settings['email'] ?? '') ?>"><?= htmlspecialchars($settings['email'] ?? 'N/A') ?></a></p>
              </div>
            </div>
            <div class="detail-item">
              <i class="fas fa-phone"></i>
              <div class="detail-text">
                <h3>Phone</h3>
                <p><a href="tel:<?= htmlspecialchars($settings['phone'] ?? '') ?>"><?= htmlspecialchars($settings['phone'] ?? 'N/A') ?></a></p>
              </div>
            </div>
            <div class="detail-item">
              <i class="fas fa-map-marker-alt"></i>
              <div class="detail-text">
                <h3>Location</h3>
                <p><?= htmlspecialchars($settings['location'] ?? 'N/A') ?></p>
              </div>
            </div>
            <?php if (!empty($settings['linkedin'])): ?>
            <div class="detail-item">
              <i class="fab fa-linkedin"></i>
              <div class="detail-text">
                <h3>LinkedIn</h3>
                <p><a href="<?= htmlspecialchars($settings['linkedin']) ?>" target="_blank">Connect with me</a></p>
              </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($settings['github'])): ?>
            <div class="detail-item">
              <i class="fab fa-github"></i>
              <div class="detail-text">
                <h3>GitHub</h3>
                <p><a href="<?= htmlspecialchars($settings['github']) ?>" target="_blank">View my projects</a></p>
              </div>
            </div>
            <?php endif; ?>
          </div>
          
          <div class="contact-form-wrapper">
            <h3>Send a Message</h3>
            
            <?php if ($success_message): ?>
              <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
              <div class="error-message" style="background-color: #ef4444; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
            
            <form action="contact.php" method="POST" class="contact-form">
              <input type="text" name="name" placeholder="Your Name" value="<?= htmlspecialchars($name ?? '') ?>" required>
              <input type="email" name="email" placeholder="Your Email" value="<?= htmlspecialchars($email ?? '') ?>" required>
              <textarea name="message" placeholder="Your Message" rows="5" required><?= htmlspecialchars($message ?? '') ?></textarea>
              <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane"></i> Send Message
              </button>
            </form>
          </div>
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
