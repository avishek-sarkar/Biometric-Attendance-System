<?php
session_start();
require_once '../config/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - JKKNIU Attendance System</title>
    
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
                            <h4 class="mb-0">Reset Password</h4>
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
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Enter Your Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" name="password_reset_btn" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Send Reset Link
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
</body>
</html>