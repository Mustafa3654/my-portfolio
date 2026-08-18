<?php
session_start();
require_once __DIR__ . '/../connection.php';

$message = '';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $message = 'Please enter both username and password.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if password is hashed (starts with $2y$) or plain text
            $passwordValid = false;
            if (strpos($user['password_hash'], '$2y$') === 0) {
                // Password is hashed, use password_verify
                $passwordValid = password_verify($password, $user['password_hash']);
            } else {
                // Password is plain text (legacy), compare directly
                $passwordValid = ($password === $user['password_hash']);
                
                // If valid, upgrade to hashed password
                if ($passwordValid) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
                    $updateStmt->execute([$hashedPassword, $user['id']]);
                }
            }
            
            if ($passwordValid) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = $user['username'];
                $_SESSION['admin_id'] = $user['id'];
                
                // Update last login
                try {
                    $updateLogin = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
                    $updateLogin->execute([$user['id']]);
                } catch (PDOException $e) {
                    // Column might not exist, ignore
                }
                
                header('Location: dashboard.php');
                exit;
            }
        }
        
        $message = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
  <div class="login-container">
    
    <div class="login-box">
      <h2><i class="fas fa-lock"></i> Admin Login</h2>
      
      <?php if ($message): ?>
        <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>
      
      <form method="POST">
        <div class="form-group">
          <label for="username"><i class="fas fa-user"></i> Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
        </div>
        
        <div class="form-group">
          <label for="password"><i class="fas fa-key"></i> Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        
        <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
        <a href="../index.php"><button type="button" class="btn-logout"><i class="fas fa-arrow-left"></i> Back to Site</button></a>
      </form>
    </div>
  </div>
  <script src="JS/admin-theme.js"></script>
</body>
</html>
