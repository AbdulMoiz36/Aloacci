<?php
include 'config.php';

// Get JSON input from the AJAX request
$requestData = json_decode(file_get_contents('php://input'), true);

// Extract data from the request
$discountValue = $requestData['discount_value'];
$discountType = $requestData['discount_type'];
$discountAmount = $requestData['discount_amount'];
$totalAmount = $requestData['total_amount'];
$products = $requestData['products'];
// Get the current date and time
$currentDate = date("Y-m-d H:i:s");

// Validate input
if ($discountValue <= 0 || empty($products)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid discount value or empty products array.']);
    exit();
}

// Insert into bundles table
$sqlBundle = "
    INSERT INTO bundles (discount_value, discount_type, discount_amount, total_amount,status,date) 
    VALUES ('$discountValue', '$discountType', '$discountAmount', '$totalAmount','1','$currentDate')
";
if ($con->query($sqlBundle) === TRUE) {
    // Get the last inserted bundle_id
    $bundleId = $con->insert_id;

    // Insert into bundle_details table
    $success = true;
    foreach ($products as $product) {
        $productId = $con->real_escape_string($product['product_id']);
        $formatId = $con->real_escape_string($product['format_id']);
        $qty = $con->real_escape_string($product['qty']);

        $sqlDetails = "
            INSERT INTO bundle_details (bundle_id, product_id, format_id, qty) 
            VALUES ('$bundleId', '$productId', '$formatId', '$qty')
        ";

        if (!$con->query($sqlDetails)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'Bundle saved successfully.']);
    } else {
        // Rollback bundle insertion if product addition fails
        $con->query("DELETE FROM bundles WHERE id = '$bundleId'");
        echo json_encode(['status' => 'error', 'message' => 'Failed to save products for the bundle.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save bundle: ' . $con->error]);
}

// Close the conection
$con->close();
?>
