<?php

include "config.php";
include "functions.php";

// Restrict access to admin users only
isAdmin();

// Sanitize the input to prevent SQL injection
$_id = mysqli_real_escape_string($con, $_REQUEST['id']);

// Fetch product stock details
$select_stock = mysqli_query($con, "SELECT * FROM product_stock WHERE id = '$_id'");
if (!$select_stock) {
    die("Error fetching stock: " . mysqli_error($con));
}

$select_row = mysqli_fetch_array($select_stock);
$format_id = $select_row['format_id'];
$quantity = $select_row['qty'];

// Fetch format details
$select_format = mysqli_query($con, "SELECT qty FROM product_format WHERE id = '$format_id'");
if (!$select_format) {
    die("Error fetching format: " . mysqli_error($con));
}

$format_row = mysqli_fetch_array($select_format);
$format_qty = $format_row['qty'];

// Update the quantity in the product format table
$final_qty = $format_qty - $quantity;
$update = mysqli_query($con, "UPDATE product_format SET qty = '$final_qty' WHERE id = '$format_id'");
if (!$update) {
    die("Error updating format quantity: " . mysqli_error($con));
}

// Delete the stock entry
$delete = "DELETE FROM product_stock WHERE id = '$_id'";
$res = mysqli_query($con, $delete);
if (!$res) {
    die("Error deleting stock: " . mysqli_error($con));
}

// Redirect to the genre page
header("Location: stock");
exit;
