<?php
session_start();
require_once '../config/db_config.php';

// Get verification token from URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    header('Location: teacher_register.php');
    exit();
}

// Check if token exists in database
$check_stmt = $conn->prepare("SELECT is_verified FROM teacher_info WHERE verification_token = ?");
$check_stmt->bind_param('s', $token);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['status'] = "Invalid verification token";
    header('Location: teacher_register.php');
    exit();
}

$row = $result->fetch_assoc();
if ($row['is_verified']) {
    // Already verified, redirect to login
    header('Location: login_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Status - Teacher</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #C6E7FF, #D4F6FF, #FBFBFB, #FFDDAE);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verification-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .icon {
            width: 100px;
            height: 100px;
            margin-bottom: 1.5rem;
            color: #4ecca3;
        }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #4ecca3;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 1rem auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .success-content {
            opacity: 0;
            display: none;
            transition: opacity 0.5s ease-in-out;
        }
        .success-content.show {
            opacity: 1;
            display: block;
        }
        .btn-login {
            margin-top: 2rem;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            background-color: #4ecca3;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #45b393;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <!-- Pending Verification Content -->
        <div id="pendingContent">
            <svg class="icon" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
            </svg>
            <h2 class="mb-3">Email Verification Pending</h2>
            <p class="text-muted">Please check your email and click the verification link.</p>
            <div class="loading-spinner"></div>
            <p class="text-muted mt-3">Checking verification status...</p>
        </div>

        <!-- Success Content -->
        <div id="successContent" class="success-content">
            <svg class="icon" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <h2 class="text-success mb-3">Email Verified!</h2>
            <p class="mb-4">Your email has been successfully verified. You can now proceed to login.</p>
            <a href="login_form.php" class="btn btn-login btn-primary">Proceed to Login</a>
        </div>
    </div>

    <script>
        async function checkStatus() {
            try {
                const response = await fetch(`../controllers/check_teacher_verification.php?token=<?php echo $token; ?>`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();
                
                if (data.verified) {
                    window.location.href = 'login_form.php';
                } else {
                    // Check if we should continue polling
                    const elapsedTime = Date.now() - window.startTime;
                    if (elapsedTime < 300000) { // 5 minutes timeout
                        setTimeout(checkStatus, 3000);
                    } else {
                        // Show timeout message
                        document.getElementById('pendingContent').innerHTML = `
                            <div class="alert alert-warning">
                                <h4>Verification Taking Too Long</h4>
                                <p>Please check your email and click the verification link, or try refreshing this page.</p>
                                <button onclick="window.location.reload()" class="btn btn-primary mt-3">
                                    Refresh Page
                                </button>
                            </div>
                        `;
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                setTimeout(checkStatus, 3000);
            }
        }

        // Initialize start time for timeout checking
        window.startTime = Date.now();
        
        // Start checking status when document is ready
        document.addEventListener('DOMContentLoaded', checkStatus);
    </script>
</body>
</html>