<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to continue.']);
    exit();
}

// Get the user ID from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$userId = isset($data['userId']) ? (int)$data['userId'] : 0;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit();
}

try {
    // Start transaction
    $conn->begin_transaction();

    // Delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Commit the transaction
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            throw new Exception("User not found");
        }
    } else {
        throw new Exception("Failed to delete user");
    }
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?> 