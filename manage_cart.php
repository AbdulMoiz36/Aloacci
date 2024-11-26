<?php
require "config.php";
require "functions.php";
require "add_cart_func.php";

try {
    $pid = get_safe_value($con, $_POST['pid']);
    $type = get_safe_value($con, $_POST['type']);
    $format = isset($_POST['format']) ? get_safe_value($con, $_POST['format']) : '';
    $price = isset($_POST['price']) ? get_safe_value($con, $_POST['price']) : 0;
    $qty = isset($_POST['qty']) ? get_safe_value($con, $_POST['qty']) : 0;
    $unitOfMeasure = isset($_POST['unitOfMeasure']) ? get_safe_value($con, $_POST['unitOfMeasure']) : ''; // Retrieve unitOfMeasure

    $productSoldQtyByProductId = productSoldQtyByProductId($con, $pid, $format);
    $productQty = productQty($con, $pid, $format);
    $pending_qty = $productQty - $productSoldQtyByProductId;

    if ($qty > $pending_qty && $type !== 'remove') {
        echo "not_available";
        exit;
    }

    $obj = new add_to_cart();

    switch ($type) {
        case 'add':
            $obj->addProduct($pid, $qty, $format, $price, $unitOfMeasure); // Pass unitOfMeasure
            break;
        case 'remove':
            $obj->removeProduct($pid, $format);
            break;
        case 'update':
            $obj->updateProduct($pid, $qty, $format, $price, $unitOfMeasure); // Pass unitOfMeasure
            break;
    }

    echo $obj->totalProduct();
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
