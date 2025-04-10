<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: auth/loginUI.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

// Handle booking cancellation
if (isset($_POST['cancel_booking_id'])) {
  $bookingId = $_POST['cancel_booking_id'];

  $stmt = $conn->prepare("SELECT event_id, tickets_booked FROM bookings WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $bookingId, $user_id);
  $stmt->execute();
  $stmt->bind_result($eventId, $ticketsBooked);
  $stmt->fetch();
  $stmt->close();

  $stmt = $conn->prepare("SELECT date FROM events WHERE id = ?");
  $stmt->bind_param("i", $eventId);
  $stmt->execute();
  $stmt->bind_result($eventDate);
  $stmt->fetch();
  $stmt->close();

  $now = time();

  if ($eventDate !== null) {
      $eventTimestamp = strtotime($eventDate);

      if ($eventTimestamp - $now > 86400) {
          $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
          $stmt->bind_param("i", $bookingId);
          $stmt->execute();
          $stmt->close();

          $stmt = $conn->prepare("UPDATE events SET available_seats = available_seats + ? WHERE id = ?");
          $stmt->bind_param("ii", $ticketsBooked, $eventId);
          $stmt->execute();
          $stmt->close();

          $cancelMessage = "Booking cancelled successfully.";
      } else {
          $cancelMessage = "You cannot cancel bookings within 24 hours of the event.";
      }
  } else {
      $cancelMessage = "Invalid event date.";
  }
}

// Fetch bookings
$stmt = $conn->prepare("
  SELECT b.id, e.title AS event_name, e.date AS event_date, b.booking_date, b.tickets_booked, b.amount_paid
  FROM bookings b
  JOIN events e ON b.event_id = e.id
  WHERE b.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Your Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
  <style>
  /* Profile and booking containers */
  .profile-sidebar,
  .table-card {
    border: 2px solid #1DCD9F;
    border-radius: 10px;
    padding: 20px;
    background-color: black;
    /* Slightly lighter than body */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  /* Table styling */
  .table {
    background-color: ##222222;
    /* Match body */
    color: white !important;
  }

  /* Table header */
  .table thead th {
    background-color: #495057;
    /* Darker header */
    color: white;
  }
  </style>
</head>

<body>

  <!-- Navbar -->
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
          <li class="nav-item dropdown" data-bs-theme="dark">
            <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="profileDropdown"
              role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user-circle me-2 fa-lg my-icon-theme"></i>
              <?= htmlspecialchars($_SESSION['user_name']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2 my-icon-theme"></i>Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-danger" href="auth/logout.php"><i
                    class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
            </ul>
          </li>
          <?php else: ?>
          <!-- Login Button when not logged in -->
          <li class="nav-item">
            <a class="btn btn-book" id="login-button" href="auth/loginUI.php">Login</a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Profile Section -->
  <div class="container mt-5">
    <div class="row g-4">
      <!-- Left: Profile Info -->
      <div class="col-md-4">
        <div class="profile-sidebar d-flex flex-column align-items-center text-center p-4 rounded">
          <img src="pfp.jpg" alt="Profile" class="profile-img mb-3">
          <h4 class="mt-2 my-icon-theme text-white"><?= htmlspecialchars($name); ?></h4>
          <p class="profile-info text-white mb-0"><i class="fa-solid fa-envelope my-icon-theme"></i> <?= htmlspecialchars($email); ?></p>
        </div>
      </div>


      <!-- Right: Booking Table -->
      <div class="col-md-8">
        <div class="table-card">
          <h4>Your Bookings</h4>

          <?php if (isset($cancelMessage)): ?>
          <div class="alert alert-info mt-3"><?= $cancelMessage; ?></div>
          <?php endif; ?>

          <div class="table-responsive mt-3">
            <table class="table table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>Event</th>
                  <th>Event Date</th>
                  <th>Booking Date</th>
                  <th>Tickets</th>
                  <th>Amount Paid</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($booking = $result->fetch_assoc()): ?>
                <?php
                                $eventDateTimestamp = strtotime($booking['event_date']);
                                $now = time();
                                $canCancel = ($eventDateTimestamp - $now > 86400);
                            ?>
                <tr>
                  <td><?= htmlspecialchars($booking['event_name']); ?></td>
                  <td><?= htmlspecialchars($booking['event_date']); ?></td>
                  <td><?= htmlspecialchars($booking['booking_date']); ?></td>
                  <td><?= $booking['tickets_booked']; ?></td>
                  <td>₹<?= $booking['amount_paid']; ?></td>
                  <td>
                    <?php if ($canCancel): ?>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                      <input type="hidden" name="cancel_booking_id" value="<?= $booking['id']; ?>">
                      <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                    </form>
                    <?php else: ?>
                    <span class="text-muted">Not cancellable</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>