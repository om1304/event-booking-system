<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/loginUI.php");
    exit();
}

require_once("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $venue = trim($_POST['venue']);
    $available_seats = (int) $_POST['available_seats'];

    // 🔒 Server-side date validation
    $today = date('Y-m-d');
    if ($date < $today) {
        echo "<script>alert('Error: Event date cannot be in the past.'); window.history.back();</script>";
        exit();
    }

    // Handle file upload
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = time() . "_" . basename($_FILES['image']['name']); // Unique filename
        $targetDir = "../uploads/";
        move_uploaded_file($imageTmp, $targetDir . $imageName);
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO events (title, description, date, venue, available_seats, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $title, $description, $date, $venue, $available_seats, $imageName);

    if ($stmt->execute()) {
        header("Location: view_events.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
