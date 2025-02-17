<?php
// Database connection parameters
require_once '../config/db_config.php';
// Set Bangladesh timezone
date_default_timezone_set('Asia/Dhaka');

// Get current time in Bangladesh
$bangladesh_current_time = new DateTime();
$current_time_formatted = $bangladesh_current_time->format('Y-m-d H:i:s');

// Fetch data from fingerprint_data table
$sql = "SELECT id, start_time, scan_interval FROM fingerprint_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Attendance System Time Difference (Bangladesh Time)</h2>";
    echo "<p>Bangladesh Current Time: " . $current_time_formatted . "</p>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Start Time</th><th>Scan Interval</th><th>Time Difference (minutes)</th></tr>";
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $start_time = new DateTime($row["start_time"]);
        
        // Calculate the difference in minutes
        $time_diff = $bangladesh_current_time->getTimestamp() - $start_time->getTimestamp();
        $minutes_diff = round($time_diff / 60);
        
        // Calculate time since last scan based on scan interval
        $scan_interval_minutes = intval($row["scan_interval"]);
        $scans_completed = floor($minutes_diff / $scan_interval_minutes);
        $last_scan_time = clone $start_time;
        $last_scan_time->modify("+{$scans_completed} minutes");
        $minutes_since_last_scan = round(($bangladesh_current_time->getTimestamp() - $last_scan_time->getTimestamp()) / 60);
        
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["start_time"] . "</td>";
        echo "<td>" . $row["scan_interval"] . " minutes</td>";
        echo "<td>" . $minutes_diff . " minutes total<br>" . 
             $minutes_since_last_scan . " minutes since last scan</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

// Close connection
$conn->close();
?>