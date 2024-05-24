<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Booking_ID']) &&
        isset($_POST['Complaint_Type']) &&
        isset($_POST['Complaint_Description']) &&
        isset($_POST['Complaint_status']
    )) {
        $bookingID = $_POST['Booking_ID'];
        $complaintType = $_POST['Complaint_Type'];
        $complaintDescription = $_POST['Complaint_Description'];
        $complaintStatus = $_POST['Complaint_status'];
        
        $complaintDate = date('Y-m-d');
        

        $db = new DbOperations();
        $result = $db->createComplaint($bookingID, $complaintType, $complaintDescription, $complaintDate, $complaintStatus);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Complaint registered successfully";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "Some error occurred, please try again";
        } elseif ($result == 0) {
            $response['error'] = true;
            $response['message'] = "Complaint already registered";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>

