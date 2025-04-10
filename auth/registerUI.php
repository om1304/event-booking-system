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
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">BookaFest</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Home Button -->
        <li class="nav-item">
          <a class="nav-link text-white" href="../index.php">Home</a>
        </li>
      </ul>

      <ul class="navbar-nav">
        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- User Dropdown when logged in -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="profileDropdown"
              role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user-circle me-2 fa-lg"></i>
              <?= htmlspecialchars($_SESSION['user_name']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Login Button when not logged in -->
          <li class="nav-item">
            <a class="btn btn-book" id="login-button" href="loginUI.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <?php if ($message): ?>
        <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
          <?= $message ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-body">
          <h2 class="text-center mb-4">Register</h2>
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
            <button type="submit" class="btn btn-book w-100">Register</button>
          </form>

          <p class="mt-3 text-center text-white">
            Already have an account?
            <a href="loginUI.php" class="text-decoration-none">Login here</a>
          </p>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
