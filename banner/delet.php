<?php

$ids = array(702324, 702325, 702326, 702327, 702328, 702329, 702330, 702331, 702332,
    702333, 702334, 702335, 702336, 702337, 702338, 702339, 702340, 702341,
    702342, 702343, 702344, 702345, 702346, 702347, 702348, 702349
); // Replace with your list of campaign IDs

$token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjoiMSIsInR5cCI6ImFjY2VzcyIsImRvbWFpbiI6Inlla3RhbmV0IiwiZXhwIjoxNzQ1MzM4NjI4LCJ1c2VyX2lkIjozMDg5OCwidXNlcm5hbWUiOiJ5ZWt0YW5ldDU3IiwiaXNfc3RhZmYiOmZhbHNlLCJmbmFtZSI6Illla3RhbmV0IiwibG5hbWUiOiJQZXJmb3JtYW5jZSIsImVtYWlsIjoieWVrdGFuZXQucGVyZm9ybWFuY2VAZ21haWwuY29tIiwicGhvbmUiOiIiLCJhY2MiOiJaaWZoQ2hLVyIsImFwcCI6IjFyNUczekNEIiwicHJtIjoiZWRpdCIsImFjdCI6ImFkdiIsImhpamFja2VyIjp7InVzZXJfaWQiOjI4NDg0NCwidXNlcm5hbWUiOiJraW1peWF6b2hvdXJpYW4iLCJpc19zdGFmZiI6dHJ1ZX19.T_3GBeQi0SWCp_0vq0z6uoH2ToukZ_QaHYRLkIkNFdlcPAaMMaEpN9INZtiYJVqUb2nigz5Ihk43-RLTfBkikFRLMLZ2RKm8Uajvi3QLAXgM76kB93VtmKXjnTlRo_Tl9qPAItBKALxe2quTMYfMTvmkbcUTFIEowljOasXDAz0";

$url = 'https://api.yektanet.com/api/v2/adv/campaigns/';

foreach ($ids as $id) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url . $id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
    // curl_setopt($ch, CURLOPT_VERBOSE, true); // Optional: Uncomment for debug info

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json, text/plain, */*',
        'accept-language: en-US,en;q=0.9',
        'authorization: JWT ' . $token,
        'origin: https://panel.yektanet.com',
        'priority: u=1, i',
        'referer: https://panel.yektanet.com/',
        'sec-ch-ua: "Google Chrome";v="135", "Not-A.Brand";v="8", "Chromium";v="135"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "Windows"',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-site',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36'
    ));

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    curl_close($ch);

    echo "Deleted campaign ID $id. Response code: $httpcode\n";
    if ($error) {
        echo "cURL error: $error\n";
    } else {
        echo "Response body:\n$response\n";
    }
}

?>
