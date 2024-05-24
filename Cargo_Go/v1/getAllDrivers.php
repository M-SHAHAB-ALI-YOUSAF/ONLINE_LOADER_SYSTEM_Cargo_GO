<?php

require_once '../includes/DbOperations.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Create an instance of the DbOperations class
    $db = new DbOperations();

    // Call the getAllDrivers method to fetch all driver records
    $drivers = $db->getAllDrivers();

    if ($drivers) {
        // Drivers data found, populate the response array
        $response['error'] = false;
        $response['drivers'] = $drivers;
    } else {
        // No drivers found in the database
        $response['error'] = true;
        $response['message'] = "No drivers found in the database";
    }
} else {
    // Invalid request method (not POST)
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

// Encode the response array as JSON and output it
echo json_encode($response);
