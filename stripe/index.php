<?php

// require 'vendor/autoload.php';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Retrieve the payment amount from the POST request
//     $paymentAmount = $_POST['paymentAmount']; // Make sure to sanitize and validate this input

//     // Initialize Stripe with your secret key
//     \Stripe\Stripe::setApiKey('sk_test_51NsmiQEAor30cesfFMrx7VLcvlXD6G4oz8PwbYhigUYrlBenS1jhcs7OS0loV3L9R406EkReBi6h6wsaQMV1SjMd00DaASx6rZ');

//     // Create a new customer or use an existing one
//     $customer = \Stripe\Customer::create([
//         'name' => "Shahab",
//         'address' => [
//             'line1' => 'Demo Address',
//             'postal_code' => '738933',
//             'city' => 'New York',
//             'state' => 'NY',
//             'country' => 'US',
//         ],
//     ]);

//     // Calculate the equivalent PKR amount
//     $exchangeRate = 284.50; // Replace with the actual exchange rate
//     $pkrAmount = $paymentAmount * $exchangeRate;
//     $pkrAmountInCents = (int) ($pkrAmount * 100); // Convert PKR to cents

//     // Format the PKR amount without a dollar sign or decimal point
//     $formattedPkrAmount = number_format($pkrAmountInCents, 0, '', '');

//     // Create an ephemeral key for the customer
//     $ephemeralKey = \Stripe\EphemeralKey::create(
//         ['customer' => $customer->id],
//         ['stripe_version' => '2022-08-01']
//     );

//     // Create a Payment Intent with the formatted PKR amount
//     $paymentIntent = \Stripe\PaymentIntent::create([
//         'amount' => $formattedPkrAmount,
//         'currency' => 'pkr',
//         'description' => 'Payment for android app',
//         'customer' => $customer->id,
//         'automatic_payment_methods' => [
//             'enabled' => 'true',
//         ],
//     ]);

//     // Return the necessary data as JSON
//     echo json_encode(
//         [
//             'paymentIntent' => $paymentIntent->client_secret,
//             'ephemeralKey' => $ephemeralKey->secret,
//             'customer' => $customer->id,
//             'publishableKey' => 'pk_test_51NsmiQEAor30cesfOmNLxOu6neAiMQBlqXgp0UC1BIl7y9N7rCW1JcmZRJl1Zb4oU1cRUoNOVX6JPQIP4Nxtlk5Q00JG8UvnsS'
//         ]
//     );
//     http_response_code(200);
// } else {
//     echo "Hacker";
// }

// <?php

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the payment amount in PKR from the POST request
    $paymentAmountInPKR = $_POST['paymentAmount']; // Make sure to sanitize and validate this input

    // Initialize Stripe with your secret key
    \Stripe\Stripe::setApiKey('sk_test_51NsmiQEAor30cesfFMrx7VLcvlXD6G4oz8PwbYhigUYrlBenS1jhcs7OS0loV3L9R406EkReBi6h6wsaQMV1SjMd00DaASx6rZ');

    // Create a new customer or use an existing one
    $customer = \Stripe\Customer::create([
        'name' => "Waqas",
        'address' => [
            'line1' => 'Demo Address',
            'postal_code' => '738933',
            'city' => 'New York',
            'state' => 'NY',
            'country' => 'US',
        ],
    ]);

    // Format the PKR amount in cents
    $pkrAmountInCents = (int) ($paymentAmountInPKR * 100); // Convert PKR to cents

    // Create an ephemeral key for the customer
    $ephemeralKey = \Stripe\EphemeralKey::create(
        ['customer' => $customer->id],
        ['stripe_version' => '2022-08-01']
    );

    // Create a Payment Intent with the formatted PKR amount
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $pkrAmountInCents,
        'currency' => 'pkr',
        'description' => 'Payment for android app',
        'customer' => $customer->id,
        'automatic_payment_methods' => [
            'enabled' => 'true',
        ],
    ]);

    // Return the necessary data as JSON
    echo json_encode(
        [
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'publishableKey' => 'pk_test_51NsmiQEAor30cesfOmNLxOu6neAiMQBlqXgp0UC1BIl7y9N7rCW1JcmZRJl1Zb4oU1cRUoNOVX6JPQIP4Nxtlk5Q00JG8UvnsS'
        ]
    );
    http_response_code(200);
} else {
    echo "Working";
}
?>

<!-- // ?> -->