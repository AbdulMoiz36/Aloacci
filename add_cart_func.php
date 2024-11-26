<?php

class add_to_cart {
    function addProduct($pid, $qty, $format, $price, $unitOfMeasure) {
        $key = $pid . '_' . $format; 
        $_SESSION['cart'][$key]['qty'] = $qty;
        $_SESSION['cart'][$key]['format'] = $format;
        $_SESSION['cart'][$key]['price'] = $price;
        $_SESSION['cart'][$key]['unit_of_measure'] = $unitOfMeasure; // Store unit_of_measure
    }

    function updateProduct($pid, $qty, $format, $price, $unitOfMeasure) {
        $key = $pid . '_' . $format; 
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['qty'] = $qty;
            $_SESSION['cart'][$key]['format'] = $format;
            $_SESSION['cart'][$key]['price'] = $price;
            $_SESSION['cart'][$key]['unit_of_measure'] = $unitOfMeasure; // Update unit_of_measure
        }
    }

    function removeProduct($pid, $format) {
        $key = $pid . '_' . $format; 
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

