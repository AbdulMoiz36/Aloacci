<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $format_name = $_POST['format_name'];

    // Fetch total qty from product_format
    $query = "SELECT qty FROM product_format WHERE format = '$format_name' AND product_id = '$product_id'";
    $result = mysqli_query($con, $query);
    $format_stock = mysqli_fetch_assoc($result)['qty'];

    // Fetch total qty from orders_detail where format matches
    $query = "SELECT SUM(qty) AS total_qty FROM orders_detail WHERE format = '$format_name' AND product_id = '$product_id'";
    $result = mysqli_query($con, $query);
    $orders_qty = mysqli_fetch_assoc($result)['total_qty'];

    // Calculate available stock
    $available_stock = $format_stock - $orders_qty;

    echo json_encode(['available_stock' => $available_stock]);
}
?>