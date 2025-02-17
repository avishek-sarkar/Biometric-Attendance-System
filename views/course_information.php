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
    <title>Course Information - JKKNIU Attendance System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../public/css/navbar_footer.css" rel="stylesheet">
    <link href="../public/css/styles.css" rel="stylesheet">

    <style>
        .action-buttons .btn {
            margin-bottom: 1rem;
            padding: 1rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .student-table {
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background-color: #4CAF50;
            color: white;
            font-weight: 500;
        }

        .attendance-high {
            color: #28a745;
            font-weight: bold;
        }

        .attendance-low {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="main-content container-fluid">
        <div class="container py-4">
            <!-- Status Messages -->
            <?php if(isset($_SESSION['status'])) : ?>
                <div class="alert alert-info alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['status']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['status']); ?>
            <?php endif; ?>

            <!-- Course Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Computer Peripheral and Interfacing</h2>
                            <p class="text-muted">Course Code: CSE-307</p>
                            <p class="text-muted">Session: 2020-21</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="action-buttons d-flex flex-wrap gap-3">
                        <!-- Copy Data Button -->
                        <button class="btn btn-info rounded-pill" onclick="copyStudentData()">
                            <i class="fas fa-copy me-2"></i>Copy Student Data
                        </button>

                        <!-- Start Attendance Button -->
                        <button class="btn btn-success rounded-pill" onclick="startAttendance()">
                            <i class="fas fa-play me-2"></i>Start Attendance
                        </button>

                        <!-- Set Timer Button -->
                        <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#timerModal">
                            <i class="fas fa-clock me-2"></i>Set Timer
                        </button>

                        <!-- Send Mail Button -->
                        <button class="btn btn-warning rounded-pill" onclick="sendLowAttendanceMails()">
                            <i class="fas fa-envelope me-2"></i>Send Low Attendance Notifications
                        </button>
                    </div>
                </div>
            </div>

            <!-- Student Information Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card student-table">
                        <div class="card-body">
                            <h4 class="mb-4">Student Information</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Roll</th>
                                            <th>Name</th>
                                            <th>Registration</th>
                                            <th>Session</th>
                                            <th>Total Classes</th>
                                            <th>Present</th>
                                            <th>Absent</th>
                                            <th>Attendance %</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch student information from database
                                        $query = "SELECT s.*, 
                                                COUNT(a.id) as total_classes,
                                                SUM(a.status = 'present') as present_classes,
                                                SUM(a.status = 'absent') as absent_classes
                                                FROM student_info s
                                                LEFT JOIN attendance a ON s.id = a.student_id
                                                WHERE s.student_session = '2023-24'
                                                GROUP BY s.id";
                                        $result = $conn->query($query);

                                        while($student = $result->fetch_assoc()):
                                            $attendance_percentage = ($student['present_classes'] / $student['total_classes']) * 100;
                                            $attendance_class = $attendance_percentage < 70 ? 'attendance-low' : 'attendance-high';
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($student['student_roll']); ?></td>
                                            <td><?= htmlspecialchars($student['student_name']); ?></td>
                                            <td><?= htmlspecialchars($student['student_reg']); ?></td>
                                            <td><?= htmlspecialchars($student['student_session']); ?></td>
                                            <td><?= $student['total_classes']; ?></td>
                                            <td><?= $student['present_classes']; ?></td>
                                            <td><?= $student['absent_classes']; ?></td>
                                            <td class="<?= $attendance_class; ?>"><?= number_format($attendance_percentage, 2); ?>%</td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Footer -->
    <?php include('../includes/footer.php'); ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy Student Data Function
        window.copyStudentData = function() {
            if(confirm('Are you sure you want to copy student data?')) {
                window.location.href = '../controllers/copy_student_data.php';
            }
        };
    });
</script>

</body>
</html>