<?php
$response = ['success' => false, 'newImages' => [], 'message' => ''];

try {
    $existingImages = json_decode(file_get_contents('php://input'), true)['existingImages'] ?? [];

    // Fetch all images from the folder
    $allImages = glob('../image/products/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

    // Sort images by file modification time (descending)
    usort($allImages, function ($a, $b) {
        return filemtime($b) - filemtime($a);
    });

    // Filter out images that are already displayed
    $newImages = array_filter($allImages, function ($image) use ($existingImages) {
        return !in_array(realpath($image), array_map('realpath', $existingImages));
    });

    $response['success'] = true;
    $response['newImages'] = array_values($newImages);
} catch (Exception $e) {
    $response['message'] = 'Error fetching new images: ' . $e->getMessage();
}

echo json_encode($response);
?>
