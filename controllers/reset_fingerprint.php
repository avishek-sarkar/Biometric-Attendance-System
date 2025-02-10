<?php
header('Content-Type: application/json');
require_once '../config/db_config.php';

$response = ['success' => false];

try {
    $stmt = $conn->prepare("UPDATE fingerprint_data SET status = 0, lastFingerId = 0 WHERE id = 1");
    if ($stmt->execute()) {
        $response['success'] = true;
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>