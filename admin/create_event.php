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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Bookings</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Events
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Create Event</a></li>
            <li><a class="dropdown-item" href="/admin/view_events.php">View Events</a></li>
          </ul>
        </li>
      </ul>
      <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</nav>
<div class="container mt-5 bg-light">
    <h2 class="mb-4 text-center">Create New Event</h2>
    <form action="create_event_handler.php" enctype="multipart/form-data" method="POST">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <?php
            $today = date('Y-m-d');
            ?>
            <input type="date" class="form-control" name="date" min="<?php echo $today; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Venue</label>
            <input type="text" name="venue" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Available Seats</label>
            <input type="number" name="available_seats" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Event Image</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Create Event</button>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
