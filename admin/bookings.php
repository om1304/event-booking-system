<?php
session_start();
require '../config/db.php';

// Fetch bookings summary
$stmt = $conn->prepare("
  SELECT 
    e.id AS event_id,
    e.title AS event_title,
    e.available_seats,
    COALESCE(SUM(b.tickets_booked), 0) AS total_booked
  FROM events e
  LEFT JOIN bookings b ON e.id = b.event_id
  GROUP BY e.id, e.title, e.available_seats
  ORDER BY e.id
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookings Summary</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../styles.css"> 
  <style>
    body {
      background-color: #222222;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }

    .container {
      margin-top: 60px;
    }

    .table {
      background-color: #1e1e1e;
      color: white;
      border-radius: 10px;
      overflow: hidden;
    }

    .table thead {
      background-color: #2c2c2c;
    }

    .table th,
    .table td {
      vertical-align: middle;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #2a2a2a;
    }

    .table-striped tbody tr:nth-of-type(even) {
      background-color: #1e1e1e;
    }

    .table-bordered th,
    .table-bordered td {
      border: 1px solid #444;
    }

    h2 {
      color: #00ffb3;
      font-weight: 600;
      text-align: center;
      margin-bottom: 30px;
    }

    .table th {
      background-color: #495057;
    /* Darker header */
    color: white;
    }
  </style>
</head>
<body>
<!-- Navbar -->
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
<div class="container">
  <h2>Bookings Per Event</h2>

  <div class="table-responsive">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>Event ID</th>
          <th>Event Title</th>
          <th>Tickets Booked</th>
          <th>Available Seats</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['event_id']); ?></td>
          <td><?= htmlspecialchars($row['event_title']); ?></td>
          <td><?= $row['total_booked']; ?></td>
          <td><?= $row['available_seats']; ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
