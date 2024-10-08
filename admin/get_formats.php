<?php
include "config.php";

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Fetch formats from the product_format table
    $query = "SELECT * FROM product_format WHERE product_id='$product_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option selected disabled>Select Product Variant</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['id'].'">'.$row['format'].'</option>'; // Adjust the field names as needed
        }
    } else {
        echo '<option selected disabled>No Product Variants Available</option>';
    }
}
?>
