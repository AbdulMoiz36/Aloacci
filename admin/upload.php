<?php
$response = ['success' => false, 'message' => '', 'uploadedFiles' => [], 'errors' => []];

if (!empty($_FILES['images']['name'][0])) {
    $uploadDir = '../image/products/';
    $allowedWidth = 800;
    $allowedHeight = 1200;

    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = $_FILES['images']['name'][$key];
        $fileTmp = $_FILES['images']['tmp_name'][$key];
        $fileSize = $_FILES['images']['size'][$key];
        $fileError = $_FILES['images']['error'][$key];

        // Check for errors
        if ($fileError !== UPLOAD_ERR_OK) {
            $response['errors'][] = "Error uploading file: $fileName";
            continue;
        }

        // Get image dimensions
        list($width, $height) = getimagesize($fileTmp);

        // Validate dimensions
        if ($width !== $allowedWidth || $height !== $allowedHeight) {
            $response['errors'][] = "File $fileName does not have dimensions $allowedWidth x $allowedHeight.";
            continue;
        }

        // Save file
        $destination = $uploadDir . basename($fileName);
        if (move_uploaded_file($fileTmp, $destination)) {
            $response['uploadedFiles'][] = $fileName;
        } else {
            $response['errors'][] = "Failed to upload file: $fileName";
        }
    }

    if (!empty($response['uploadedFiles'])) {
        $response['success'] = true;
        $response['message'] = "Valid files uploaded successfully.";
    } else {
        $response['message'] = "No valid files were uploaded.";
    }
} else {
    $response['message'] = "No files were uploaded.";
}

// Return response
echo json_encode($response);
