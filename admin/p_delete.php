<?php

include "config.php";
include "functions.php";

/* Restrict employee to access this page */
isAdmin();

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $_id = mysqli_real_escape_string($con, $_REQUEST['id']);

    /* Delete related records in product_details first to maintain referential integrity */
    $deleteDetails = "DELETE FROM product_details WHERE product_id = $_id";
    $resDetails = mysqli_query($con, $deleteDetails);

    /* Delete related records in product_format first to maintain referential integrity */
    $deleteFormats = "DELETE FROM product_format WHERE product_id = $_id";
    $resFormats = mysqli_query($con, $deleteFormats);

    /* Now delete the product from the product table */
    $deleteProduct = "DELETE FROM product WHERE id = $_id";
    $resProduct = mysqli_query($con, $deleteProduct);

    /* Check if the query executed successfully and redirect */
    if($resProduct) {
        header("Location:product");
    } else {
        echo "Error deleting product.";
    }
} else {
    echo "Invalid product ID.";
}