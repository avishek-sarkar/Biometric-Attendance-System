<?php
session_start();
require_once '../config/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resend Verification Email</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../public/css/navbar_footer.css" rel="stylesheet">
    <link href="../public/css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-container">
                        <div class="text-center mb-4">
                            <i class="fas fa-envelope fingerprint-logo"></i>
                            <h2>Resend Verification Email</h2>
                        </div>

                        <?php if(isset($_SESSION['status'])): ?>
                            <div class="alert alert-info alert-dismissible fade show">
                                <?= htmlspecialchars($_SESSION['status']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['status']); ?>
                        <?php endif; ?>

                        <form id="resendForm" action="../controllers/resend_code.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                                <div class="error-message" id="emailError"></div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <p>
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

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/navbar_footer.js"></script>
    <script>
        document.getElementById('resendForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            
            emailError.textContent = '';
            
            try {
                const formData = new FormData(e.target);
                const response = await fetch('../controllers/resend_code.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    emailError.textContent = data.message;
                }
            } catch (error) {
                console.error('Error:', error);
                emailError.textContent = 'An error occurred. Please try again.';
            }
        });
    </script>
</body>
</html>