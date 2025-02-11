<?php 
session_start();

if (isset($_SESSION['authenticated'])) {
  $_SESSION['status'] = "You are already logged in.";
  header('Location: /Biometric-Attendance-System/views/dashboard.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - JKKNIU Attendance System</title>
  
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
            <!-- <?php if(isset($_SESSION['status'])) : ?>
              <div class="alert alert-warning alert-dismissible fade show">
                  <?= $_SESSION['status']; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  <?php unset($_SESSION['status']); ?>
              </div>
            <?php endif; ?> -->

            <div class="form-container">
              <div class="text-center mb-4">
                <i class="fas fa-fingerprint fingerprint-logo"></i>
                <h2>Login</h2>
              </div>

              <form id="loginForm" action="../controllers/login.php" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control" required>
                  </div>
                  <div class="error-message" id="emailError"></div>
                </div>
                
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                  <div class="error-message" id="passwordError"></div>
                </div>
                
                <div class="d-grid gap-2 mb-3">
                  <button type="submit" name="login_btn" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
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
            <!-- Add login validation script -->
            <script src="../public/js/login_validation.js"></script>
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