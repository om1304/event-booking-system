<?php
session_start();
require_once('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
            // Set session variables
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];
            $_SESSION["role"] = $row["role"];

            // Toast message
            $_SESSION["toast"] = [
                "type" => "success",
                "message" => ($row["role"] === "admin") ? "Welcome Admin!" : "Login successful!"
            ];

            // Redirect based on role
            if ($row["role"] === "admin") {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $_SESSION["toast"] = ["type" => "danger", "message" => "Invalid password."];
        }
    } else {
        $_SESSION["toast"] = ["type" => "warning", "message" => "No account found with this email."];
    }

    header("Location: loginUI.php"); // Fallback for errors
    exit();
}
?>
