<?php
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to continue.']);
    exit();
}

require_once 'db.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Validate and sanitize input
$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
$age = $_POST['age'] === '' ? null : filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
$weight = $_POST['weight'] === '' ? null : filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
$height = $_POST['height'] === '' ? null : filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Basic validation
if (!$firstname || !$lastname) {
    echo json_encode(['success' => false, 'message' => 'First name and last name are required.']);
    exit();
}

try {
    // Start transaction
    $conn->begin_transaction();

    // Update basic info first
    $sql = "UPDATE users SET 
            firstname = ?,
            lastname = ?,
            age = ?,
            gender = ?,
            weight = ?,
            height = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("ssissdi", 
        $firstname,
        $lastname,
        $age,
        $gender,
        $weight,
        $height,
        $user_id
    );

    if (!$stmt->execute()) {
        throw new Exception("Failed to update profile: " . $stmt->error);
    }

    // If password is provided, update it separately
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $pwd_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        
        if ($pwd_stmt === false) {
            throw new Exception("Failed to prepare password statement: " . $conn->error);
        }

        $pwd_stmt->bind_param("si", $hashed_password, $user_id);
        
        if (!$pwd_stmt->execute()) {
            throw new Exception("Failed to update password: " . $pwd_stmt->error);
        }
        
        $pwd_stmt->close();
    }

    // Commit transaction
    $conn->commit();
    
    echo json_encode([
        'success' => true, 
        'message' => 'Profile updated successfully.',
        'data' => [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'age' => $age,
            'gender' => $gender,
            'weight' => $weight,
            'height' => $height
        ]
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?> 