<?php
session_start();
?>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <span class="navbar-brand">Attendance Management System</span>
        <div class="ms-auto d-flex align-items-center">
            <div class="nav-options">
                <a class="nav-link" href="/Biometric-Attendance-System/index.php">Home</a>
                <?php if (!isset($_SESSION['authenticated'])) : ?>
                    <a class="nav-link" href="/Biometric-Attendance-System/views/registerForm.html">Student</a>
                    <a class="nav-link" href="/Biometric-Attendance-System/views/teacher_register.php">Teacher</a>
                    <a class="nav-link" href="/Biometric-Attendance-System/views/login_form.php">Login</a>
                <?php else : ?>
                    <a class="nav-link" href="/Biometric-Attendance-System/views/dashboard.php">Dashboard</a>
                    <a class="nav-link" href="/Biometric-Attendance-System/controllers/logout.php">Logout</a>
                <?php endif; ?>
            </div>
            <span class="mobile-icon" id="navIcon">
                <i class="fas fa-bars"></i>
            </span>
        </div>
    </div>
</nav>

<div id="sidePanel">
    <a href="/Biometric-Attendance-System/index.php">Home</a>
    <?php if (!isset($_SESSION['authenticated'])) : ?>
        <a href="/Biometric-Attendance-System/views/registerForm.html">Student</a>
        <a href="/Biometric-Attendance-System/views/teacher_register.php">Teacher</a>
        <a href="/Biometric-Attendance-System/views/login_form.php">Login</a>
    <?php else : ?>
        <a href="/Biometric-Attendance-System/views/dashboard.php">Dashboard</a>
        <a href="/Biometric-Attendance-System/controllers/logout.php">Logout</a>
    <?php endif; ?>
</div>