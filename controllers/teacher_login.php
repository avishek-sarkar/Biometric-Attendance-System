<?php
header('Content-Type: application/json');
session_start();
require_once '../config/db_config.php';

$response = ['success' => false, 'message' => '', 'redirect' => ''];

try {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        throw new Exception('Please fill in all fields');
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM teacher_info WHERE teacher_email = ? AND is_verified = 1 LIMIT 1");
    
    if (!$stmt) {
        throw new Exception("Database error occurred");
    }

    $stmt->bind_param("s", $email);
    
    if (!$stmt->execute()) {
        throw new Exception("Database error occurred");
    }

    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Email not found or not verified");
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['password'])) {
        throw new Exception("Invalid password");
    }

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

    $response = [
        'success' => true,
        'message' => 'Login successful',
        'redirect' => '../views/teacher_dashboard.php'
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