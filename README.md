# Yektanet Bulk Campaign Creator

This PHP script is designed to automate the creation of **bulk campaigns** on [Yektanet](https://www.yektanet.com), specifically for **Native Banner** and **Dynamic** campaigns.

## 🚀 How It Works

1. **Create Campaigns**  
   First, the script creates campaigns via the Yektanet API. After creation, you'll receive a list of `campaign_id`s.

2. **Generate Items for Each Campaign**  
   For each `campaign_id`, the script can generate multiple items.  
   Before running this step:
   - Complete the `JSON` file for items.
   - Set the correct `URL` for each item.
   - The script then downloads and saves the image files.
   - While downloading, it automatically updates file paths in the JSON.

3. **Generate Final Item Scripts**  
   After everything is downloaded and set, the script generates the final item scripts for each campaign.

## 🔐 Authentication (Token Required)

You’ll need a **Yektanet internal token** to authenticate. You can find it in your browser cookies after logging in to your Yektanet panel.

Alternatively, you can get your token by visiting this link (replace `XXXXXX` with your account ID):

https://accounts.yektanet.com/api/v2/token/access/internal/?account=XXXXXX


## 🔗 Example Panel URL

After logging in, your panel URL will look like this:
https://panel.yektanet.com/u/XXXXXX/report/campaigns?account=XXXXXX&app=MPcVxHfL&page=1&per_page=10
## 🧰 Requirements

- PHP 7.x or 8.x
- cURL enabled
- JSON files prepared with campaign/item data
