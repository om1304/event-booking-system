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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

  <!-- Admin Events View -->
  <div class="container mt-5">
    <h2 class="text-center mb-4">All Events</h2>
    <div class="row">
      <?php while ($event = $result->fetch_assoc()): ?>
      <div class="col-12 col-sm-6 col-md-4 mb-4">
        <div class="card h-100 shadow-sm rounded">
          <?php if ($event['image']): ?>
          <img src="../uploads/<?= htmlspecialchars($event['image']); ?>" class="card-img-top" alt="Event Image">
          <?php else: ?>
          <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
          <?php endif; ?>
          <div class="card-body d-flex flex-column bg-dark text-white">
            <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
            <p class="card-text"><?= htmlspecialchars($event['description']); ?></p>

            <p class="my-icon-theme mt-2">
              <strong><i class="fa-regular fa-calendar"></i></strong>
              <span class="text-white fw-bolder"><?= htmlspecialchars($event['date']); ?></span>
            </p>
            <p class="my-icon-theme">
              <strong><i class="fa-solid fa-location-dot"></i></strong>
              <span class="text-white fw-bolder"><?= htmlspecialchars($event['venue']); ?></span>
            </p>
            <p class="my-icon-theme">
              <strong><i class="fa-solid fa-chair"></i></strong>
              <span class="text-white fw-bolder"><?= $event['available_seats']; ?></span>
            </p>

            <div class="mt-auto d-flex justify-content-between">
              <a href="edit_event.php?id=<?= $event['id']; ?>" class="btn btn-book">Edit details</a>
              <a href="delete_event.php?id=<?= $event['id']; ?>"
                onclick="return confirm('Are you sure you want to delete this event?')"
                class="btn btn-danger btn-sm">Delete event</a>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>