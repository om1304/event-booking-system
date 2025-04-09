<?php
session_start();
require_once("../config/db.php");

if (!isset($_GET['event_id'])) {
  die("Event not found");
}

$event_id = $_GET['event_id'];

$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Event not found");
}

$event = $result->fetch_assoc();
$event_price = 499;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($event['title']); ?> - BookaFest</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../styles.css">
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

  <!-- Event Details -->
  <div class="container mt-5">
    <div class="row justify-content-center">
      <!-- Left Column -->
      <div class="col-12 col-lg-8 mb-4 mb-lg-0">
        <img src="../uploads/<?= htmlspecialchars($event['image']); ?>" class="img-fluid rounded mb-3 w-100" alt="Event Image">
        <h2><?= htmlspecialchars($event['title']); ?></h2>
        <p><i class="fa-solid fa-location-dot"></i> <strong><?= htmlspecialchars($event['venue']); ?></strong></p>
        <p><?= nl2br(htmlspecialchars($event['description'])); ?></p>
        <div class="mt-4">
          <h5 class="text-white">Venue Map:</h5>
          <div class="ratio ratio-16x9">
            <iframe class="rounded border" src="https://www.google.com/maps?q=<?= urlencode($event['venue']); ?>&output=embed" allowfullscreen></iframe>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-12 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-body bg-black text-white rounded">
            <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
            <p><i class="fa-regular fa-calendar"></i> <strong class="ms-1"><?= htmlspecialchars($event['date']); ?></strong></p>
            <p><i class="fa-solid fa-location-dot"></i> <strong class="ms-1"><?= htmlspecialchars($event['venue']); ?></strong></p>
            <p><i class="fa-solid fa-chair"></i> <strong class="ms-1"><?= $event['available_seats']; ?> seats available</strong></p>
            <p><i class="fa-solid fa-money-bill"></i> <strong class="ms-1">₹<?= number_format($event_price, 2); ?></strong></p>
            <a href="#" class="btn btn-book w-100 mt-3"><i class="fa-solid fa-ticket me-2"></i>Proceed to Booking</a>
            <a href="../index.php" class="btn btn-secondary w-100 mt-2">Back to Events</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
