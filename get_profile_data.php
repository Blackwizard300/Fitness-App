<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

require_once 'db.php';

try {
    // Get user data
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT firstname, lastname, email, age, gender, weight, height, profile_image FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // If no profile image, set default
        if (empty($user['profile_image'])) {
            $user['profile_image'] = 'uploads/default-profile.png';
        }
        
        echo json_encode(['success' => true, 'data' => $user]);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?> 