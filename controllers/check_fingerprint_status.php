<?php
header('Content-Type: application/json');
require_once '../config/db_config.php';

$response = ['status' => 0, 'lastFingerId' => 0];

try {
    // Check fingerprint_data table for the latest record
    $stmt = $conn->prepare("SELECT status, lastFingerId FROM fingerprint_data WHERE id = 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $fingerprint = $result->fetch_assoc();

    if ($fingerprint) {
        $response['status'] = $fingerprint['status'];
        $response['lastFingerId'] = $fingerprint['lastFingerId'];
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>