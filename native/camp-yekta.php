<?php

// Your JWT token
$jwt = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjoiMSIsInR5cCI6ImFjY2VzcyIsImRvbWFpbiI6Inlla3RhbmV0IiwiZXhwIjoxNzQ0NzI0MDA1LCJ1c2VyX2lkIjozMDg5OCwidXNlcm5hbWUiOiJ5ZWt0YW5ldDU3IiwiaXNfc3RhZmYiOmZhbHNlLCJmbmFtZSI6Illla3RhbmV0IiwibG5hbWUiOiJQZXJmb3JtYW5jZSIsImVtYWlsIjoieWVrdGFuZXQucGVyZm9ybWFuY2VAZ21haWwuY29tIiwicGhvbmUiOiIiLCJhY2MiOiJaaWZoQ2hLVyIsImFwcCI6IjFyNUczekNEIiwicHJtIjoiZWRpdCIsImFjdCI6ImFkdiIsImhpamFja2VyIjp7InVzZXJfaWQiOjI4NDg0NCwidXNlcm5hbWUiOiJraW1peWF6b2hvdXJpYW4iLCJpc19zdGFmZiI6dHJ1ZX19.VSUUV8TJXrz4HJJJ5Z6EXIk-7YByt74DEDCNFqc5PTIGd9ZOP1OfgP0_ynLMGRuNCgimKoEA0dji4cjT6D0YYiXRQ4LDWRST2z6wMHu0qyT398iNHpY666p9_wgyEgpj6CiU6rFwr0fl71YeedIpKuC55mMAsoDMh-hS5d_ibII';

// Yektanet API URL
$apiUrl = 'https://api.yektanet.com/api/v2/adv/campaigns/';

// Load your JSON file
$jsonFile = 'camp-data.json';
$data = json_decode(file_get_contents($jsonFile), true);

// Fixed fields
$fixedFields = [
    'utm_term_status' => '',
    'utm_content_status' => '',
    'utm_source' => 'yektanet',
    'utm_structure' => 12,
    'bidding_strategy' => 'ecpc',
    'monetization_type' => 'cpc'
];

// Loop through the campaigns in the JSON file
foreach ($data as $campaign) {
    // Merge the fixed fields with the dynamic campaign data
    $postData = array_merge($fixedFields, [
        'title' => $campaign['title'],
        'campaign_type' => 'native',
        'only_re_targeting' => false,
        'only_related_content' => false,
        'is_keyword' => false,
        'is_category' => false,
        'is_audience_sharing' => false,
        'is_autotargeting' => false,
        'segmentation_selected' => false,
        'auto_publishers_select' => true,
        'display_publisher_group' => '',
        'publishers_visible' => true,
        'is_fixed' => false,
        'property_type' => null,
        'minimum_interval_between_duplicates' => 24,
        'cost_limit' => 2000000,
        'bid' => 1400,
        'use_campaign_total_balance' => false,
        'utm_campaign' => $campaign['utm_campaign'],
        'utm_medium' => 'native',
        'utm_term' => '',
        'utm_content' => '',
        'is_daily' => false,
        'is_periodic' => false,
        'device_os_type' => 'all',
        'display_all_os_versions' => true,
        'display_all_mobile_brands' => true,
        'display_mobile_brand' => [],
        'display_all_countries' => true,
        'countries' => [],
        'display_location' => [],
        'display_in_all_isp' => true,
        'display_isp' => [
            'Shatel', 'Iran Cell', 'Mobile Communication Company', 
            'Rightel', 'Asiatech', 'Mobin Net', 'Telecommunication', 
            'Pars Online', 'Afranet', 'Respina', 'Information Technology Company', 
            'Neda Rayaneh', 'Other'
        ],
        'publisher_floating_bids' => [],
        'publisher_group_floating_bids' => [],
        'subcategories' => [],
        'keywords' => [],
        'negative_keywords' => [],
        'broad_allowed' => true,
        'goal' => ['type' => '13', 'tags' => []],
        'config' => ['segment_ids' => []],
        'target_suppliers' => ['web', 'push', 'app'],
        'is_push_supplier_active' => true,
        'is_adivery_supplier_active' => true,
        'is_divar' => false,
        'divar_config' => ['cities' => [], 'category_slugs' => [], 'categories' => [], 'keywords' => [], 'neighborhoods' => [], 'min_price' => null, 'max_price' => null, 'brands' => [], 'smart_targeting' => true],
        'is_rubika' => false,
        'user_apply' => true
    ]);

    // Set up the cURL request
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($postData), // Send data as JSON
        CURLOPT_HTTPHEADER => [
            'Accept: application/json, text/plain, */*',
            'Authorization: JWT ' . $jwt,
            'Content-Type: application/json',
            'Origin: https://panel.yektanet.com',
            'Referer: https://panel.yektanet.com/'
        ]
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Error handling

    if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch) . "\n";
} else {
    $decodedResponse = json_decode($response, true);
    if (isset($decodedResponse['id'])) {
        echo $decodedResponse['id'] . "\n";
    } else {
        echo "Campaign '{$campaign['title']}' sent, but no ID found in response.\n";
    }
}

    // Close cURL
    curl_close($ch);
}
?>