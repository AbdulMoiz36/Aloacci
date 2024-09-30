<?php

class add_to_cart{
	function addProduct($pid, $qty, $format, $price) {
        // Store the quantity, format, and price in the session
        $_SESSION['cart'][$pid]['qty'] = $qty;
        $_SESSION['cart'][$pid]['format'] = $format; 
        $_SESSION['cart'][$pid]['price'] = $price; // Store the price for the selected format
    }
    
    function updateProduct($pid, $qty, $format, $price) {
        if (isset($_SESSION['cart'][$pid])) {
            // Update quantity, format, and price in the session
            $_SESSION['cart'][$pid]['qty'] = $qty;
            $_SESSION['cart'][$pid]['format'] = $format;
            $_SESSION['cart'][$pid]['price'] = $price; // Update the price for the selected format
        }
    }
	
	function removeProduct($pid){
		if(isset($_SESSION['cart'][$pid])){
			unset($_SESSION['cart'][$pid]);
		}
	}
	
	function emptyProduct(){
		unset($_SESSION['cart']);
	}
	
	function totalProduct(){
		if(isset($_SESSION['cart'])){
			return count($_SESSION['cart']);
		}else{
			return 0;
		}
		
	}

}