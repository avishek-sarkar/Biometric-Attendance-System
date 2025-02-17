<?php
require_once '../config/db_config.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

try {
    if (!isset($_POST['email']) || !isset($_POST['name'])) {
        throw new Exception('Required fields are missing');
    }

    $email = $_POST['email'];
    $name = $_POST['name'];
    $verification_token = bin2hex(random_bytes(32));

    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jkkniubioattendance@gmail.com';
    $mail->Password = 'tddb ebgx mior ptao';
    $mail->SMTPSecure = 'ssl';  // Changed from tls to ssl
    $mail->Port = 465;          // Changed from 587 to 465

    // Recipients
    $mail->setFrom('jkkniubioattendance@gmail.com', 'JKKNIU Attendance System');
    $mail->addAddress($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Verify Your Email';
    $mail->Body = "
    <h2>Email Verification</h2>
    <p>Dear $name,</p>
    <p>Please click the link below to verify your email address and complete your registration:</p>
    <a href='http://localhost/Biometric-Attendance-System/views/mail_verification.php?token=$verification_token' style='display: inline-block; background-color: #4ecca3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
        Verify Email
    </a>
    <p>If you didn't request this verification, please ignore this email.</p>
";

    if($mail->send()) {
        // Store token in temporary table
        $stmt = $conn->prepare("INSERT INTO temp_registrations (name, roll, reg, session, email, phone, password, verification_token) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            throw new Exception("Database prepare error: " . $conn->error);
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $stmt->bind_param('ssssssss', 
            $_POST['name'], 
            $_POST['roll'], 
            $_POST['reg'], 
            $_POST['session'], 
            $_POST['email'], 
            $_POST['phone'], 
            $hashedPassword,
            $verification_token
        );

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true, 
                'message' => 'Verification email sent successfully',
                'token' => $verification_token,
                'redirect' => "../views/verification_pending.php?token=" . $verification_token
            ]);
        }
           else {
            throw new Exception("Database error: " . $stmt->error);
        }

        
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => "Error: " . $e->getMessage()
    ]);
}
?>