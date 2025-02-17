<?php
session_start();
require_once '../config/db_config.php';

// Verify teacher authentication
if (!isset($_SESSION['auth_user']) || $_SESSION['auth_user']['role'] !== 'teacher') {
    $_SESSION['status'] = "Unauthorized access";
    header('Location: ../views/course_information.php');
    exit();
}

try {
    // Start transaction
    $conn->begin_transaction();

    // Clear existing data from peripheral_course table
    $clear_query = "TRUNCATE TABLE peripheral_course";
    $conn->query($clear_query);

    // Copy data from student_info to peripheral_course
    $insert_query = "INSERT INTO peripheral_course (name, roll, registration, session, fingerId, attendance, last_date)
                    SELECT 
                        student_name,
                        student_roll,
                        student_reg,
                        student_session,
                        COALESCE(fingerId, 0), -- Ensure fingerId is not null
                        0,  -- Set attendance to 0
                        NOW() -- Set initial timestamp to current time
                    FROM student_info 
                    WHERE student_session = '2020-21'";

    if (!$conn->query($insert_query)) {
        throw new Exception("Error copying data: " . $conn->error);
    }

    // Commit transaction
    $conn->commit();
    
    $_SESSION['status'] = "Student data copied successfully";

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($conn)) {
        $conn->rollback();
    }
    $_SESSION['status'] = "Error: " . $e->getMessage();
}

// Close database connection
if (isset($conn)) {
    $conn->close();
}

// Redirect back
header('Location: ../views/course_information.php');
exit();
?>
