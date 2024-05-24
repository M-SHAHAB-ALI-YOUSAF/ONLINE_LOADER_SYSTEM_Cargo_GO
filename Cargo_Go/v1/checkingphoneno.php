<?php

require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Phone_No']) && isset($_POST['Email'])) {
        $phoneno = $_POST['Phone_No'];
        $email = $_POST['Email'];

        $db = new DbOperations();

        if ($db->isPhoneRegistered($phoneno)) {
            $response['error'] = true;
            $response['message'] = "Phone number is already registered, please choose a different one.";
        } elseif ($db->isEmailRegistered($email)) {
            $response['error'] = true;
            $response['message'] = "Email is already registered, please choose a different one.";
        } else {
            $response['error'] = false;
            $response['message'] = "Phone number and email are not registered. You can use them for registration.";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Phone number or email parameter is missing.";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);


// require_once '../includes/DbOperations.php';

// $response = array();

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     if (isset($_POST['phoneno'])) {
//         $phoneno = $_POST['phoneno'];

//         $db = new DbOperations();

//         if ($db->isPhoneRegistered($phoneno)) {
//             $response['error'] = true;
//             $response['message'] = "Phone number is already registered, please choose a different one.";
//         } else {
//             $response['error'] = false;
//             $response['message'] = "Phone number is not registered. You can use it for registration.";
//         }
//     } else {
//         $response['error'] = true;
//         $response['message'] = "Phone number parameter is missing.";
//     }
// } else {
//     $response['error'] = true;
//     $response['message'] = "Invalid Request";
// }

// echo json_encode($response);
?>
