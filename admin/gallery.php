<?php
header('Content-Type: application/json');

$images = glob('../image/products/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

if ($images) {
    // Prepare an array of image URLs
    $imageUrls = array_map(fn($img) => $img, $images);

    // Return the response
    echo json_encode(['success' => true, 'images' => $imageUrls]);
} else {
    echo json_encode(['success' => false, 'message' => 'No images found']);
}
