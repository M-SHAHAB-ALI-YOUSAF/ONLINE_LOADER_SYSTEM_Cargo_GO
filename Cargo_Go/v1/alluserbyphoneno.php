<?php

require_once '../includes/DbOperations.php';

// $response = array();

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     if (isset($_POST['Phone_No'])) {
//         $db = new DbOperations();

//         $phoneno = $_POST['Phone_No'];

//         // Call a function to retrieve user data by phone number
//         $users = $db->getUsersByPhone($phoneno);

//         if ($users) {
//             $response['error'] = false;
//             $response['users'] = $users;
//         } else {
//             $response['error'] = true;
//             $response['message'] = "No users found for the provided phone number";
//         }
//     } else {
//         $response['error'] = true;
//         $response['message'] = "Required fields are missing";
//     }
// }

// echo json_encode($response);




$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Phone_No'])) {
        $db = new DbOperations();

        $phoneno = $_POST['Phone_No'];

        // Call a function to retrieve user data by phone number
        $user = $db->getUsersByPhone($phoneno); // Assuming getUserByPhone returns a single user

        if ($user) {
            $response['error'] = false;
            $response['Customer_ID'] = $user['Customer_ID'];
            $response['First_Name'] = $user['First_Name'];
            $response['Last_Name'] = $user['Last_Name'];
            $response['Email'] = $user['Email'];
            $response['Phone_No'] = $phoneno;
            $response['Profile_Image'] = $user['Profile_Image'];
        } else {
            $response['error'] = true;
            $response['message'] = "No user found for the provided phone number";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
}

echo json_encode($response);
