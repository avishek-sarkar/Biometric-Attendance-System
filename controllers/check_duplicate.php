<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$field = isset($_POST['field']) ? $_POST['field'] : '';
$value = isset($_POST['value']) ? $_POST['value'] : '';

// Debug log
error_log("Checking duplicate: field=$field, value=$value");

$response = ['exists' => false, 'message' => ''];

if (!empty($field) && !empty($value)) {
    $allowedFields = ['roll', 'reg', 'email', 'phone'];
    
    if (in_array($field, $allowedFields)) {
        try {
            // Prepare the query
            $query = "SELECT COUNT(*) as count FROM students WHERE $field = ?";
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
                    case 'roll':
                        $response['message'] = 'This roll number is already registered';
                        break;
                    case 'reg':
                        $response['message'] = 'This registration number is already registered';
                        break;
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
            error_log("Error in check_duplicate.php: " . $e->getMessage());
            $response['error'] = 'An error occurred while checking for duplicates';
        }
    }
}

// Debug log
error_log("Response: " . json_encode($response));

$conn->close();
echo json_encode($response);
?>