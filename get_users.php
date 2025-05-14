<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to continue.']);
    exit();
}

try {
    // Fetch all users
    $sql = "SELECT id, firstname, lastname, email, phone, age, gender, weight, height FROM users";
    $result = $conn->query($sql);

    if ($result) {
        $users = [];
        while ($row = $result->fetch_assoc()) {
            // Sanitize the data before sending
            $users[] = array(
                'id' => (int)$row['id'],
                'firstname' => htmlspecialchars($row['firstname']),
                'lastname' => htmlspecialchars($row['lastname']),
                'email' => htmlspecialchars($row['email']),
                'phone' => htmlspecialchars($row['phone']),
                'age' => $row['age'] ? (int)$row['age'] : null,
                'gender' => htmlspecialchars($row['gender']),
                'weight' => $row['weight'] ? (float)$row['weight'] : null,
                'height' => $row['height'] ? (float)$row['height'] : null
            );
        }
        echo json_encode(['success' => true, 'users' => $users]);
    } else {
        throw new Exception("Failed to fetch users");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    $conn->close();
}
?> 