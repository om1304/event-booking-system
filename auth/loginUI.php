<?php
session_start();
$message = "";
$alertType = "";

if (isset($_SESSION['toast'])) {
    $alertType = $_SESSION['toast']['type']; // success, danger, warning
    $message = $_SESSION['toast']['message'];
    unset($_SESSION['toast']); // Clear after displaying
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Event Booking</title>
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
            <h2 class="text-center mb-4">Login</h2>
            <form action="login.php" method="POST">
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <button type="submit" class="btn btn-book w-100">Login</button>
            </form>

            <p class="mt-3 text-center text-white">
              Don't have an account?
              <a href="registerUI.php" class="text-decoration-none">Register</a>
            </p>

            <p class="mt-2 text-center text-white" style="font-size: 0.9rem;">
              * Admins can use this same login form.
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>