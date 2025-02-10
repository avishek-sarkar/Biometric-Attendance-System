<?php
// transfer_data.php
session_start();
require_once '../config/db_config.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $fingerId = $data['fingerId'] ?? 0;

    if ($fingerId <= 0) {
        throw new Exception('Invalid finger ID');
    }

    // Begin transaction
    $conn->begin_transaction();

    // Get data from temp_registrations
    $stmt = $conn->prepare("SELECT name, roll, reg, session, email, phone, password, verification_token FROM temp_registrations ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $tempData = $result->fetch_assoc();

    if (!$tempData) {
        throw new Exception('No temporary registration data found');
    }

    // Insert into students table
    $stmt = $conn->prepare("INSERT INTO student_info (student_name, student_roll, student_reg, student_session, student_email, student_phone, password, fingerId) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", 
        $tempData['name'],
        $tempData['roll'],
        $tempData['reg'],
        $tempData['session'],
        $tempData['email'],
        $tempData['phone'],
        $tempData['password'],
        $fingerId
    );

    if (!$stmt->execute()) {
        throw new Exception('Failed to insert data into students table');
    }

    // Delete from temp_registrations
    $stmt = $conn->prepare("DELETE FROM temp_registrations ORDER BY id DESC LIMIT 1");
    if (!$stmt->execute()) {
        throw new Exception('Failed to delete temporary registration data');
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Rollback transaction on error
    if ($conn->connect_errno === 0) {
        $conn->rollback();
    }
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>