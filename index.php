<?php
require_once("config/db.php"); // adjust path if needed

// Fetch all events
$result = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BookaFest - Book Your Next Experience</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- External stylesheet -->
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">BookaFest</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-white"></span>
        </button>
    </div>
</nav>

<!-- Events Section -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Upcoming Events</h2>
    <div class="row">
        <?php while ($event = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if ($event['image']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($event['image']); ?>" class="card-img-top" alt="Event Image">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                        <p class="card-text text-white"><?php echo htmlspecialchars($event['description']); ?></p>
                        <p class="text-white"><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                        <p class="text-white"><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
                        <p class="text-white"><strong>Seats Available:</strong> <?php echo $event['available_seats']; ?></p>
                        <a href="#" class="btn btn-book mt-auto">Book Now</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

