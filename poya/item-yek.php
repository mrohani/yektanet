<?php

$jwt = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjoiMSIsInR5cCI6ImFjY2VzcyIsImRvbWFpbiI6Inlla3RhbmV0IiwiZXhwIjoxNzQ2OTUyMDUzLCJ1c2VyX2lkIjozMDg5OCwidXNlcm5hbWUiOiJ5ZWt0YW5ldDU3IiwiaXNfc3RhZmYiOmZhbHNlLCJmbmFtZSI6Illla3RhbmV0IiwibG5hbWUiOiJQZXJmb3JtYW5jZSIsImVtYWlsIjoieWVrdGFuZXQucGVyZm9ybWFuY2VAZ21haWwuY29tIiwicGhvbmUiOiIiLCJhY2MiOiIxNlVXUHQ2MyIsImFwcCI6IlJvaUFMMEgwIiwicHJtIjoiZWRpdCIsImFjdCI6ImFkdiIsImhpamFja2VyIjp7InVzZXJfaWQiOjI4NDg0NCwidXNlcm5hbWUiOiJraW1peWF6b2hvdXJpYW4iLCJpc19zdGFmZiI6dHJ1ZX19.a8R-FKwLVlvb0DmCNe3p_BKKaf_RSgjwWHugwJgLzs_VWoyQdgiRPTpNkdtCOZmMa_9dLUoZqHN2ocvY2UetcHAncHgCXRxP18tROv6IzL6HFzxl1er_Y1JPQ2Wq_3md-3NaIHLp5QhKU3Za6F_ztwBeh6bO22Mj9UZDNaf5EH4'; // <-- Replace with your actual token
$apiUrl = 'https://ad-management.yektanet.com/v1/ad/';
$jsonFile = __DIR__ . '/data-item.json';
$imageDir = __DIR__ . '/images/'; // Local directory where images are saved

$data = json_decode(file_get_contents($jsonFile), true);

foreach ($data as $ad) {
    // Construct full path to local image file
    $localImagePath = $imageDir . $ad['image'];

    // Check if the image file exists
    if (!file_exists($localImagePath)) {
        echo "❌ Image not found: $localImagePath\n";
        continue;
    }

    // Get the MIME type of the image
    $mimeType = mime_content_type($localImagePath);

    // Prepare the POST fields for the API request
    $postFields = [
        'campaign'     => $ad['campaign'],
        'title'        => $ad['title'],
        'item_url'     => $ad['item_url'],
        'description'  => $ad['description'],
        'user_apply'   => $ad['user_apply'],
        'cta_color'    => $ad['cta_color'],
        'cta_title'    => $ad['cta_title'],
        'image'        => new CURLFile($localImagePath, $mimeType, $ad['image']),
    ];

    // Initialize cURL
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_HTTPHEADER => [
            'accept: application/json, text/plain, */*',
            'authorization: JWT ' . $jwt,
            'origin: https://panel.yektanet.com',
            'referer: https://panel.yektanet.com/',
        ],
    ]);

    // Execute the request
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    // Print result
    echo "Campaign: {$ad['campaign']} => ";
    echo $error ? "❌ Error: $error\n" : "✅ Response: $response\n";
}
