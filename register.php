<?php
include './db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Secure password
    $phone = trim($_POST["phone"]);

    // Validate inputs
    if (empty($firstname) || empty($lastname) || empty($email) || empty($_POST["password"]) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit();
    }

    // Validate phone number
    $phone = preg_replace('/\D/', '', $phone); // Remove non-digits
    if (strlen($phone) < 10) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid phone number.']);
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered.']);
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $phone);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'redirect' => 'login.html']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
    }
    $stmt->close();
}
$conn->close();
?>
