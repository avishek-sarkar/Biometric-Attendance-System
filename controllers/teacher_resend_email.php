<?php
require_once '../config/db_config.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

try {
    if (!isset($_POST['email'])) {
        throw new Exception('Email address is required');
    }

    $email = trim($_POST['email']);

    // Check if email exists in teacher_info and is not verified
    $check_stmt = $conn->prepare("SELECT * FROM teacher_info WHERE teacher_email = ? AND is_verified = 0");
    $check_stmt->bind_param('s', $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception('This email is either not registered or already verified');
    }

    $user = $result->fetch_assoc();
    $verification_token = bin2hex(random_bytes(32));

    // Update verification token
    $update_stmt = $conn->prepare("UPDATE teacher_info SET verification_token = ? WHERE teacher_email = ?");
    $update_stmt->bind_param('ss', $verification_token, $email);
    $update_stmt->execute();

    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jkkniubioattendance@gmail.com';
    $mail->Password = 'tddb ebgx mior ptao';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Recipients
    $mail->setFrom('jkkniubioattendance@gmail.com', 'JKKNIU Attendance System');
    $mail->addAddress($email, $user['name']);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Resend - Verify Your Email - Teacher';
    $mail->Body = "
    <h2>Email Verification - Teacher</h2>
    <p>Dear {$user['name']},</p>
    <p>Please click the link below to verify your email address:</p>
    <a href='http://localhost:81/Biometric-Attendance-System/views/teacher_verification.php?token=$verification_token' 
       style='display: inline-block; background-color: #4ecca3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
        Verify Email
    </a>
    <p>If you didn't request this verification, please ignore this email.</p>";

    $mail->send();
    
    echo json_encode([
        'success' => true,
        'message' => 'Verification email sent successfully',
        'redirect' => "../views/teacher_verification_pending.php?token=" . $verification_token
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Close database connection
if (isset($check_stmt)) $check_stmt->close();
if (isset($update_stmt)) $update_stmt->close();
$conn->close();
?>