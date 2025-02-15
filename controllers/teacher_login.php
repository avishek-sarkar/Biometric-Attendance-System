<?php
session_start();
require_once '../config/db_config.php';

try {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        throw new Exception('Email and password are required');
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if email exists in teacher_info table
    $stmt = $conn->prepare("SELECT * FROM teacher_info WHERE teacher_email = ? AND is_verified = 1 LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['authenticated'] = true;
            $_SESSION['auth_user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'designation' => $user['designation'],
                'department' => $user['department'],
                'email' => $user['teacher_email'],
                'phone' => $user['teacher_phone'],
                'role' => 'teacher'
            ];

            // Redirect to teacher dashboard
            header('Location: /Biometric-Attendance-System/views/teacher_dashboard.php');
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