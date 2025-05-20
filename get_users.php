<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Enable error reporting for debugging (development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to continue.']);
    exit();
}

// Check if DB connection has an error
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit();
}

try {
    // SQL query to fetch all users
    $sql = "SELECT id, firstname, lastname, email, phone, age, gender, weight, height FROM users";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = array(
    'id' => (int)$row['id'],
    'firstname' => $row['firstname'] !== null ? htmlspecialchars($row['firstname']) : '',
    'lastname' => $row['lastname'] !== null ? htmlspecialchars($row['lastname']) : '',
    'email' => $row['email'] !== null ? htmlspecialchars($row['email']) : '',
    'phone' => $row['phone'] !== null ? htmlspecialchars($row['phone']) : '',
    'age' => $row['age'] !== null ? (int)$row['age'] : null,
    'gender' => $row['gender'] !== null ? htmlspecialchars($row['gender']) : '',
    'weight' => $row['weight'] !== null ? (float)$row['weight'] : null,
    'height' => $row['height'] !== null ? (float)$row['height'] : null
);
    }

    echo json_encode(['success' => true, 'users' => $users]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Exception: ' . $e->getMessage()
    ]);
} finally {
    $conn->close();
}
?>
