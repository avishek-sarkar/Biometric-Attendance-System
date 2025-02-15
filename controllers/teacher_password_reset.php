<?php
session_start();
require_once '../config/db_config.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['password_reset_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = bin2hex(random_bytes(32));

    // Check if email exists in teacher_info
    $check_email = "SELECT name, teacher_email FROM teacher_info WHERE teacher_email=? LIMIT 1";
    $stmt = $conn->prepare($check_email);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jkkniubioattendance@gmail.com';
            $mail->Password = 'tddb ebgx mior ptao';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('jkkniubioattendance@gmail.com', 'JKKNIU Attendance System');
            $mail->addAddress($email, $user['name']);

            $mail->isHTML(true);
            $mail->Subject = 'Forgot Your Password - Teacher';
            $mail->Body = "
                <h2>Password Reset Request</h2>
                <p>Dear {$user['name']},</p>
                <p>Click the link below to reset your password:</p>
                <a href='http://localhost:81/Biometric-Attendance-System/views/teacher_password_change.php?token=$token&email=$email' 
                   style='display: inline-block; background-color: #4ecca3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
                    Reset Password
                </a>
                <p>This link will expire in 1 hour.</p>
            ";

            $mail->send();
            $_SESSION['status'] = "Password reset link sent to your email";
        } catch (Exception $e) {
            $_SESSION['status'] = "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['status'] = "No account found with this email";
    }
    
    header("Location: ../views/teacher_forgot_password.php");
    exit();
}

if(isset($_POST['password_update_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    if($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $update_password = "UPDATE teacher_info SET password=? WHERE teacher_email=?";
        $stmt = $conn->prepare($update_password);
        $stmt->bind_param('ss', $hashed_password, $email);
        
        if($stmt->execute()) {
            $_SESSION['status'] = "Password updated successfully";
            header("Location: ../views/login_form.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Passwords do not match";
        header("Location: ../views/teacher_password_change.php?token=$token&email=$email");
        exit();
    }
}
?>