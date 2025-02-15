<?php
require_once '../config/db_config.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

try {
    if (empty($_POST['name']) || empty($_POST['designation']) || empty($_POST['department']) || 
        empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password'])) {
        throw new Exception('All fields are required');
    }

    $name = trim($_POST['name']);
    $designation = trim($_POST['designation']);
    $department = trim($_POST['department']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $verification_token = bin2hex(random_bytes(32));

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Begin transaction
    $conn->begin_transaction();

    // Insert into teacher_info
    $stmt = $conn->prepare("INSERT INTO teacher_info (name, designation, department, teacher_email, 
                           teacher_phone, password, verification_token) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }

    $stmt->bind_param('sssssss', 
        $name,
        $designation,
        $department,
        $email,
        $phone,
        $hashed_password,
        $verification_token
    );

    if (!$stmt->execute()) {
        throw new Exception("Database error: " . $stmt->error);
    }

    // Send verification email
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
    $mail->addAddress($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Verify Your Email - Teacher Registration';
    $mail->Body = "
    <h2>Email Verification - Teacher Registration</h2>
    <p>Dear $name,</p>
    <p>Thank you for registering as a teacher. Please click the link below to verify your email address:</p>
    <a href='http://localhost:81/Biometric-Attendance-System/views/teacher_verification.php?token=$verification_token' 
       style='display: inline-block; background-color: #4ecca3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
        Verify Email
    </a>
    <p>If you didn't register, please ignore this email.</p>";

    if (!$mail->send()) {
        throw new Exception('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
    }

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Registration successful! Please check your email for verification.',
        'redirect' => "../views/teacher_verification_pending.php?token=" . $verification_token
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($conn) && $conn->connect_errno === 0) {
        $conn->rollback();
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Close resources
if (isset($stmt)) $stmt->close();
if (isset($conn)) $conn->close();
?>