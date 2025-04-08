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
  <title>Login - Event Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

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
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p class="mt-3 text-center">
              Don't have an account?
              <a href="registerUI.php" class="text-decoration-none">Register</a>
            </p>

            <p class="mt-2 text-center text-muted" style="font-size: 0.9rem;">
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
