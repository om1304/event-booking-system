<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/loginUI.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Create Event</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../styles.css">
</head>

<body>
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

  <div class="container mt-5 bg-black p-4 rounded shadow-sm">
    <h2 class="mb-4 text-center">Create New Event</h2>
    <form action="create_event_handler.php" enctype="multipart/form-data" method="POST">
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>

      <!-- Short Description -->
      <div class="mb-3">
        <label class="form-label">Short Description</label>
        <textarea name="description" class="form-control" rows="3" required></textarea>
      </div>

      <!-- Detailed Description -->
      <div class="mb-3">
        <label class="form-label">Detailed Description</label>
        <textarea name="detailed_description" class="form-control" rows="4"></textarea>
      </div>

      <!-- Date -->
      <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" name="date" min="<?= $today ?>" required>
      </div>

      <!-- Venue -->
      <div class="mb-3">
        <label class="form-label">Venue</label>
        <input type="text" name="venue" class="form-control" required>
      </div>

      <!-- Duration -->
      <div class="mb-3">
        <label class="form-label">Duration (in hours)</label>
        <input type="number" name="duration" class="form-control">
      </div>

      <!-- Layout -->
      <div class="mb-3">
        <label class="form-label">Layout</label>
        <select name="layout" class="form-select">
          <option value="">Select layout</option>
          <option value="indoor">Indoor</option>
          <option value="outdoor">Outdoor</option>
        </select>
      </div>

      <!-- Seating -->
      <div class="mb-3">
        <label class="form-label">Seating Arrangement</label>
        <select name="seating" class="form-select">
          <option value="">Select seating</option>
          <option value="seated">Seated</option>
          <option value="standing">Standing</option>
        </select>
      </div>

      <!-- Kid Friendly -->
      <div class="mb-3">
        <label class="form-label">Kid Friendly</label>
        <select name="kid_friendly" class="form-select">
          <option value="no">No</option>
          <option value="yes">Yes</option>
        </select>
      </div>

      <!-- Pet Friendly -->
      <div class="mb-3">
        <label class="form-label">Pet Friendly</label>
        <select name="pet_friendly" class="form-select">
          <option value="no">No</option>
          <option value="yes">Yes</option>
        </select>
      </div>

      <!-- Available Seats -->
      <div class="mb-3">
        <label class="form-label">Available Seats</label>
        <input type="number" name="available_seats" class="form-control" required>
      </div>

      <!-- Price -->
      <div class="mb-3">
        <label class="form-label">Ticket Price (₹)</label>
        <input type="number" name="price" class="form-control" min="0" step="0.01" required>
      </div>
      <!-- Event Image -->
      <div class="mb-3">
        <label class="form-label">Event Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
      </div>

      <button type="submit" class="btn btn-book">Create Event</button>
      <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>