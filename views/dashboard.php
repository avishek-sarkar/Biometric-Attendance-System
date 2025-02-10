<?php
include('../core/authentication.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JKKNIU Attendance System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../public/css/navbar_footer.css" rel="stylesheet">
    <link href="../public/css/styles.css" rel="stylesheet">
    <link href="../public/css/dashboard.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <div class="container py-4">
            <!-- Status Messages -->
            <?php if(isset($_SESSION['status'])) : ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['status']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['status']); ?>
            <?php endif; ?>

            <!-- Dashboard Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="dashboard-header p-4 rounded">
                        <h2 class="mb-0">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Student Dashboard
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Student Information Card -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card student-profile">
                        <div class="card-body text-center">
                            <div class="profile-icon mb-3">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h3 class="card-title"><?= htmlspecialchars($_SESSION['auth_user']['student_name']); ?></h3>
                            <p class="text-muted mb-1">Roll: <?= htmlspecialchars($_SESSION['auth_user']['student_roll']); ?></p>
                            <p class="text-muted mb-1">Reg: <?= htmlspecialchars($_SESSION['auth_user']['student_reg']); ?></p>
                            <p class="text-muted">Session: <?= htmlspecialchars($_SESSION['auth_user']['student_session']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Contact Information</h4>
                            <div class="contact-info">
                                <p>
                                    <i class="fas fa-envelope me-2"></i>
                                    Email: <?= htmlspecialchars($_SESSION['auth_user']['student_email']); ?>
                                </p>
                                <p>
                                    <i class="fas fa-phone me-2"></i>
                                    Phone: <?= htmlspecialchars($_SESSION['auth_user']['student_phone']); ?>
                                </p>
                                <p>
                                    <i class="fas fa-fingerprint me-2"></i>
                                    Fingerprint ID: <?= htmlspecialchars($_SESSION['auth_user']['fingerId']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Statistics -->
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Classes</h5>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt stat-icon"></i>
                                <h3 class="mb-0 ms-3">120</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h5 class="card-title">Present</h5>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle stat-icon text-success"></i>
                                <h3 class="mb-0 ms-3">98</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h5 class="card-title">Absent</h5>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-times-circle stat-icon text-danger"></i>
                                <h3 class="mb-0 ms-3">22</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h5 class="card-title">Attendance Rate</h5>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-chart-line stat-icon text-primary"></i>
                                <h3 class="mb-0 ms-3">82%</h3>
                            </div>
                        </div>
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
</body>
</html>