<?php 
session_start();

if (isset($_SESSION['authenticated'])) {
    if ($_SESSION['auth_user']['role'] === 'teacher') {
        header('Location: /Biometric-Attendance-System/views/teacher_dashboard.php');
    } else {
        header('Location: /Biometric-Attendance-System/views/student_dashboard.php');
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JKKNIU Attendance System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="../public/css/navbar_footer.css" rel="stylesheet">
    
    <style>
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .login-divider {
            border-right: 2px solid #e0e0e0;
        }
        @media (max-width: 767.98px) {
            .login-divider {
                border-right: none;
                border-bottom: 2px solid #e0e0e0;
                margin-bottom: 2rem;
                padding-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <div id="navbar-placeholder"></div>

    <div class="main-content container-fluid py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h1 class="display-5">Welcome Back!</h1>
                <p class="lead">Choose your login type below</p>
            </div>

            <div class="row justify-content-center">
                <!-- Student Login Form -->
                <div class="col-md-5">
                    <div class="form-container h-100">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                            <h3>Student Login</h3>
                        </div>
                        <form id="studentLoginForm" action="../controllers/login.php" method="POST">
                            <input type="hidden" name="user_type" value="student">
                            <div class="mb-3">
                                <label for="studentEmail" class="form-label">Student Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" id="studentEmail" class="form-control" required>
                                </div>
                                <div class="error-message" id="studentEmailError"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="studentPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="studentPassword" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('studentPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="error-message" id="studentPasswordError"></div>
                            </div>
                            
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login as Student
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-2">
                                    <a href="forgot_password.php" class="text-decoration-none">
                                        <i class="fas fa-key me-1"></i>Forgot Password?
                                    </a>
                                </p>
                                <p>
                                    <a href="resend_verification.php" class="text-decoration-none">
                                        <i class="fas fa-envelope me-1"></i>Resend Verification Email
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Teacher Login Form -->
                <div class="col-md-5">
                    <div class="form-container h-100">
                        <div class="text-center mb-4">
                            <i class="fas fa-chalkboard-teacher fa-3x text-primary mb-3"></i>
                            <h3>Teacher Login</h3>
                        </div>
                        <form id="teacherLoginForm" action="../controllers/teacher_login.php" method="POST">
                            <input type="hidden" name="user_type" value="teacher">
                            <div class="mb-3">
                                <label for="teacherEmail" class="form-label">Teacher Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" id="teacherEmail" class="form-control" required>
                                </div>
                                <div class="error-message" id="teacherEmailError"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="teacherPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="teacherPassword" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('teacherPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="error-message" id="teacherPasswordError"></div>
                            </div>
                            
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login as Teacher
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-2">
                                    <a href="teacher_forgot_password.php" class="text-decoration-none">
                                        <i class="fas fa-key me-1"></i>Forgot Password?
                                    </a>
                                </p>
                                <p>
                                    <a href="teacher_resend_verification.php" class="text-decoration-none">
                                        <i class="fas fa-envelope me-1"></i>Resend Verification Email
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/navbar_footer.js"></script>
    <!-- <script src="../public/js/login_validation.js"></script> -->
    
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>