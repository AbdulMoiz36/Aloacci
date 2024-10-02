<?php
include "config.php";

if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    $query = "SELECT * FROM sub_categories WHERE category_id='$category_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option selected disabled>Select Sub Category</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['id'].'">'.$row['sub_categories'].'</option>';
        }
    } else {
        echo '<option selected disabled>No Sub Categories Available</option>';
    }
}