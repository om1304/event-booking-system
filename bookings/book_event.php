<?php
session_start();
require_once("../config/db.php"); // your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $event_id = intval($_POST['event_id']);
    $tickets_booked = intval($_POST['tickets_booked']);
    $amount_paid = floatval($_POST['amount_paid']);

    if (!$user_id || !$event_id || $tickets_booked <= 0 || $amount_paid <= 0) {
        $_SESSION['error'] = 'Invalid booking details.';
        header("Location: ../index.php");
        exit;
    }

    $conn->begin_transaction();

    try {
        // 🔒 Check if the user already booked this event
        $stmt = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE user_id = ? AND event_id = ?");
        $stmt->bind_param("ii", $user_id, $event_id);
        $stmt->execute();
        $stmt->bind_result($existingBookingCount);
        $stmt->fetch();
        $stmt->close();

        if ($existingBookingCount > 0) {
            $_SESSION['error'] = 'You have already booked this event.';
            header("Location: ../index.php?id=" . $event_id);
            exit;
        }

        // ✅ Check available seats
        $stmt = $conn->prepare("SELECT available_seats FROM events WHERE id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->bind_result($available_seats);
        $stmt->fetch();
        $stmt->close();

        if ($tickets_booked > $available_seats) {
            $_SESSION['error'] = 'Not enough seats available.';
            header("Location: ../index.php?id=" . $event_id);
            exit;
        }

        // 📝 Insert new booking
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, event_id, tickets_booked, amount_paid) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $user_id, $event_id, $tickets_booked, $amount_paid);
        $stmt->execute();
        $stmt->close();

        // 🔁 Update event seats
        $stmt = $conn->prepare("UPDATE events SET available_seats = available_seats - ? WHERE id = ?");
        $stmt->bind_param("ii", $tickets_booked, $event_id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

        $_SESSION['success'] = 'Booking successful!';
        header("Location: ../index.php?id=" . $event_id);
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = 'Booking failed. Please try again.';
        error_log($e->getMessage());
        header("Location: ../index.php?id=" . $event_id);
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
