<?php



// Load your JSON file
$jsonFile = 'data-camp.json';
$data = json_decode(file_get_contents($jsonFile), true);


$token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjoiMSIsInR5cCI6ImFjY2VzcyIsImRvbWFpbiI6Inlla3RhbmV0IiwiZXhwIjoxNzQ1MzM4NzQwLCJ1c2VyX2lkIjozMDg5OCwidXNlcm5hbWUiOiJ5ZWt0YW5ldDU3IiwiaXNfc3RhZmYiOmZhbHNlLCJmbmFtZSI6Illla3RhbmV0IiwibG5hbWUiOiJQZXJmb3JtYW5jZSIsImVtYWlsIjoieWVrdGFuZXQucGVyZm9ybWFuY2VAZ21haWwuY29tIiwicGhvbmUiOiIiLCJhY2MiOiJaaWZoQ2hLVyIsImFwcCI6IjFyNUczekNEIiwicHJtIjoiZWRpdCIsImFjdCI6ImFkdiIsImhpamFja2VyIjp7InVzZXJfaWQiOjI4NDg0NCwidXNlcm5hbWUiOiJraW1peWF6b2hvdXJpYW4iLCJpc19zdGFmZiI6dHJ1ZX19.MIse-9aPKjmHwkO4TEs0mwtrWXaP-gxJVzEgvfktsRCmphxFiKcHrax_R7-EaWc_aK-yMb3Andt71v4l-Zjf7hAWAmLazv5rl-p-N-KuWn-Z3x2Te82b-_v1JZimWF6nPGehJupHxhwCtpYqBAZDuByd-Vjp4qAa0nbQV-IRZJc";

// Loop through each campaign item
foreach ($data as $campaign) {
$postData = [
        "title" => $campaign["title"],
        "campaign_type" => "bnr",
        "only_re_targeting" => false,
        "only_related_content" => false,
        "is_keyword" => false,
        "is_category" => false,
        "is_audience_sharing" => false,
        "is_autotargeting" => false,
        "segmentation_selected" => false,
        "auto_publishers_select" => true,
        "display_publisher_group" => "",
        "publishers_visible" => true,
        "is_fixed" => false,
        "property_type" => null,
        "minimum_interval_between_duplicates" => 24,
        "cost_limit" => 700000,
        "bid" => 1200,
        "use_campaign_total_balance" => false,
        "bidding_strategy" => "ecpc",
        "monetization_type" => "cpc",
        "utm_campaign" => $campaign["utm_campaign"],
        "utm_medium" => "bnr",
        "utm_term_status" => "",
        "utm_term" => "",
        "utm_content_status" => "",
        "utm_content" => "",
        "utm_source" => "yektanet",
        "utm_structure" => 12,
        "is_daily" => false,
        "is_periodic" => false,
        "device_os_type" => "all",
        "display_all_os_versions" => true,
        "display_all_mobile_brands" => true,
        "display_mobile_brand" => [],
        "display_all_countries" => true,
        "countries" => [],
        "display_location" => [],
        "display_in_all_isp" => true,
        "display_isp" => [
            "Shatel",
            "Iran Cell",
            "Mobile Communication Company",
            "Rightel",
            "Asiatech",
            "Mobin Net",
            "Telecommunication",
            "Pars Online",
            "Afranet",
            "Respina",
            "Information Technology Company",
            "Neda Rayaneh",
            "Other"
        ],
        "publisher_floating_bids" => [],
        "publisher_group_floating_bids" => [],
        "subcategories" => [],
        "keywords" => [],
        "negative_keywords" => [],
        "broad_allowed" => true,
        "goal" => [
            "type" => "13",
            "tags" => []
        ],
        "config" => [
            "segment_ids" => []
        ],
        "target_suppliers" => [
            "web"
        ],
        "is_push_supplier_active" => false,
        "is_adivery_supplier_active" => false,
        "is_divar" => false,
        "divar_config" => [
            "cities" => [],
            "category_slugs" => [],
            "categories" => [],
            "keywords" => [],
            "neighborhoods" => [],
            "min_price" => null,
            "max_price" => null,
            "brands" => [],
            "smart_targeting" => true
        ],
        "is_rubika" => false,
        "user_apply" => true
    ];

    $ch = curl_init('https://api.yektanet.com/api/v2/adv/campaigns/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json, text/plain, */*",
        "Content-Type: application/json",
        "Authorization: JWT $token",
        "Origin: https://panel.yektanet.com",
        "Referer: https://panel.yektanet.com/"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
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

    curl_close($ch);
}

?>