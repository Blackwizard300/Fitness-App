<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "sql202.infinityfree.com";
$username = "if0_38995328"; // ✅ Correct username
$password = "uc6nOE5fPU6njG"; // ✅ Replace this with the real password
$dbname = "if0_38995328_fitness";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
