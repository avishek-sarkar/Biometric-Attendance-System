<?php
session_start();
require_once '../config/db_config.php';

// Validate token and email
if (!isset($_GET['token']) || !isset($_GET['email'])) {
    $_SESSION['status'] = "Invalid reset link";
    header('Location: teacher_forgot_password.php');
    exit();
}

$token = $_GET['token'];
$email = $_GET['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Teacher - JKKNIU Attendance System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="../public/css/navbar_footer.css" rel="stylesheet">
    <link href="../public/css/styles.css" rel="stylesheet">
</head>
<body>
    <div id="navbar-placeholder"></div>

    <div class="main-content container-fluid">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Change Password - Teacher</h4>
                        </div>
                        <div class="card-body">
                            <?php if(isset($_SESSION['status'])): ?>
                                <div class="alert alert-info alert-dismissible fade show">
                                    <?= htmlspecialchars($_SESSION['status']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <?php unset($_SESSION['status']); ?>
                            <?php endif; ?>

                            <form action="../controllers/teacher_password_reset.php" method="POST">
                                <input type="hidden" name="password_token" value="<?= htmlspecialchars($token) ?>">
                                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

                                <div class="form-group mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="error-message" id="passwordError"></div>
                                    <div class="password-requirements">
                                        Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters.
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="error-message" id="confirmPasswordError"></div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" name="password_update_btn" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Password
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <p>Remember your password? 
                                        <a href="login_form.php" class="text-decoration-none">
                                            <i class="fas fa-arrow-left me-1"></i>Back to Login
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="footer-placeholder"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/navbar_footer.js"></script>
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

        // Password validation
        function validatePassword(password) {
            const errors = [];
            
            if (password.length < 8) {
                errors.push("Password must be at least 8 characters long");
            }
            if (!/[A-Z]/.test(password)) {
                errors.push("Password must contain at least one uppercase letter");
            }
            if (!/[a-z]/.test(password)) {
                errors.push("Password must contain at least one lowercase letter");
            }
            if (!/\d/.test(password)) {
                errors.push("Password must contain at least one number");
            }
            if (!/[!@#$%^&*]/.test(password)) {
                errors.push("Password must contain at least one special character (!@#$%^&*)");
            }
            
            return errors;
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            let hasError = false;

            // Clear previous errors
            passwordError.textContent = '';
            confirmPasswordError.textContent = '';
            newPassword.classList.remove('is-invalid', 'is-valid');
            confirmPassword.classList.remove('is-invalid', 'is-valid');

            // Validate new password
            const passwordErrors = validatePassword(newPassword.value);
            if (passwordErrors.length > 0) {
                passwordError.textContent = passwordErrors[0];
                newPassword.classList.add('is-invalid');
                hasError = true;
            } else {
                newPassword.classList.add('is-valid');
            }

            // Validate password match
            if (newPassword.value !== confirmPassword.value) {
                confirmPasswordError.textContent = 'Passwords do not match';
                confirmPassword.classList.add('is-invalid');
                hasError = true;
            } else if (!hasError) {
                confirmPassword.classList.add('is-valid');
            }

            if (hasError) {
                e.preventDefault();
            }
        });

        // Real-time password validation
        document.getElementById('new_password').addEventListener('input', function() {
            const passwordError = document.getElementById('passwordError');
            const errors = validatePassword(this.value);
            
            if (errors.length > 0) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                passwordError.textContent = errors[0];
            } else {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
                passwordError.textContent = '';
            }
        });

        // Real-time confirm password validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const newPassword = document.getElementById('new_password').value;
            
            if (this.value !== newPassword) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                confirmPasswordError.textContent = 'Passwords do not match';
            } else {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
                confirmPasswordError.textContent = '';
            }
        });
    </script>
</body>
</html>