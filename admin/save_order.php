<?php
include "config.php";
include "functions.php";
/* Restrict employee to access this page */
isAdmin();

// Get user information from POST request
$mobile = $_POST['mobile'];
$name = $_POST['name'];
$city = $_POST['city'];
$address = $_POST['address'];
$order_status = '1';
$order_from = '1';
$date = date('Y-m-d H:i:s'); // Proper date format

// Assuming $products is coming from the AJAX request
$products = $_POST['products'];

// Calculate total price
$total_price = 0;
foreach ($products as $product) {
    $total_price += $product['total_price'];
}

// Determine shipping charges
$shipping_charges = 0;
if ($city == 'Karachi') {
    $shipping_charges = 180; // Shipping charges for Karachi
} else {
    $shipping_charges = 250; // Shipping charges for other cities
}

// Check shipment status
$shipment_status = 1; // Default to 1 for now; you can modify it as needed
$shipment_query = "SELECT price, status FROM shipment WHERE status IN (0, 1)";
$shipment_result = mysqli_query($con, $shipment_query);
$shipment_price = 0;
$shipment_status = 0; // Initialize shipment status

if ($shipment_row = mysqli_fetch_assoc($shipment_result)) {
    $shipment_price = $shipment_row['price'];
    $shipment_status = $shipment_row['status'];
}

// Determine if shipping is free based on shipment status
if ($shipment_status == 1 && $total_price > $shipment_price) {
    $shipping_charges = 0; // Free shipping
}

// If shipment status is 0, ensure shipping charges are added
if ($shipment_status == 0) {
    // Keep the shipping charges as calculated based on the city
}

// Insert user information into the orders table
$order_query = "INSERT INTO orders (mobile, name, city, address, total_price, shipping, order_from, order_status, date) VALUES ('$mobile', '$name', '$city', '$address', '$total_price', '$shipping_charges', '$order_from', '$order_status', '$date')";
if (mysqli_query($con, $order_query)) {
    // Get the last inserted order ID
    $order_id = mysqli_insert_id($con);
    
    // Now insert each product into the order_details table
    foreach ($products as $product) {
        $product_id = $product['product_id'];
        $format_id = $product['format_id'];
        $qty = $product['qty'];
        $price = $product['price'];

        // Get the format name based on format_id
        $format_query = "SELECT format FROM product_format WHERE id = '$format_id'";
        $format_result = mysqli_query($con, $format_query);
        $format_name = '';
        if ($format_row = mysqli_fetch_assoc($format_result)) {
            $format_name = $format_row['format'];
        }

        // Insert into order_details table
        $details_query = "INSERT INTO orders_detail (order_id, product_id, format, qty, price) VALUES ('$order_id', '$product_id', '$format_name', '$qty', '$price')";
        mysqli_query($con, $details_query);
    }
    
    echo "Order placed successfully!";
} else {
    echo "Error: " . mysqli_error($con);
}
