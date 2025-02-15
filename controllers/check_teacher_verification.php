<?php
header('Content-Type: application/json');
require_once '../config/db_config.php';

$token = isset($_GET['token']) ? $_GET['token'] : '';
$response = ['verified' => false];

if (!empty($token)) {
    $stmt = $conn->prepare("SELECT is_verified FROM teacher_info WHERE verification_token = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        $response['verified'] = (bool)$row['is_verified'];
    }
    
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>