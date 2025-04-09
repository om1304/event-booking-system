<?php
session_start();
require_once("config/db.php");

// Fetch all events
$result = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BookaFest - Book Your Next Experience</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">BookaFest</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon text-white"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item dropdown" data-bs-theme="dark">
              <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="profileDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user-circle me-2 fa-lg my-icon-theme"></i>
                <?= htmlspecialchars($_SESSION['user_name']); ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user me-2 my-icon-theme"></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="auth/logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="btn btn-book" id="login-button" href="auth/loginUI.php">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Events Section -->
  <div class="container mt-5">
    <h2 class="text-center mb-4">GRAB YOUR TICKETS NOW</h2>
    <div class="row">
      <?php while ($event = $result->fetch_assoc()): ?>
        <div class="col-12 col-sm-6 col-md-4 mb-4">
          <div class="card h-100 shadow-sm rounded">
            <?php if ($event['image']): ?>
              <img src="uploads/<?= htmlspecialchars($event['image']); ?>" class="card-img-top" alt="Event Image">
            <?php else: ?>
              <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
            <?php endif; ?>
            <div class="card-body d-flex flex-column bg-dark text-white">
              <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
              <p class="card-text"><?= htmlspecialchars($event['description']); ?></p>
              <p class="my-icon-theme">
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

              <a href="bookings/book.php?event_id=<?= $event['id']; ?>" class="btn btn-book mt-auto btn-success">Book Now</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
