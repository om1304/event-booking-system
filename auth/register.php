<?php
session_start();
require_once('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = 'user';

    // Check if user already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['toast'] = ["type" => "warning", "message" => "User already exists!"];
        header("Location: registerUI.php");
        exit;
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;

        $_SESSION['toast'] = ["type" => "success", "message" => "Account created successfully!"];
        header("Location: registerUI.php");
        exit;
    } else {
        $_SESSION['toast'] = ["type" => "danger", "message" => "Error creating account."];
        header("Location: registerUI.php");
        exit;
    }

    $stmt->close();
    $conn->close();
}
