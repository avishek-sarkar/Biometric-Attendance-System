<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "attendancesystem";

// Get the finger_id from the POST request
if(isset($_POST['finger_id'])) {
    $finger_id = intval($_POST['finger_id']);
    
    // Create connection
    $conn = new mysqli($host, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT student_roll FROM student_info WHERE fingerId = ?");
    $stmt->bind_param("i", $finger_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        // Fetch the roll number
        $row = $result->fetch_assoc();
        $roll = $row['student_roll'];
        
        // Return the roll number
        echo $roll;
    } else {
        // No student found with this finger_id
        echo "NOT_FOUND";
    }
    
    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    // No finger_id provided
    echo "MISSING_PARAM";
}
?>