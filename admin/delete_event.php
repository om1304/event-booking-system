<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/loginUI.php");
    exit();
}

require_once("../config/db.php");

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);

    // First, get the image name and delete it
    $stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    if ($image && file_exists("../uploads/$image")) {
        unlink("../uploads/$image");
    }

    // Then, delete the event
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();

    header("Location: view_events.php?success=Event deleted");
    exit();
}
?>
