<?php

$jwt = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjoiMSIsInR5cCI6ImFjY2VzcyIsImRvbWFpbiI6Inlla3RhbmV0IiwiZXhwIjoxNzQ2NTk4NjYyLCJ1c2VyX2lkIjozMDg5OCwidXNlcm5hbWUiOiJ5ZWt0YW5ldDU3IiwiaXNfc3RhZmYiOmZhbHNlLCJmbmFtZSI6Illla3RhbmV0IiwibG5hbWUiOiJQZXJmb3JtYW5jZSIsImVtYWlsIjoieWVrdGFuZXQucGVyZm9ybWFuY2VAZ21haWwuY29tIiwicGhvbmUiOiIiLCJhY2MiOiJaaWZoQ2hLVyIsImFwcCI6IjFyNUczekNEIiwicHJtIjoiZWRpdCIsImFjdCI6ImFkdiIsImhpamFja2VyIjp7InVzZXJfaWQiOjI4NDg0NCwidXNlcm5hbWUiOiJraW1peWF6b2hvdXJpYW4iLCJpc19zdGFmZiI6dHJ1ZX19.ZovyPTsIqa5vp5wsOxXX9gl7U6xmRVZpi9vEVmkamXCtaJ7xDzXezEDxqPZ_t5V4gluWGw-c8L7UgtJYG_vvi6h8VJYNtla3B_yNEcdVwaucKbu1B5xz3Pwq5GBHRNxKd3oadxVPEaf3caXxRxfYKxcPxWE4WzBOR2KSkJYRFVM'; // <-- Replace with your actual token
$apiUrl = 'https://ad-management.yektanet.com/v1/ad/bnrs/templates/';
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
        'url'           => $ad['item_url'],
        'campaign_id'   => $ad['campaign'],
        'devices'       => 'all',
        'user_applied'  => 'true',
        'image_source'  => 'manual',
        'title'         => $ad['title'],
        'action_text'   => $ad['cta_title'],
        'color'         => $ad['cta_color'],
        'text'          => $ad['description'],
        'brand_logo'    => '',
      'image' => new CURLFile($localImagePath, $mimeType, $ad['image'])
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
