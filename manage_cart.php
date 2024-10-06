<?php
require "config.php";
require "functions.php";
require "add_cart_func.php";

try {
    $pid = get_safe_value($con, $_POST['pid']);
    $qty = get_safe_value($con, $_POST['qty']);
    $type = get_safe_value($con, $_POST['type']);
    $format = isset($_POST['format']) ? get_safe_value($con, $_POST['format']) : ''; // Default to empty string
    $price = isset($_POST['price']) ? get_safe_value($con, $_POST['price']) : 0; // Default to 0
    

    // Check if quantity is available
    $productSoldQtyByProductId = productSoldQtyByProductId($con, $pid);
    $productQty = productQty($con, $pid);
    $pending_qty = $productQty - $productSoldQtyByProductId;

    if ($qty > $pending_qty && $type !== 'remove') {
        echo "not_available";
        exit;
    }

    $obj = new add_to_cart();

switch ($type) {
    case 'add':
        $obj->addProduct($pid, $qty, $format, $price); // Pass format and price to add function
        break;
    case 'remove':
        $obj->removeProduct($pid, $format); // Pass format to remove function
        break;
    case 'update':
        $obj->updateProduct($pid, $qty, $format, $price); // Pass format and price to update function
        break;
}
  

    echo $obj->totalProduct();
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}