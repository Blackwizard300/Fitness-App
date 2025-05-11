<?php
session_start();
include './db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $firstname, $lastname, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION["user_id"] = $id;
        $_SESSION["user_name"] = $firstname.' '. $lastname;
        header("Location: homepage.php"); // Redirect to dashboard
        exit();
    } else {
        echo "Invalid email or password!";
    }

    $stmt->close();
}
$conn->close();
?>
