<?php
include('../core/authentication.php');

// Verify if user is a teacher
if ($_SESSION['auth_user']['role'] !== 'teacher') {
    $_SESSION['status'] = "Unauthorized access";
    header('Location: ../views/login_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course - JKKNIU Attendance System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../public/css/navbar_footer.css" rel="stylesheet">
    <style>
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .course-icon {
            font-size: 3rem;
            color: #4CAF50;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
            border-color: #4CAF50;
        }

        .btn-submit {
            background-color: #4CAF50;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-container">
                        <div class="text-center mb-4">
                            <i class="fas fa-book-open course-icon"></i>
                            <h2>Create New Course</h2>
                            <p class="text-muted">Enter the course details below</p>
                        </div>

                        <?php if(isset($_SESSION['status'])): ?>
                            <div class="alert alert-info alert-dismissible fade show mb-4">
                                <?= htmlspecialchars($_SESSION['status']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['status']); ?>
                        <?php endif; ?>

                        <form action="../controllers/add_course.php" method="POST">
                            <div class="mb-4">
                                <label for="course_code" class="form-label">Course Code</label>
                                <input type="text" class="form-control" id="course_code" name="course_code" required 
                                       placeholder="Enter course code (e.g., CSE-307)">
                                <div class="error-message" id="courseCodeError"></div>
                            </div>

                            <div class="mb-4">
                                <label for="course_name" class="form-label">Course Name</label>
                                <input type="text" class="form-control" id="course_name" name="course_name" required
                                       placeholder="Enter course name">
                                <div class="error-message" id="courseNameError"></div>
                            </div>

                            <div class="mb-4">
                                <label for="session" class="form-label">Session</label>
                                <select class="form-control" id="session" name="session" required>
                                    <option value="">Select Session</option>
                                    <option value="2023-24">2020-21</option>
                                    <option value="2023-24">2021-22</option>
                                    <option value="2023-24">2023-24</option>
                                    <option value="2024-25">2024-25</option>
                                    <option value="2025-26">2025-26</option>
                                </select>
                                <div class="error-message" id="sessionError"></div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-submit rounded-pill">
                                    <i class="fas fa-plus-circle me-2"></i>Create Course
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../includes/footer.php'); ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/navbar_footer.js"></script>
</body>
</html>