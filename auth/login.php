<?php
session_start();
require_once('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Fetch user by email
    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If user found
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];
            $_SESSION["role"] = $row["role"];

            // Redirect based on role
            if ($row["role"] === "admin") {
                $_SESSION["toast"] = ["type" => "success", "message" => "Welcome Admin!"];
                header("Location: ../admin/dashboard.php");
            } else {
                $_SESSION["toast"] = ["type" => "success", "message" => "Login successful!"];
                header("Location: loginUI.php");
            }
            exit();
        } else {
            $_SESSION["toast"] = ["type" => "danger", "message" => "Invalid password."];
        }
    } else {
        $_SESSION["toast"] = ["type" => "warning", "message" => "No account found with this email."];
    }

    header("Location: loginUI.php"); // Common fallback for errors
    exit();
}
