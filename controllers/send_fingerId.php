<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendancesystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the fingerprint ID from the POST request
if (isset($_POST['fingerprint_id'])) {
    $fingerprint_id = intval($_POST['fingerprint_id']);

    // Update the fingerprint ID in the database where id = 1
    $sql = "UPDATE fingerprint_DATA SET lastFingerId = $fingerprint_id WHERE id = 1";
    if ($conn->query($sql) === TRUE) {
        echo "Fingerprint ID $fingerprint_id updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No fingerprint ID received";
}

$conn->close();
?>