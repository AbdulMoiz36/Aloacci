<?php
include 'config.php'; // Include your database connection

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);
$city = $data['city'];
$subtotal = $data['subtotal'];

// Initialize shipping cost
$shipping_cost = 250; // Default shipping cost

// Check the selected city for shipping cost
if ($city === 'Karachi') {
    $shipping_cost = 180;
}

// Get the shipment price from the database
$shipment_sql = mysqli_query($con, "SELECT `price` FROM `shipment` WHERE `status` = 1");
$shipment_data = mysqli_fetch_assoc($shipment_sql);
$shipment_price = $shipment_data['price'];

// Check if the subtotal exceeds the shipment price for free shipping
if ($subtotal > $shipment_price) {
    $shipping_cost = 0; // Free shipping if subtotal exceeds shipment price
}

// Calculate total
$total = $subtotal + $shipping_cost;

// Return the shipping cost and total as a JSON response
echo json_encode([
    'shipping' => number_format($shipping_cost, 2),
    'total' => number_format($total, 2)
]);
?>
