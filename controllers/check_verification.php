<?php
header('Content-Type: application/json');
require_once '../config/db_config.php';

$token = isset($_GET['token']) ? $_GET['token'] : '';
$response = ['verified' => false];

if (!empty($token)) {
    $stmt = $conn->prepare("SELECT is_verified FROM temp_registrations WHERE verification_token = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row && $row['is_verified'] == 1) {
        $response['verified'] = true;
    }
}

echo json_encode($response);
?>