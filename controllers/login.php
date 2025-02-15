<?php
session_start();
require_once '../config/db_config.php';

try {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        throw new Exception('Email and password are required');
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if email exists in student_info table
    $stmt = $conn->prepare("SELECT * FROM student_info WHERE student_email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['authenticated'] = true;
            $_SESSION['auth_user'] = [
                'student_id' => $user['id'],
                'student_name' => $user['student_name'],
                'student_roll' => $user['student_roll'],
                'student_reg' => $user['student_reg'],
                'student_session' => $user['student_session'],
                'student_email' => $user['student_email'],
                'student_phone' => $user['student_phone'],
                'fingerId' => $user['fingerId'],
                'role' => 'student'
            ];

            // Redirect to student dashboard
            header('Location: /Biometric-Attendance-System/views/student_dashboard.php');
            exit();
        } else {
            echo "<html><body><script>alert('Invalid password'); window.history.back();</script></body></html>";
        }
    } else {
        echo "<html><body><script>alert('Invalid email or account not found'); window.history.back();</script></body></html>";
    }

} catch (Exception $e) {
    echo "<html><body><script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script></body></html>";
}

// Close connections
if (isset($stmt)) $stmt->close();
$conn->close();
?>