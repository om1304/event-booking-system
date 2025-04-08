<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/loginUI.php");
    exit();
}

require_once("../config/db.php");

// Fetch all events
$result = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Event Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Bookings</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Events
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="create_event.php">Create Event</a></li>
            <li><a class="dropdown-item" href="view_events.php">View Events</a></li>
          </ul>
        </li>
      </ul>
      <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4">All Events</h2>
    <div class="row">
        <?php while ($event = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 bg-light shadow-sm">
                    <?php if ($event['image']): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($event['image']); ?>" class="card-img-top" alt="Event Image">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                        <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
                        <p><strong>Seats Available:</strong> <?php echo $event['available_seats']; ?></p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-primary btn-sm">Edit Details</a>
                        <a href="delete_event.php?id=<?php echo $event['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this event?')" 
                           class="btn btn-danger btn-sm">Remove Event</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
