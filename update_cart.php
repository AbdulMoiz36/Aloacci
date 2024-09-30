<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN'] == '') {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

// Check if the product ID and quantity are set
if (isset($_POST['productId']) && isset($_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    // Update the quantity in the session
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['qty'] = $quantity;
    }

    echo json_encode(["status" => "success", "message" => "Cart updated."]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input."]);
}
?>
