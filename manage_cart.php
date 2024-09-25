<?php
require "config.php";
require "functions.php";
require "add_cart_func.php";

try {
    $pid = get_safe_value($con, $_POST['pid']);
    $qty = get_safe_value($con, $_POST['qty']);
    $type = get_safe_value($con, $_POST['type']);

    $productSoldQtyByProductId = productSoldQtyByProductId($con, $pid);
    $productQty = productQty($con, $pid);

    $pending_qty = $productQty - $productSoldQtyByProductId;

    if ($qty > $pending_qty && $type !== 'remove') {
        echo "not_avaliable";
        exit;
    }

    $obj = new add_to_cart();

    switch ($type) {
        case 'add':
            $obj->addProduct($pid, $qty);
            break;
        case 'remove':
            $obj->removeProduct($pid);
            break;
        case 'update':
            $obj->updateProduct($pid, $qty);
            break;
    }

    echo $obj->totalProduct();
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
?>
