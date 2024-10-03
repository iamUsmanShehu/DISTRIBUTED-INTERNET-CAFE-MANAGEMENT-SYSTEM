<?php
// verify_payment.php
session_start();
if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];

    // Paystack Secret Key
    $secret_key = 'pk_test_6890595463b6cd16c8b4320f1ed906db9864215d'; // Replace with your secret key

    // Paystack API URL for verification
    $url = 'https://api.paystack.co/transaction/verify/' . $reference;

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $secret_key
    ]);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }

    curl_close($ch);

    // Decode the response
    $result = json_decode($response, true);

    // Check if the payment was successful
    if ($result['data']['status'] === 'success') {
        // echo "Payment was successful! Transaction Reference: " . $reference;
            $user_id = $_SESSION['user_id']; // Get the user ID from the session
            $amount = $result['data']['amount'] / 100; // Convert back to Naira
            $status = $result['data']['status'];
            
            // Database connection
            $db = new mysqli('localhost', 'root', '', 'dicms');

            // Insert into payments table
            $stmt = $db->prepare("INSERT INTO payments (user_id, reference, amount, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isds", $user_id, $reference, $amount, $status);
            
            if ($stmt->execute()) {
                echo "Payment recorded successfully!";
                header("refresh:2; url=activate_shop.php");
            } else {
                echo "Failed to record payment.";
            }

    } else {
        echo "Payment failed!";
    }
} else {
    echo "No reference found!";
}


    $stmt->close();
    $db->close();

?>
