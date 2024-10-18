<?php
include_once 'config.php';

$orderId = $_POST['orderId'];
$phoneNumber = $_POST['phoneNumber'];

// Query the database to check if the order exists with the provided ID and phone number
$query = "SELECT * FROM orders WHERE id = '$orderId' AND mobile = '$phoneNumber'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    // Order found
    $order = mysqli_fetch_assoc($result);
    echo json_encode(['success' => true, 'order_id' => $order['id']]);
} else {
    // Order not found
    echo json_encode(['success' => false]);
}

