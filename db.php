<?php
$host = "localhost";
$username = "root";  // Change if necessary
$password = "";      // Change if necessary
$dbname = "fitness_app";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
