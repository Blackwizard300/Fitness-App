<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

require_once 'db.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Validate and sanitize input
$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
$display_name = filter_input(INPUT_POST, 'display_name', FILTER_SANITIZE_STRING);
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
$weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
$height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);

// Basic validation
if (!$firstname || !$lastname) {
    $_SESSION['error_message'] = "First name and last name are required.";
    header('Location: profile.php');
    exit();
}

// Prepare update query
$sql = "UPDATE users SET 
        firstname = ?,
        lastname = ?,
        display_name = ?,
        age = ?,
        gender = ?,
        weight = ?,
        height = ?
        WHERE id = ?";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissdi", 
        $firstname,
        $lastname,
        $display_name,
        $age,
        $gender,
        $weight,
        $height,
        $user_id
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
    } else {
        throw new Exception($stmt->error);
    }

} catch (Exception $e) {
    $_SESSION['error_message'] = "Error updating profile: " . $e->getMessage();
} finally {
    $stmt->close();
    $conn->close();
    header('Location: profile.php');
    exit();
}
?> 