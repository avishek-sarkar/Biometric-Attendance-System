<?php
session_start();
require_once '../config/db_config.php';

// Validate token and email
if (!isset($_GET['token']) || !isset($_GET['email'])) {
    $_SESSION['status'] = "Invalid reset link";
    header('Location: forgot_password.php');
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
    <title>Change Password - JKKNIU Attendance System</title>
    
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
                            <h4 class="mb-0">Change Password</h4>
                        </div>
                        <div class="card-body">
                            <?php if(isset($_SESSION['status'])): ?>
                                <div class="alert alert-info alert-dismissible fade show">
                                    <?= htmlspecialchars($_SESSION['status']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <?php unset($_SESSION['status']); ?>
                            <?php endif; ?>

                            <form action="../controllers/password_reset_code.php" method="POST">
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
    </script>
</body>
</html>