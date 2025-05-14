<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

require_once 'db.php';

// Check if file was uploaded
if (!isset($_FILES['profile_image'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No file uploaded']);
    exit();
}

$file = $_FILES['profile_image'];
$user_id = $_SESSION['user_id'];

// Validate file
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($file['type'], $allowed_types)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid file type. Only JPG, PNG and GIF allowed.']);
    exit();
}

// Create uploads directory if it doesn't exist
$upload_dir = 'uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'profile_' . $user_id . '_' . time() . '.' . $extension;
$filepath = $upload_dir . $filename;

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    // Update database with new image path
    $sql = "UPDATE users SET profile_image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database error']);
        exit();
    }

    $stmt->bind_param('si', $filepath, $user_id);
    
    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            'message' => 'Profile image updated successfully',
            'image_url' => $filepath
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to update database']);
    }
    
    $stmt->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to upload file']);
}

$conn->close();
?> 