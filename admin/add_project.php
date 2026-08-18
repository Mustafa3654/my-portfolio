<?php
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/../connection.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $tech_stack = trim($_POST['tech_stack'] ?? '');
    $github_link = !empty($_POST['github_link']) ? trim($_POST['github_link']) : null;
    $live_link = !empty($_POST['live_link']) ? trim($_POST['live_link']) : null;

    // Dates: allow empty end_date => store NULL
    $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

    // Validate required fields
    if (empty($title) || empty($description) || empty($tech_stack)) {
        $message = 'Please fill in all required fields.';
        $messageType = 'error';
    } else {
        // Handle image upload
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $targetDir = __DIR__ . '/../assets/uploads/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0775, true);
            }
            
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($extension, $allowedTypes)) {
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($_FILES['image']['name']));
                $targetFile = $targetDir . $imageName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = 'assets/uploads/' . $imageName;
                }
            }
        }

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO projects (title, description, tech_stack, github_link, live_link, image, start_date, end_date)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$title, $description, $tech_stack, $github_link, $live_link, $imagePath, $start_date, $end_date]);

            header("Location: projects.php?msg=added");
            exit;
        } catch (PDOException $e) {
            $message = 'Error adding project. Please try again.';
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Project | Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
  <div class="admin-container">
    <div class="admin-header">
      <h1><i class="fas fa-plus-circle"></i> Add New Project</h1>
      <div style="display: flex; gap: 1rem; align-items: center;">
        <button class="theme-toggle" onclick="toggleAdminTheme()" aria-label="Toggle theme">
            <i class="fas fa-moon" id="theme-icon"></i>
        </button>
        <a href="projects.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Projects</a>
      </div>
    </div>
    
    <?php if ($message): ?>
      <div class="alert alert-<?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="admin-form">
      <div class="form-group">
        <label for="title"><i class="fas fa-heading"></i> Project Title *</label>
        <input type="text" id="title" name="title" required placeholder="e.g., E-commerce Website">
      </div>

      <div class="form-group">
        <label for="description"><i class="fas fa-align-left"></i> Description *</label>
        <textarea id="description" name="description" rows="4" required placeholder="Describe your project, its features, and your role..."></textarea>
      </div>

      <div class="form-group">
        <label for="tech_stack"><i class="fas fa-code"></i> Tech Stack *</label>
        <input type="text" id="tech_stack" name="tech_stack" placeholder="e.g., PHP, MySQL, JavaScript, HTML, CSS" required>
        <small>Separate technologies with commas</small>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="github_link"><i class="fab fa-github"></i> GitHub Link</label>
          <input type="url" id="github_link" name="github_link" placeholder="https://github.com/username/repo">
        </div>

        <div class="form-group">
          <label for="live_link"><i class="fas fa-external-link-alt"></i> Live Demo Link</label>
          <input type="url" id="live_link" name="live_link" placeholder="https://yourproject.com">
        </div>
      </div>

      <div class="form-group">
        <label for="image"><i class="fas fa-image"></i> Project Image</label>
        <input type="file" id="image" name="image" accept="image/*">
        <small>Recommended size: 800x600px. Accepted formats: JPG, PNG, GIF, WebP</small>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="start_date"><i class="fas fa-calendar-plus"></i> Start Date *</label>
          <input type="date" id="start_date" name="start_date" required>
        </div>

        <div class="form-group">
          <label for="end_date"><i class="fas fa-calendar-check"></i> End Date</label>
          <input type="date" id="end_date" name="end_date">
          <small>Leave empty if project is still in progress</small>
        </div>
      </div>

      <button type="submit" class="btn-submit"><i class="fas fa-plus"></i> Add Project</button>
    </form>
  </div>
  <script src="JS/admin-theme.js"></script>
</body>
</html>
