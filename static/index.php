<?php
/**
 * Random background image generator using Lorem Picsum API
 * 
 * @version 2025.07.0
 */

// Default values in case API call fails
$imageUrl = '';
$author = 'Unknown';
$authorUrl = '#';

try {
    // Fetch the full image list (paginated)
    $apiUrl = 'https://picsum.photos/v2/list?page=1&limit=100';
    $response = file_get_contents($apiUrl);
    
    if ($response === false) {
        throw new Exception('Failed to fetch image list from API');
    }
    
    $list = json_decode($response, true);
    
    if (!is_array($list) || empty($list)) {
        throw new Exception('Invalid or empty response from API');
    }
    
    // Pick a random image using seed
    $seed = rand();
    $index = crc32($seed) % count($list);
    $info = $list[$index];
    
    // Construct image URL using ID
    $imageUrl = "https://picsum.photos/seed/{$info['id']}/2880/1620?blur=8";
    $author = $info['author'];
    $authorUrl = $info['url'];
} catch (Exception $e) {
    // Log error (in a production environment)
    // error_log('Error fetching background image: ' . $e->getMessage());
    
    // Fallback to a default image if needed
    $imageUrl = 'https://picsum.photos/2880/1620?blur=8';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Unsplash Background</title>
    <link rel="stylesheet" href="main.css">
    <style>
        body {
            background: url('<?php echo htmlspecialchars($imageUrl); ?>') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="viewport">
    <div class="text-box">
        <p class="title">stunning-octo-giggle</p>
        <p class="subtitle"><i>Lorem ipsum dolor Whiskey</i></p>
    </div>
</div>
<p class="footer">
    Placeholder by <a href="http://github.com/houbsi">Houbsi</a> |
    Image from <a href="https://unsplash.com/de" target="_blank">Unsplash</a> via <a href="https://picsum.photos/" target="_blank">Lorem Picsum</a> by <a href="<?php echo htmlspecialchars($authorUrl); ?>" target="_blank"><?php echo htmlspecialchars($author); ?></a> |
    Version 2025.07.0
</p>
</body>
</html>
