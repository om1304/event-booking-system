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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($event['title']); ?> - BookaFest</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../styles.css">
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
              <li><a class="dropdown-item" href="../profile.php"><i class="fa-solid fa-user me-2 my-icon-theme"></i>Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Login Button when not logged in -->
          <li class="nav-item">
            <a class="btn btn-book" id="login-button" href="../auth/loginUI.php">Login</a>
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
        <img src="../uploads/<?= htmlspecialchars($event['image']); ?>" class="img-fluid rounded mb-3 w-100"
          alt="Event Image">
        <h2 class="my-icon-theme"><?= htmlspecialchars($event['title']); ?></h2>


        <?php if (!empty($event['detail_desc'])): ?>
        <p><?= nl2br(htmlspecialchars($event['detail_desc'])); ?></p>
        <?php endif; ?>

        <ul class="list-group list-group-flush mb-3">
          <?php if (!empty($event['duration'])): ?>
          <li class="list-group-item bg-dark text-white"><i class="fa-solid fa-clock me-2 my-icon-theme"></i>Duration:
            <?= $event['duration']; ?> hours</li>
          <?php endif; ?>
          <?php if (!empty($event['layout'])): ?>
          <li class="list-group-item bg-dark text-white"><i
              class="fa-solid fa-border-style me-2 my-icon-theme"></i>Layout: <?= ucfirst($event['layout']); ?></li>
          <?php endif; ?>
          <?php if (!empty($event['seating'])): ?>
          <li class="list-group-item bg-dark text-white"><i class="fa-solid fa-couch me-2 my-icon-theme"></i>Seating:
            <?= ucfirst($event['seating']); ?></li>
          <?php endif; ?>
          <li class="list-group-item bg-dark text-white"><i class="fa-solid fa-child me-2 my-icon-theme"></i>Kid
            Friendly: <?= ucfirst($event['kid_friendly']); ?></li>
          <li class="list-group-item bg-dark text-white"><i class="fa-solid fa-dog me-2 my-icon-theme"></i>Pet Friendly:
            <?= ucfirst($event['pet_friendly']); ?></li>
        </ul>

        <div class="mt-4">
          <h5 class="text-white">Venue Map:</h5>
          <p><i class="fa-solid fa-location-dot my-icon-theme"></i>
            <strong><?= htmlspecialchars($event['venue']); ?></strong>
          </p>
          <div class="ratio ratio-16x9">
            <iframe class="rounded border"
              src="https://www.google.com/maps?q=<?= urlencode($event['venue']); ?>&output=embed"
              allowfullscreen></iframe>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-12 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-body bg-black text-white rounded">
            <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
            <p><i class="fa-regular fa-calendar my-icon-theme"></i> <strong
                class="ms-1"><?= htmlspecialchars($event['date']); ?></strong></p>
            <p><i class="fa-solid fa-location-dot my-icon-theme"></i> <strong
                class="ms-1"><?= htmlspecialchars($event['venue']); ?></strong></p>
            <p><i class="fa-solid fa-chair my-icon-theme"></i> <strong class="ms-1"><?= $event['available_seats']; ?>
                seats
                available</strong></p>
            <p><i class="fa-solid fa-money-bill my-icon-theme"></i> <strong
                class="ms-1">₹<?= number_format($event['price'], 2); ?></strong></p>
            <a href="#" class="btn btn-book w-100 mt-3" data-bs-toggle="modal" data-bs-target="#bookingModal">
              <i class="fa-solid fa-ticket me-2"></i>Proceed to Booking
            </a>
            <a href="../index.php" class="btn btn-secondary w-100 mt-2">Back to Events</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="book_event.php" id="bookingForm">
      <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
      <input type="hidden" name="price_per_ticket" id="pricePerTicket" value="<?= $event['price']; ?>">

      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="bookingModalLabel">Book Tickets</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="tickets" class="form-label text-light">Number of Tickets</label>
            <input type="number" min="1" max="<?= $event['available_seats']; ?>" name="tickets_booked" id="tickets"
              class="form-control bg-secondary text-light border-0" required>
          </div>
          <div class="mb-3">
            <strong>Total Amount: ₹<span id="totalAmount">0.00</span></strong>
            <input type="hidden" name="amount_paid" id="amountPaid" value="0.00">
          </div>
        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Return</button>
          <button type="submit" class="btn btn-book" onclick="return confirm('Confirm payment?')">Pay</button>
        </div>
      </div>
    </form>
  </div>
</div>



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  const ticketInput = document.getElementById('tickets');
  const totalAmountEl = document.getElementById('totalAmount');
  const pricePerTicket = parseFloat(document.getElementById('pricePerTicket').value);
  const amountPaidInput = document.getElementById('amountPaid');

  ticketInput.addEventListener('input', function() {
    const tickets = parseInt(this.value) || 0;
    const total = (tickets * pricePerTicket).toFixed(2);
    totalAmountEl.textContent = total;
    amountPaidInput.value = total;
  });
  </script>
</body>

</html>