<?php
require_once '../config/db_config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = $conn->prepare("SELECT * FROM temp_registrations WHERE verification_token = ? AND is_verified = 0");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $update_stmt = $conn->prepare("UPDATE temp_registrations SET is_verified = 1 WHERE verification_token = ?");
        $update_stmt->bind_param('s', $token);
        $update_stmt->execute();
        
        $status_stmt = $conn->prepare("UPDATE fingerprint_data SET status = 1 WHERE id = 1");
        $status_stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Success</title>
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

        .verification-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
            animation: containerFadeIn 0.6s ease-out;
        }

        @keyframes containerFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .check-circle {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            position: relative;
        }

        .circle {
            stroke-dasharray: 300;
            stroke-dashoffset: 300;
            transform-origin: 50% 50%;
            animation: circleDraw 1.2s ease-out forwards;
        }

        .check {
            stroke-dasharray: 85;
            stroke-dashoffset: 85;
            animation: checkDraw 0.8s ease-out 0.5s forwards;
        }

        @keyframes circleDraw {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes checkDraw {
            to {
                stroke-dashoffset: 0;
            }
        }

        h2 {
            color: #2ecc71;
            margin-bottom: 1rem;
            opacity: 0;
            animation: textFadeIn 0.5s ease-out 1s forwards;
        }

        .message {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0;
            animation: textFadeIn 0.5s ease-out 1.3s forwards;
        }

        @keyframes textFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-stars {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .star {
            position: absolute;
            animation: starBurst 0.8s ease-out forwards;
            opacity: 0;
        }

        @keyframes starBurst {
            0% {
                transform: scale(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: scale(1) rotate(180deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="check-circle">
            <svg viewBox="0 0 100 100" width="100%" height="100%">
                <circle class="circle" cx="50" cy="50" r="46" 
                        fill="none" stroke="#2ecc71" stroke-width="4"/>
                <path class="check" d="M25,50 L45,70 L75,35" 
                      fill="none" stroke="#2ecc71" stroke-width="5" 
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2>Email Verified Successfully!</h2>
        <p class="message">Your email has been verified. You may now close this window.</p>
    </div>

    <script>
        function createStars() {
            const container = document.querySelector('.verification-container');
            const starsContainer = document.createElement('div');
            starsContainer.className = 'success-stars';
            
            for (let i = 0; i < 12; i++) {
                const delay = Math.random() * 0.5;
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = '50%';
                star.style.top = '50%';
                star.style.width = '10px';
                star.style.height = '10px';
                star.style.backgroundColor = '#2ecc71';
                star.style.borderRadius = '50%';
                star.style.transform = `translate(-50%, -50%) rotate(${i * 30}deg) translateY(-50px)`;
                star.style.animation = `starBurst 0.8s ease-out ${delay}s forwards`;
                
                starsContainer.appendChild(star);
            }
            
            container.appendChild(starsContainer);
        }

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(createStars, 1000);
        });
    </script>
</body>
</html>
<?php
    } else {
        echo '<div style="text-align: center; padding: 20px; color: #e74c3c;">Invalid or expired verification token.</div>';
    }
    $stmt->close();
} else {
    echo '<div style="text-align: center; padding: 20px; color: #e74c3c;">No verification token provided.</div>';
}
?>