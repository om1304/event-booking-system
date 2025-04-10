<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/loginUI.php");
    exit();
}

require_once("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve POST data
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $detailed_description = trim($_POST['detailed_description'] ?? '');
    $date = $_POST['date'] ?? '';
    $venue = trim($_POST['venue'] ?? '');
    $duration = !empty($_POST['duration']) ? (int)$_POST['duration'] : null;
    $layout = ($_POST['layout'] === 'indoor' || $_POST['layout'] === 'outdoor') ? $_POST['layout'] : null;
    $seating = ($_POST['seating'] === 'seated' || $_POST['seating'] === 'standing') ? $_POST['seating'] : null;
    $kid_friendly = ($_POST['kid_friendly'] === 'yes') ? 'yes' : 'no';
    $pet_friendly = ($_POST['pet_friendly'] === 'yes') ? 'yes' : 'no';
    $available_seats = isset($_POST['available_seats']) ? (int)$_POST['available_seats'] : 0;

    // Required field validation
    if (empty($title) || empty($description) || empty($date) || empty($venue) || $available_seats <= 0) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit();
    }

    // Date validation
    $today = date('Y-m-d');
    if ($date < $today) {
        echo "<script>alert('Event date cannot be in the past.'); window.history.back();</script>";
        exit();
    }

    // Handle image upload
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo "<script>alert('Only JPG, PNG, GIF, and WEBP files are allowed.'); window.history.back();</script>";
            exit();
        }

        $imageTmp = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']);
        $imageName = time() . "_" . preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $originalName);
        $targetDir = "../uploads/";
        if (!move_uploaded_file($imageTmp, $targetDir . $imageName)) {
            echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
            exit();
        }
    }

    // Insert into DB
    $stmt = $conn->prepare("
        INSERT INTO events (
            title, description, detail_desc, date, duration, layout, seating,
            kid_friendly, pet_friendly, venue, available_seats, image
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssssisssssss",
        $title,
        $description,
        $detailed_description,
        $date,
        $duration,
        $layout,
        $seating,
        $kid_friendly,
        $pet_friendly,
        $venue,
        $available_seats,
        $imageName
    );

    if ($stmt->execute()) {
        header("Location: view_events.php");
        exit();
    } else {
        echo "<script>alert('Database Error: " . addslashes($stmt->error) . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
