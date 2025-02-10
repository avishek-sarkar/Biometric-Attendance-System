<?php
session_start();
require_once '../config/db_config.php';

// Get verification token from URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    header('Location: registerForm.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Status</title>
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
        .success-checkmark {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
        }
        .success-checkmark .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #4ecca3;
        }
        .fingerprint-section {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-scan {
            background-color: #4ecca3;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-scan:hover {
            background-color: #45b393;
            transform: translateY(-2px);
        }
        .fingerprint-icon {
            width: 120px;
            height: 120px;
            margin: 1.5rem auto;
            color: #4ecca3;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .steps-container {
            text-align: left;
            margin: 2rem 0;
        }
        .step {
            margin-bottom: 1rem;
            padding: 1rem;
            background: rgba(78, 204, 163, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
        }
        .step-number {
            background: #4ecca3;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
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

        <!-- Success & Fingerprint Content -->
        <div id="successContent" class="success-content">
            <!-- Email Verification Success -->
            <div id="emailSuccess">
                <svg class="icon" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <h2 class="text-success mb-3">Email Verified!</h2>
                <p class="mb-4">Great! Your email has been successfully verified.</p>
                <button class="btn btn-scan btn-primary" onclick="showFingerprintSection()">
                    Continue to Fingerprint Registration
                </button>
            </div>

            <!-- Fingerprint Registration Section -->
            <div id="fingerprintSection" class="fingerprint-section">
                <svg class="fingerprint-icon" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41-.24.13-.54.04-.68-.2-.13-.24-.04-.55.2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52.25.13.34.43.21.67-.09.18-.26.28-.44.28zM3.5 9.72c-.1 0-.2-.03-.29-.09-.23-.16-.28-.47-.12-.7.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25.16.22.11.54-.12.7-.23.16-.54.11-.7-.12-.9-1.26-2.04-2.25-3.39-2.94-2.87-1.47-6.54-1.47-9.4.01-1.36.7-2.5 1.7-3.4 2.96-.08.14-.23.21-.39.21zm6.25 12.07c-.13 0-.26-.05-.35-.15-.87-.87-1.34-1.43-2.01-2.64-.69-1.23-1.05-2.73-1.05-4.34 0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39s-4.66 1.97-4.66 4.39c0 1.44.32 2.77.93 3.85.64 1.15 1.08 1.64 1.85 2.42.19.2.19.51 0 .71-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89-1.49-1.01-2.38-2.65-2.38-4.39 0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56.71.48 1.54.71 2.54.71.24 0 .64-.03 1.04-.1.27-.05.53.13.58.41.05.27-.13.53-.41.58-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02-1.59-.44-2.63-1.03-3.72-2.1-1.4-1.39-2.17-3.24-2.17-5.22 0-1.62 1.38-2.94 3.08-2.94s3.08 1.32 3.08 2.94c0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83-2.84 0-5.44 1.58-6.61 4.03-.39.81-.59 1.76-.59 2.8 0 .78.07 2.01.67 3.61.1.26-.03.55-.29.64-.26.1-.55-.04-.64-.29-.49-1.31-.73-2.61-.73-3.96 0-1.2.23-2.29.68-3.24 1.33-2.79 4.28-4.6 7.51-4.6 4.55 0 8.25 3.51 8.25 7.83 0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51.95.94 1.86 1.46 3.27 1.85.27.07.42.35.35.61-.05.23-.26.38-.47.38z"/>
                </svg>
                <h3 class="mb-4">Fingerprint Registration</h3>
                
                <div class="steps-container">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div>Place your finger on the scanner</div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div>Keep your finger steady during scanning</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div>Wait for the confirmation message</div>
                    </div>
                </div>

                <button class="btn btn-scan btn-primary" onclick="window.location.href='fingerprint_scan.php'">
                    Start Fingerprint Scan
                </button>
            </div>
        </div>
    </div>

    <script>
        function showFingerprintSection() {
            document.getElementById('emailSuccess').style.display = 'none';
            document.getElementById('fingerprintSection').style.display = 'block';
        }

        async function checkStatus() {
            try {
                const response = await fetch(`../controllers/check_verification.php?token=<?php echo $token; ?>`);
                const data = await response.json();
                
                if (data.verified) {
                    document.getElementById('pendingContent').style.display = 'none';
                    document.getElementById('successContent').classList.add('show');
                } else {
                    setTimeout(checkStatus, 3000);
                }
            } catch (error) {
                console.error('Error:', error);
                setTimeout(checkStatus, 3000);
            }
        }

        document.addEventListener('DOMContentLoaded', checkStatus);
    </script>
</body>
</html>