<?php
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/../connection.php';

$message = '';
$messageType = '';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Get project image to delete if exists
    $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Delete the project
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    
    // Delete image file if exists
    if (!empty($project['image']) && file_exists('../' . $project['image'])) {
        @unlink('../' . $project['image']);
    }
    
    header("Location: projects.php?msg=deleted");
    exit;
}

if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'deleted':
            $message = 'Project deleted successfully!';
            $messageType = 'success';
            break;
        case 'added':
            $message = 'Project added successfully!';
            $messageType = 'success';
            break;
        case 'updated':
            $message = 'Project updated successfully!';
            $messageType = 'success';
            break;
    }
}

$stmt = $pdo->query("SELECT * FROM projects ORDER BY (end_date IS NULL) DESC, start_date DESC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Projects | Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/admin.css">
  <script src="JS/deleteConfirm.js" defer></script>
</head>
<body>
  <div class="container">
    <div class="admin-header">
      <h1><i class="fas fa-folder"></i> Manage Projects</h1>
      <a href="add_project.php" class="btn-primary"><i class="fas fa-plus"></i> Add New Project</a>
    </div>
    <div class="admin-header">
      <h1><i class="fas fa-folder-open"></i> Manage Projects</h1>
      <div style="display: flex; gap: 1rem; align-items: center;">
        <button class="theme-toggle" onclick="toggleAdminTheme()" aria-label="Toggle theme">
            <i class="fas fa-moon" id="theme-icon"></i>
        </button>
        <a href="dashboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
      </div>
    </div>

    <?php if ($message): ?>
      <div class="alert alert-<?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
      <a href="add_project.php" style="display: inline-flex; align-items: center; gap: 0.5rem; background: var(--accent); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
        <i class="fas fa-plus"></i> Add New Project
      </a>
    </div>

    <?php if (empty($projects)): ?>
      <div class="alert">No projects found. Click "Add New Project" to create one.</div>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Tech Stack</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($projects as $p): ?>
            <tr>
              <td><?= $p['id'] ?></td>
              <td>
                <strong><?= htmlspecialchars($p['title']) ?></strong>
                <?php if (!empty($p['image'])): ?>
                  <br><small style="color: var(--muted);"><i class="fas fa-image"></i> Has image</small>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($p['tech_stack']) ?></td>
              <td><?= htmlspecialchars($p['start_date'] ?? 'N/A') ?></td>
              <td>
                <?php if (empty($p['end_date'])): ?>
                  <span style="color: #38bdf8; font-weight: 600;"><i class="fas fa-spinner fa-spin"></i> In Progress</span>
                <?php else: ?>
                  <?= htmlspecialchars($p['end_date']) ?>
                <?php endif; ?>
              </td>
              <td>
                <div class="actions">
                  <a href="edit_project.php?id=<?= htmlspecialchars($p['id']) ?>" title="Edit Project">
                    <i class="fas fa-pen btn-edit"></i>
                  </a>
                  <a href="#" onclick="confirmDelete(event, <?= $p['id'] ?>)" title="Delete Project">
                    <i class="fas fa-trash btn-delete"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
    
    <p style="margin-top: 1.5rem; color: var(--muted); text-align: center;">
      Total Projects: <strong><?= count($projects) ?></strong>
    </p>
  </div>

  <!-- Delete Confirmation Popup -->
  <div id="deleteConfirm">
    <div class="delete-box">
      <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--error); margin-bottom: 1rem;"></i>
      <h3>Are you sure you want to delete this project?</h3>
      <p style="color: var(--muted); margin-bottom: 1.5rem;">This action cannot be undone.</p>
      <div class="btns">
        <button class="yes" id="confirmYes"><i class="fas fa-trash"></i> Delete</button>
        <button class="no" id="confirmNo"><i class="fas fa-times"></i> Cancel</button>
      </div>
    </div>
    </div>
  </div>
  <script src="JS/admin-theme.js"></script>
</body>
</html>
