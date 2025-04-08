<?php
session_start();
$message = "";
$alertType = "";

if (isset($_SESSION['toast'])) {
    $alertType = $_SESSION['toast']['type'];
    $message = $_SESSION['toast']['message'];
    unset($_SESSION['toast']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Event Booking System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

  <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
    <?php if ($message): ?>
      <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
        <?= $message ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <h3 class="text-center mb-4">Register</h3>
    <form action="register.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" id="name" required placeholder="Your full name">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="email" required placeholder="you@example.com">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" required placeholder="Enter your password">
      </div>
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-success">Register</button>
      </div>
      <p class="text-center">
        Already have an account? <a href="loginUI.php">Login here</a>
      </p>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
