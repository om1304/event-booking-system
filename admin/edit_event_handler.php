<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/loginUI.php");
    exit();
}

require_once("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $detail_desc = trim($_POST['detail_desc']);
    $date = $_POST['date'];
    $duration = isset($_POST['duration']) ? intval($_POST['duration']) : null;
    $layout = $_POST['layout'] ?? null;
    $seating = $_POST['seating'] ?? null;
    $kid_friendly = $_POST['kid_friendly'] ?? 'no';
    $pet_friendly = $_POST['pet_friendly'] ?? 'no';
    $venue = trim($_POST['venue']);
    $available_seats = (int) $_POST['available_seats'];
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.00;

    // Get current image
    $stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentImage);
    $stmt->fetch();
    $stmt->close();

    // Upload new image if provided
    $imageName = $currentImage;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        if ($currentImage && file_exists("../uploads/$currentImage")) {
            unlink("../uploads/$currentImage");
        }
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($imageTmp, "../uploads/" . $imageName);
    }

    // Update event
    $stmt = $conn->prepare("UPDATE events 
        SET title = ?, description = ?, detail_desc = ?, date = ?, duration = ?, layout = ?, seating = ?, kid_friendly = ?, pet_friendly = ?, venue = ?, available_seats = ?, image = ?, price = ?
        WHERE id = ?");
    $stmt->bind_param("ssssisssssissi", $title, $description, $detail_desc, $date, $duration, $layout, $seating, $kid_friendly, $pet_friendly, $venue, $available_seats, $imageName, $price, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: view_events.php?success=Event updated");
    exit();
}
?>
