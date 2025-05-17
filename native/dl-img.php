<?php
// Path to the JSON file
$jsonFilePath = 'data-item.json';

// Check if the JSON file exists
if (file_exists($jsonFilePath)) {
    // Get the content of the JSON file
    $jsonData = file_get_contents($jsonFilePath);

    // Decode the JSON into a PHP array
    $items = json_decode($jsonData, true);

    // Create the images directory if it doesn't exist
    if (!is_dir('images')) {
        mkdir('images', 0777, true);
    }

    // Loop through each item in the JSON array
    foreach ($items as $index => $item) {
        // Get the image URL
        $imageUrl = $item['image'];

        // Get the image content
        $imageData = file_get_contents($imageUrl);

        if ($imageData) {
            // Create image resource from data
            $srcImage = @imagecreatefromstring($imageData);

            if ($srcImage === false) {
                echo "Failed to create image from: $imageUrl\n";
                continue;
            }

            $originalWidth = imagesx($srcImage);
            $originalHeight = imagesy($srcImage);

            $targetWidth = 600;
            $targetHeight = 400;

            // Calculate aspect ratio
            $ratio = min($targetWidth / $originalWidth, $targetHeight / $originalHeight);
            $newWidth = (int)($originalWidth * $ratio);
            $newHeight = (int)($originalHeight * $ratio);

            // Create a blank image with the target size
            $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

            // Fill with white background
            $white = imagecolorallocate($resizedImage, 255, 255, 255);
            imagefill($resizedImage, 0, 0, $white);

            // Center the resized image
            $dstX = ($targetWidth - $newWidth) / 2;
            $dstY = ($targetHeight - $newHeight) / 2;

            // Copy and resize
            imagecopyresampled(
                $resizedImage,
                $srcImage,
                $dstX, $dstY,
                0, 0,
                $newWidth, $newHeight,
                $originalWidth, $originalHeight
            );

            // Generate new image name: digi-img-{id}-{random_5_digits}.jpg
            $id = $index + 1;
            $randomNumber = rand(10000, 99999);
            $newImageName = "digi-img-{$id}-{$randomNumber}.jpg";
            $newImagePath = 'images/' . $newImageName;

            // Save resized image to file
            imagejpeg($resizedImage, $newImagePath, 90); // quality: 90%

            // Free memory
            imagedestroy($srcImage);
            imagedestroy($resizedImage);

            echo "Image saved as: $newImageName\n";

            // Update the image field in the item
            $items[$index]['image'] = $newImageName;
        } else {
            echo "Failed to download image from: $imageUrl\n";
        }
    }

    // Save the updated JSON back to the file
    $updatedJsonData = json_encode($items, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    file_put_contents($jsonFilePath, $updatedJsonData);

    echo "JSON file updated successfully.\n";
} else {
    echo "The file $jsonFilePath does not exist.";
}
?>
