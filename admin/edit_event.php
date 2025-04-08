<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/loginUI.php");
    exit();
}

require_once("../config/db.php");

if (!isset($_GET['id'])) {
    header("Location: view_events.php");
    exit();
}

$event_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Event</h2>
    <form method="POST" action="edit_event_handler.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($event['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($event['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo $event['date']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Venue</label>
            <input type="text" name="venue" class="form-control" value="<?php echo htmlspecialchars($event['venue']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Available Seats</label>
            <input type="number" name="available_seats" class="form-control" value="<?php echo $event['available_seats']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Event Image</label><br>
            <?php if ($event['image']): ?>
                <img src="../uploads/<?php echo $event['image']; ?>" width="200"><br>
            <?php endif; ?>
            <input type="file" name="image" class="form-control mt-2">
        </div>
        <button type="submit" class="btn btn-success">Update Event</button>
    </form>
</div>
</body>
</html>
