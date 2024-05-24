<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Phone_No'])) {
        $phoneno = $_POST['Phone_No'];

        $db = new DbOperations();

                if ($db->isPhoneRegistered($phoneno)) {
                    $response['error'] = true;
                    $response['message'] = "Phone number is already registered, please choose a different one.";
                } else {
                    $response['error'] = false;
                    $response['message'] = "Phone number is not registered. You can use it for registration.";
                }
            } else {
                $response['error'] = true;
                $response['message'] = "Phone number parameter is missing.";
            }
        } else {
            $response['error'] = true;
            $response['message'] = "Invalid Request";
        }
        
        echo json_encode($response);
?>
