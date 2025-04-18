<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['toast'] = [
        'type' => 'danger',
        'message' => 'Access denied. Admins only.'
    ];
    header("Location: ../auth/loginUI.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../styles.css"> <!-- Adjust the path if needed -->
</head>
<body>

<!-- Dark Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">EventManager</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/admin/dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="bookings.php">Bookings</a>
          </li>
          <li class="nav-item dropdown" data-bs-theme="dark">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Events
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/admin/create_event.php">Create Event</a></li>
              <li><a class="dropdown-item" href="/admin/view_events.php">View Events</a></li>
            </ul>
          </li>
        </ul>

        <!-- Profile Dropdown -->
        <ul class="navbar-nav">
          <li class="nav-item dropdown" data-bs-theme="dark">
            <a class="nav-link dropdown-toggle d-flex align-items-center text-white px-3" href="#" id="profileDropdown"
              role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user-circle me-2 fa-lg my-icon-theme"></i>
              <?= htmlspecialchars($_SESSION['user_name']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="../profile.php"><i class="fa-solid fa-user me-2 my-icon-theme"></i>View Profile</a>
              </li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-danger" href="../auth/logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>

      </div>
    </div>
  </nav>

<div class="container mt-5">
  <h1 class="text-center">Welcome, Admin 👋</h1>
  <!-- Add dashboard stats or quick links here -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
