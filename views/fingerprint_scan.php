<?php
session_start();
require_once '../config/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fingerprint Registration</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #C6E7FF, #D4F6FF, #FBFBFB, #FFDDAE);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .scan-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        .scan-area {
            width: 200px;
            height: 200px;
            margin: 20px auto;
            position: relative;
            border-radius: 50%;
            background: #f5f5f5;
            overflow: hidden;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .fingerprint {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            opacity: 0.7;
        }

        .scan-line {
            position: absolute;
            top: 0;
            left: -10%;
            width: 120%;
            height: 4px;
            background: linear-gradient(90deg, 
                transparent 0%,
                #4CAF50 20%,
                #4CAF50 80%,
                transparent 100%
            );
            animation: scanLine 2s ease-in-out infinite;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.5);
        }

        .scan-ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 3px solid #4CAF50;
            border-radius: 50%;
            opacity: 0;
            animation: scanRing 2s ease-out infinite;
        }

        @keyframes scanLine {
            0% {
                top: -5%;
                opacity: 0;
            }
            20% {
                opacity: 1;
            }
            80% {
                opacity: 1;
            }
            100% {
                top: 105%;
                opacity: 0;
            }
        }

        @keyframes scanRing {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        .success-content {
            display: none;
        }

        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            animation: checkmark 0.8s ease-in-out forwards;
            opacity: 0;
        }

        @keyframes checkmark {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .btn-login {
            background-color: #4CAF50;
            border-color: #4CAF50;
            padding: 12px 35px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .btn-login:hover {
            background-color: #45a049;
            border-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
        }

        .status-text {
            color: #666;
            margin: 1rem 0;
            font-size: 1.1rem;
        }

        .processing-text {
            color: #4CAF50;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="scan-container">
        <div id="scanContent">
            <h2 class="mb-4">Fingerprint Registration</h2>
            <p class="text-muted mb-4">Please place your finger on the scanner</p>
            
            <div class="scan-area">
                <svg class="fingerprint" viewBox="0 0 512 512">
                    <path fill="#555" d="M256,106.67c-49.69,0-90.67,40.98-90.67,90.67c0,23.47,9.01,44.85,23.75,60.87 c2.82,3.07,7.66,3.07,10.48,0c14.74-16.02,23.75-37.4,23.75-60.87c0-18.28,14.72-33,33-33s33,14.72,33,33 c0,52.87-43.13,96-96,96c-52.87,0-96-43.13-96-96c0-52.87,43.13-96,96-96c5.89,0,10.67-4.78,10.67-10.67S261.89,80,256,80 c-64.65,0-117.33,52.69-117.33,117.33c0,64.65,52.69,117.33,117.33,117.33s117.33-52.69,117.33-117.33 C373.33,147.65,320.65,106.67,256,106.67z M256,170.67c-23.47,0-42.67,19.2-42.67,42.67c0,23.47,19.2,42.67,42.67,42.67 s42.67-19.2,42.67-42.67C298.67,189.87,279.47,170.67,256,170.67z M256,234.67c-11.78,0-21.33-9.55-21.33-21.33 s9.55-21.33,21.33-21.33s21.33,9.55,21.33,21.33S267.78,234.67,256,234.67z"/>
                </svg>
                <div class="scan-line"></div>
                <div class="scan-ring"></div>
            </div>

            <p class="processing-text">Processing fingerprint...</p>
            <p class="status-text" id="statusText">Keep your finger steady until the scan is complete</p>
        </div>
        
        <div id="successContent" class="success-content">
            <div class="success-checkmark mb-4">
                <svg viewBox="0 0 52 52" width="100%" height="100%">
                    <circle cx="26" cy="26" r="25" fill="none" stroke="#4CAF50" stroke-width="2"/>
                    <path class="check" fill="none" stroke="#4CAF50" stroke-width="2" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
            <h2 class="text-success mb-3">Registration Complete!</h2>
            <p class="text-muted mb-4">Your fingerprint has been successfully registered.</p>
            <a href="login.php" class="btn btn-login btn-primary">Proceed to Login</a>
        </div>
    </div>

    <script>
        async function transferDataToStudents(lastFingerId) {
            try {
                const response = await fetch('../controllers/transfer_data.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ fingerId: lastFingerId })
                });
                const data = await response.json();
                if (!data.success) {
                    console.error('Failed to transfer data to students table');
                    return false;
                }
                return true;
            } catch (error) {
                console.error('Error transferring data:', error);
                return false;
            }
        }

        async function resetFingerprintStatus() {
            try {
                const response = await fetch('../controllers/reset_fingerprint.php');
                const data = await response.json();
                if (!data.success) {
                    console.error('Failed to reset fingerprint status');
                }
            } catch (error) {
                console.error('Error resetting fingerprint status:', error);
            }
        }

        async function updateFingerprintStatus() {
            try {
                const response = await fetch('../controllers/check_fingerprint_status.php');
                const data = await response.json();
                
                if (data.error) {
                    console.error('Error:', data.error);
                    return;
                }

                if (data.status === 1 && data.lastFingerId !== 0) {
                    // Transfer data to students table
                    const transferSuccess = await transferDataToStudents(data.lastFingerId);
                    
                    if (transferSuccess) {
                        // Show success message
                        document.getElementById('scanContent').style.display = 'none';
                        document.getElementById('successContent').style.display = 'block';
                        
                        // Reset fingerprint status
                        await resetFingerprintStatus();
                        return;
                    }
                }

                setTimeout(updateFingerprintStatus, 2000);
            } catch (error) {
                console.error('Error checking status:', error);
                setTimeout(updateFingerprintStatus, 2000);
            }
        }

        document.addEventListener('DOMContentLoaded', updateFingerprintStatus);
    </script>
</body>
</html>