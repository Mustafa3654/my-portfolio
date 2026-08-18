<?php
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/../connection.php';

$message = "";
$messageType = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $linkedin = trim($_POST['linkedin'] ?? '');
    $github = trim($_POST['github'] ?? '');
    $telegram_bot_token = trim($_POST['telegram_bot_token'] ?? '');
    $telegram_chat_id = trim($_POST['telegram_chat_id'] ?? '');

    // Handle image upload if provided
    $imagePath = null;
    if (!empty($_FILES['profile_img']['name'])) {
        $targetDir = "../assets/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }
        
        // Generate unique filename to prevent overwrites
        $extension = pathinfo($_FILES['profile_img']['name'], PATHINFO_EXTENSION);
        $imageName = time() . '_' . basename($_FILES['profile_img']['name']);
        $targetFile = $targetDir . $imageName;

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array(strtolower($extension), $allowedTypes)) {
            if (move_uploaded_file($_FILES['profile_img']['tmp_name'], $targetFile)) {
                $imagePath = "assets/uploads/" . $imageName;
            }
        }
    }

    // Handle CV upload if provided
    $cvPath = null;
    if (!empty($_FILES['cv_file']['name'])) {
        $targetDir = "../assets/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }
        
        $extension = pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION);
        $cvName = 'cv_' . time() . '.' . $extension;
        $targetFile = $targetDir . $cvName;

        // Validate file type (PDF only)
        if (strtolower($extension) === 'pdf') {
            if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $targetFile)) {
                $cvPath = "assets/uploads/" . $cvName;
            }
        }
    }

    // Update query using prepared statements
    $query = "UPDATE settings SET name=?, title=?, bio=?, email=?, phone=?, location=?, linkedin=?, github=?, telegram_bot_token=?, telegram_chat_id=?";
    $params = [$name, $title, $bio, $email, $phone, $location, $linkedin, $github, $telegram_bot_token, $telegram_chat_id];

    if ($imagePath) {
        $query .= ", profile_img=?";
        $params[] = $imagePath;
    }

    if ($cvPath) {
        $query .= ", cv_file=?";
        $params[] = $cvPath;
    }

    $query .= " WHERE id=1";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $message = "Profile updated successfully!";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "Error updating profile. Please try again.";
        $messageType = "error";
    }
}

// Fetch existing data
$stmt = $pdo->query("SELECT * FROM settings WHERE id=1");
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile | Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
  <div class="admin-container">
    <div class="admin-header">
      <h1><i class="fas fa-user-edit"></i> Edit Profile</h1>
      <div style="display: flex; gap: 1rem; align-items: center;">
        <button class="theme-toggle" onclick="toggleAdminTheme()" aria-label="Toggle theme">
            <i class="fas fa-moon" id="theme-icon"></i>
        </button>
        <a href="dashboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
       </div>

      <div class="form-row">
        <div class="form-group">
          <label for="telegram_bot_token"><i class="fas fa-robot"></i> Telegram Bot Token</label>
          <input type="text" id="telegram_bot_token" name="telegram_bot_token" value="<?= htmlspecialchars($profile['telegram_bot_token'] ?? '') ?>" placeholder="Bot token from BotFather">
        </div>

        <div class="form-group">
          <label for="telegram_chat_id"><i class="fas fa-comment"></i> Telegram Chat ID</label>
          <input type="text" id="telegram_chat_id" name="telegram_chat_id" value="<?= htmlspecialchars($profile['telegram_chat_id'] ?? '') ?>" placeholder="Your chat ID">
        </div>
      </div>

      <div class="form-group">
        <label for="name"><i class="fas fa-user"></i> Full Name</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($profile['name'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label for="title"><i class="fas fa-briefcase"></i> Professional Title</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($profile['title'] ?? '') ?>" required placeholder="e.g., Web Developer, IT Assistant">
      </div>

      <div class="form-group">
        <label for="bio"><i class="fas fa-align-left"></i> Bio / About Me</label>
        <textarea id="bio" name="bio" rows="6"><?= htmlspecialchars($profile['bio'] ?? '') ?></textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="email"><i class="fas fa-envelope"></i> Email</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label for="phone"><i class="fas fa-phone"></i> Phone</label>
          <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" placeholder="+961 XX XXX XXX">
        </div>
      </div>

      <div class="form-group">
        <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
        <input type="text" id="location" name="location" value="<?= htmlspecialchars($profile['location'] ?? '') ?>" placeholder="e.g., Beirut, Lebanon">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="linkedin"><i class="fab fa-linkedin"></i> LinkedIn URL</label>
          <input type="url" id="linkedin" name="linkedin" value="<?= htmlspecialchars($profile['linkedin'] ?? '') ?>" placeholder="https://linkedin.com/in/username">
        </div>

        <div class="form-group">
          <label for="github"><i class="fab fa-github"></i> GitHub URL</label>
          <input type="url" id="github" name="github" value="<?= htmlspecialchars($profile['github'] ?? '') ?>" placeholder="https://github.com/username">
        </div>
      </div>

      <div class="form-group">
        <label><i class="fas fa-image"></i> Profile Image</label>
        <?php if (!empty($profile['profile_img'])): ?>
          <div class="current-image">
            <img src="../<?= htmlspecialchars($profile['profile_img']) ?>" alt="Current Profile">
            <span>Current image</span>
          </div>
        <?php endif; ?>
        <input type="file" name="profile_img" accept="image/*">
        <small>Accepted formats: JPG, PNG, GIF, WebP</small>
      </div>

      <div class="form-group">
        <label><i class="fas fa-file-pdf"></i> CV / Resume (PDF)</label>
        <?php if (!empty($profile['cv_file'])): ?>
          <div class="current-file">
            <a href="../<?= htmlspecialchars($profile['cv_file']) ?>" target="_blank"><i class="fas fa-file-pdf"></i> View Current CV</a>
          </div>
        <?php endif; ?>
        <input type="file" name="cv_file" accept=".pdf">
        <small>Upload your CV in PDF format</small>
      </div>

      <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Changes</button>
    </form>
  </div>
  <script src="JS/admin-theme.js"></script>
</body>
</html>
