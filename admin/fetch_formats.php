<?php
include "config.php"; // Database connection

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $format_query = "SELECT id, format, unit_of_measure FROM product_format WHERE product_id = $product_id";
    $format_result = mysqli_query($con, $format_query);

    $formats = [];
    while ($format = mysqli_fetch_assoc($format_result)) {
        $formats[] = $format;
    }
    echo json_encode($formats);
}
?>