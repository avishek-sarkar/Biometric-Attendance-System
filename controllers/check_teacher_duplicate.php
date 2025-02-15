<?php
header('Content-Type: application/json');
require_once '../config/db_config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$field = isset($_POST['field']) ? $_POST['field'] : '';
$value = isset($_POST['value']) ? $_POST['value'] : '';

// Debug log
error_log("Checking teacher duplicate: field=$field, value=$value");

$response = ['exists' => false, 'message' => ''];

if (!empty($field) && !empty($value)) {
    // Map the form field names to database field names
    $fieldMapping = [
        'email' => 'teacher_email',
        'phone' => 'teacher_phone'
    ];

    if (isset($fieldMapping[$field])) {
        try {
            // Use the mapped field name for the query
            $dbField = $fieldMapping[$field];
            $query = "SELECT COUNT(*) as count FROM teacher_info WHERE $dbField = ?";
            $stmt = $conn->prepare($query);
            
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            $stmt->bind_param('s', $value);
            
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                $response['exists'] = true;
                switch ($field) {
                    case 'email':
                        $response['message'] = 'This email address is already registered';
                        break;
                    case 'phone':
                        $response['message'] = 'This phone number is already registered';
                        break;
                }
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            error_log("Error in check_teacher_duplicate.php: " . $e->getMessage());
            $response['error'] = 'An error occurred while checking for duplicates';
        }
    }
}

// Debug log
error_log("Response: " . json_encode($response));

$conn->close();
echo json_encode($response);
?>