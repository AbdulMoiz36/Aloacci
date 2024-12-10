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
$id = $requestData['id'];
// Get the current date and time
$currentDate = date("Y-m-d H:i:s");

// Validate input
if ($discountValue <= 0 || empty($products)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid discount value or empty products array.']);
    exit();
}

// Assuming $id is the identifier for the bundle being updated
$sqlBundle = "
    UPDATE bundles 
    SET 
        discount_value = '$discountValue', 
        discount_type = '$discountType', 
        discount_amount = '$discountAmount', 
        total_amount = '$totalAmount', 
        status = '1', 
        date = '$currentDate'
    WHERE id = '$id'
";

if ($con->query($sqlBundle) === TRUE) {
    // Delete all previous details for the specific bundle_id
    $sqlDeleteDetails = "DELETE FROM bundle_details WHERE bundle_id = '$id'";

    if ($con->query($sqlDeleteDetails) === TRUE) {
        // Insert new products into bundle_details table
        $success = true;
        foreach ($products as $product) {
            $productId = $con->real_escape_string($product['product_id']);
            $formatId = $con->real_escape_string($product['format_id']);
            $qty = $con->real_escape_string($product['qty']);

            // Prepare the SQL insert for product details
            $sqlDetails = "
                INSERT INTO bundle_details (bundle_id, product_id, format_id, qty) 
                VALUES ('$id', '$productId', '$formatId', '$qty')
            ";

            if (!$con->query($sqlDetails)) {
                // Log the error and set failure flag
                error_log("SQL Error: " . $con->error . " in query: $sqlDetails");
                $success = false;
                break;
            }
        }

        if ($success) {
            echo json_encode(['status' => 'success', 'message' => 'Bundle updated successfully.']);
        } else {
            // Rollback bundle update if product insertion fails
            echo json_encode(['status' => 'error', 'message' => 'Failed to save products for the bundle.']);
        }
    } else {
        // Rollback bundle update if details deletion fails
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete previous bundle details.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update bundle.']);
}

// Close the connection
$con->close();
?>
