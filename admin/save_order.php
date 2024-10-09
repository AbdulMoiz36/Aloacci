<?php
include "config.php";

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

// Insert user information into the order table
$order_query = "INSERT INTO orders (mobile, name, city, address, total_price, order_from, order_status, date) VALUES ('$mobile', '$name', '$city', '$address', '$total_price', '$order_from', '$order_status', '$date')";
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
