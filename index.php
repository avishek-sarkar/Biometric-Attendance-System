<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="public/css/navbar_footer.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <div class="container-fluid text-center">
            <h1 class="display-5">Welcome to the</h1>
            <h1 class="display-5 mb-3"><b>Biometric Attendance Management System</b></h1>
            <p class="lead">Simplifying attendance tracking with secure biometric authentication.</p>
        </div>
        <div class="container-fluid text-center">
            <p class="h4 mt-5">Explore Your Options</p>
            <div class="row mt-1 g-4">
                <!-- Student Card -->
                <div class="col-12 col-md-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title mb-3"><b>Join as a Student today!</b></h6> 
                            <ul class=" text-start w-100 mb-3 mx-2 ps-6 pe-4">
                                <li class="pb-1">Quick and easy registration—just a few steps!</li>
                                <li class="pb-1">A smart and secure way to mark your presence</li>
                                <li>No more proxies or manual errors—just scan and go!</li>
                            </ul>
                            <div class="col-8 mx-auto d-flex justify-content-center">
                                <button class="btn btn-primary w-100 rounded-pill" onclick="location.href='views/registerForm.html'">Register as Student</button>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Teacher Card -->
                <div class="col-12 col-md-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title mb-3"><b>Easy attendance for Teachers!</b></h6> 
                            <ul class=" text-start w-100 mb-3 mx-2 ps-6 pe-4">
                                <li class="pb-1">A hassle-free way to track and verify attendance</li>
                                <li class="pb-1">Manage and monitor student attendance with ease</li>
                                <li>Reduce paperwork and just focus on teaching</li>
                            </ul>
                            <div class="col-8 mx-auto d-flex justify-content-center">
                                <button class="btn btn-primary w-100 rounded-pill" onclick="location.href='views/teacher-register.php'">Register as Teacher</button>
                            </div>  
                        </div>
                    </div>
                </div>
        
                <!-- Login Card -->
                <div class="col-12 col-md-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title mb-3"><b>Access your account now!</b></h6> 
                            <ul class=" text-start w-100 mb-3 mx-2 ps-6 pe-4">
                                <li class="pb-1">Quick and secure access to your dashboard</li>
                                <li class="pb-1">Keep track of attendance history anytime, anywhere!</li>
                                <li>Manage your attendance records with ease</li>
                            </ul>
                            <div class="col-8 mx-auto d-flex justify-content-center">
                                <button class="btn btn-primary w-100 rounded-pill" onclick="location.href='views/login.php'">Login</button>
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
    <script src="public/js/navbar_footer.js"></script>
</body>
</html>