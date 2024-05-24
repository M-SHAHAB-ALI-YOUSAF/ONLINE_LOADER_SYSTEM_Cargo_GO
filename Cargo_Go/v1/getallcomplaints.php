<?php

require_once '../includes/DbOperations.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $db = new DbOperations();

    // Call the function to fetch complaints
    $complaints = $db->getComplaints();

    if ($complaints !== false) {
        $response['error'] = false;
        $response['complaints'] = $complaints;
    } else {
        $response['error'] = true;
        $response['message'] = "No complaints found";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>
