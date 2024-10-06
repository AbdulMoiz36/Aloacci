<?php

class add_to_cart {
    function addProduct($pid, $qty, $format, $price) {
        // Use a combination of product ID and format as the key
        $key = $pid . '_' . $format; 
        $_SESSION['cart'][$key]['qty'] = $qty;
        $_SESSION['cart'][$key]['format'] = $format; 
        $_SESSION['cart'][$key]['price'] = $price;
    }
    
    function updateProduct($pid, $qty, $format, $price) {
        $key = $pid . '_' . $format; // Use the same key for updates
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['qty'] = $qty;
            $_SESSION['cart'][$key]['format'] = $format;
            $_SESSION['cart'][$key]['price'] = $price;
        }
    }
    
    function removeProduct($pid, $format) {
        $key = $pid . '_' . $format; // Use the format to remove the correct entry
        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }
    }
    
    function emptyProduct() {
        unset($_SESSION['cart']);
    }
    
    function totalProduct() {
        return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    }
}
