<?php

include "config.php";
include "functions.php";

/* Restrict employee to access this page */
isAdmin();

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $_id = mysqli_real_escape_string($con, $_REQUEST['id']);

    // Define the base directory for the images
    $imageBaseDir = "../image/products/";

    // Remove all images stored in the `product_images` table
    $getImages = "SELECT image_path FROM product_images WHERE product_id = $_id";
    $resImages = mysqli_query($con, $getImages);

    if ($resImages && mysqli_num_rows($resImages) > 0) {
        while ($imageRow = mysqli_fetch_assoc($resImages)) {
            $imagePath = $imageBaseDir . basename($imageRow['image_path']); // Append to the base directory
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the file from the server
            }
        }
    }

    // Remove the image stored in the `image` column of the `product` table
    $getProductImage = "SELECT image FROM product WHERE id = $_id";
    $resProductImage = mysqli_query($con, $getProductImage);

    if ($resProductImage && mysqli_num_rows($resProductImage) > 0) {
        $productRow = mysqli_fetch_assoc($resProductImage);
        $productImagePath = $imageBaseDir . basename($productRow['image']); // Append to the base directory
        if (file_exists($productImagePath)) {
            unlink($productImagePath); // Delete the product image
        }
    }

    /* Delete related records in `product_images` table */
    $deleteImages = "DELETE FROM product_images WHERE product_id = $_id";
    mysqli_query($con, $deleteImages);

    /* Delete related records in `product_details` table */
    $deleteDetails = "DELETE FROM product_details WHERE product_id = $_id";
    mysqli_query($con, $deleteDetails);

    /* Delete related records in `product_format` table */
    $deleteFormats = "DELETE FROM product_format WHERE product_id = $_id";
    mysqli_query($con, $deleteFormats);

    /* Now delete the product from the `product` table */
    $deleteProduct = "DELETE FROM product WHERE id = $_id";
    $resProduct = mysqli_query($con, $deleteProduct);

    /* Check if the query executed successfully and redirect */
    if ($resProduct) {
        header("Location:product");
    } else {
        echo "Error deleting product.";
    }
} else {
    echo "Invalid product ID.";
}
?>
