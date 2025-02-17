<?php
// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendancesystem";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'error' => 'Connection failed: ' . $conn->connect_error
    ]));
}

// Set character set
$conn->set_charset("utf8mb4");

// Fetch status from fingerprint_data table
$sql = "SELECT status FROM fingerprint_data WHERE id = 1";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    echo $row['status'];  // Just return the status value directly
} else {
    echo "error";
}

$conn->close();
?>