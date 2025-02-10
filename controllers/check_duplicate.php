<?php
header('Content-Type: application/json');
$host = 'localhost';
$dbname = 'attendancesystem';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$field = isset($_POST['field']) ? $_POST['field'] : '';
$value = isset($_POST['value']) ? $_POST['value'] : '';

// Debug log
error_log("Checking duplicate: field=$field, value=$value");

$response = ['exists' => false, 'message' => ''];

if (!empty($field) && !empty($value)) {
    // Map the form field names to database field names
    $fieldMapping = [
        'roll' => 'student_roll',
        'reg' => 'student_reg',
        'email' => 'student_email',
        'phone' => 'student_phone'
    ];

    // Check if the field exists in our mapping
    if (isset($fieldMapping[$field])) {
        try {
            // Use the mapped field name for the query
            $dbField = $fieldMapping[$field];
            $query = "SELECT COUNT(*) as count FROM student_info WHERE $dbField = ?";
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