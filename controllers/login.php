<?php
header('Content-Type: application/json');
session_start();
require_once '../config/db_config.php';

$response = ['success' => false, 'message' => '', 'redirect' => ''];

try {
    // Check if fields are empty
    if (empty($_POST['email']) || empty($_POST['password'])) {
        throw new Exception('Please fill in all fields');
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // First check if email exists
    $stmt = $conn->prepare("SELECT id, student_name, student_roll, student_reg, student_session, 
                                  student_email, student_phone, password, fingerId 
                           FROM student_info 
                           WHERE student_email = ? 
                           LIMIT 1");

    if (!$stmt) {
        throw new Exception("Database error occurred");
    }

    $stmt->bind_param("s", $email);
    
    if (!$stmt->execute()) {
        throw new Exception("Database error occurred");
    }

    $result = $stmt->get_result();
    
    // First error check - Email existence
    if ($result->num_rows === 0) {
        throw new Exception("Email not found. Please register first");
    }

    $user = $result->fetch_assoc();

    // Second error check - Password verification
    if (!password_verify($password, $user['password'])) {
        $_SESSION['last_email'] = $email; // Store email for next attempt
        throw new Exception("Invalid password. Please try again");
    }

    // Clear any stored email on successful login
    unset($_SESSION['last_email']);

    // Set session variables on successful login
    $_SESSION['authenticated'] = true;
    $_SESSION['auth_user'] = [
        'id' => $user['id'],
        'student_name' => $user['student_name'],
        'student_roll' => $user['student_roll'],
        'student_reg' => $user['student_reg'],
        'student_session' => $user['student_session'],
        'student_email' => $user['student_email'],
        'student_phone' => $user['student_phone'],
        'fingerId' => $user['fingerId'],
        'role' => 'student'
    ];

    $response = [
        'success' => true,
        'message' => 'Login successful',
        'redirect' => '/Biometric-Attendance-System/views/student_dashboard.php'
    ];

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
}


echo json_encode($response);
?>