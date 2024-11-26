<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$msg = '';
$category_id = '';
$sub_category_id = '';
$name = '';
$brief = '';
$description = '';
$image = '';
$all_images = [];
$image2 = '';
$image3 = '';
$image_required = 'required';

// Initializing the format-related variables as arrays
$formats = isset($_POST['formats']) ? $_POST['formats'] : [];
$prices = isset($_POST['prices']) ? $_POST['prices'] : [];
$sale_prices = isset($_POST['sale_prices']) ? $_POST['sale_prices'] : [];
$sale_units = isset($_POST['sale_units']) ? $_POST['sale_units'] : [];
$unit_of_measures = isset($_POST['unit_of_measures']) ? $_POST['unit_of_measures'] : [];

// Retrieve other form data
$gender_ids = isset($_POST['gender_id']) ? $_POST['gender_id'] : [];
$genre_ids = isset($_POST['genre_id']) ? $_POST['genre_id'] : [];
$type_ids = isset($_POST['type_id']) ? $_POST['type_id'] : [];
$season_ids = isset($_POST['season_id']) ? $_POST['season_id'] : [];

// Get selected sillage and lasting
$sillage_id = isset($_POST['sillage_id']) ? $_POST['sillage_id'] : null;
$lasting_id = isset($_POST['lasting_id']) ? $_POST['lasting_id'] : null;



if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $_id = get_safe_value($con, $_GET['id']);


    // Fetch product details from product table
    $res = mysqli_query($con, "SELECT * FROM product WHERE id=$_id");
    $check = mysqli_num_rows($res);

    if ($check > 0) {
        $row = mysqli_fetch_array($res);
        $category_id = $row['category_id'];
        $sub_category_id = $row['sub_category_id'];
        $name = $row['name'];
        $image = $row['image'];
        $brief = $row['brief'];
        $description = $row['description'];
        $image2 = $row['image2'];
        $image3 = $row['image3'];
        // Fetch types, genders, and genres from product_details table
        $details_res = mysqli_query($con, "SELECT * FROM product_details WHERE product_id=$_id");
        $selected_genders = [];
        $selected_genres = [];
        $selected_types = [];
        $selected_seasons = [];
        $selected_sillages = [];
        $selected_lastings = [];

        while ($detail_row = mysqli_fetch_assoc($details_res)) {
            $selected_genders[] = $detail_row['gender_id'];
            $selected_genres[] = $detail_row['genre_id'];
            $selected_types[] = $detail_row['type_id'];
            $selected_seasons[] = $detail_row['season_id'];
            $selected_sillages[] = $detail_row['sillage_id'];
            $selected_lastings[] = $detail_row['lasting_id'];
        }

        // Fetch product formats from the product_format table
        $format_res = mysqli_query($con, "SELECT * FROM product_format WHERE product_id=$_id");
        while ($format_row = mysqli_fetch_assoc($format_res)) {
            $formats[] = $format_row['format'];
            $prices[] = $format_row['price'];
            $unit_of_measures[] = $format_row['unit_of_measure'];
            $qtys[] = $format_row['qty'];
            $sale_prices[] = $format_row['sale_price'];
            $sale_units[] = $format_row['unit_of_sale'];
        }
        // Fetch product Images from the product_images table
        $image_res = mysqli_query($con, "SELECT image_path FROM product_images WHERE product_id=$_id");
        while ($image_row = mysqli_fetch_assoc($image_res)) {
            $all_images[] = $image_row['image_path'];
        }
    } else {
        echo "<script>window.location.href='product'</script>";
        die();
    }
}

if (isset($_REQUEST['submit'])) {
    $category_id = get_safe_value($con, $_REQUEST['categories_id']);
    $sub_category_id = get_safe_value($con, $_REQUEST['sub_categories_id']);
    $name = get_safe_value($con, $_REQUEST['name']);
    $image = get_safe_value($con, $_REQUEST['single_selected_image']);
    $brief = get_safe_value($con, $_REQUEST['brief']);
    $description = get_safe_value($con, $_REQUEST['description']);
    // Retrieve other form data
    $gender_ids = isset($_POST['gender_id']) ? $_POST['gender_id'] : [];
    $genre_ids = isset($_POST['genre_id']) ? $_POST['genre_id'] : [];
    $type_ids = isset($_POST['type_id']) ? $_POST['type_id'] : [];
    $season_ids = isset($_POST['season_id']) ? $_POST['season_id'] : [];

    // Get selected sillage and lasting
    $sillage_id = isset($_POST['sillage_id']) ? $_POST['sillage_id'] : null;
    $lasting_id = isset($_POST['lasting_id']) ? $_POST['lasting_id'] : null;

    // Fetch the dynamic formats, prices, and qty arrays
    // Initializing the format-related variables as arrays
    $formats = isset($_POST['formats']) ? $_POST['formats'] : [];
    $prices = isset($_POST['prices']) ? $_POST['prices'] : [];
    $sale_prices = isset($_POST['sale_prices']) ? $_POST['sale_prices'] : [];
    $sale_units = isset($_POST['sale_units']) ? $_POST['sale_units'] : [];
    $unit_of_measures = isset($_POST['unit_of_measures']) ? $_POST['unit_of_measures'] : [];

    // Validation for product existence
    $res = mysqli_query($con, "SELECT * FROM product WHERE name='$name'");
    $check = mysqli_num_rows($res);

    if ($check > 0 && (!isset($_GET['id']) || $_GET['id'] != $row['id'])) {
        $msg = "Product Already Exists";
    }

    // Image validation
    if ($_FILES['image']['type'] != '' && !in_array($_FILES['image']['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
        $msg = "Please select only png, jpg, or jpeg format for Image 1";
    }

    if ($_FILES['image2']['type'] != '' && !in_array($_FILES['image2']['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
        $msg = "Please select only png, jpg, or jpeg format for Image 2";
    }
    if ($_FILES['image3']['type'] != '' && !in_array($_FILES['image3']['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
        $msg = "Please select only png, jpg, or jpeg format for Image 3";
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {

            // Update product details
            mysqli_query($con, "UPDATE product SET category_id='$category_id', sub_category_id='$sub_category_id', name='$name', brief='$brief', description='$description', image='$image', image2='$image2', image3='$image3' WHERE id='$_id'");


            // Remove old product details and formats
            mysqli_query($con, "DELETE FROM product_details WHERE product_id='$_id'");
            // mysqli_query($con, "DELETE FROM product_format WHERE product_id='$_id'");
            mysqli_query($con, "DELETE FROM product_images WHERE product_id='$_id'");

            foreach ($gender_ids as $gender_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, gender_id) VALUES ('$_id', '$gender_id')");
            }
            foreach ($genre_ids as $genre_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, genre_id) VALUES ('$_id', '$genre_id')");
            }
            foreach ($type_ids as $type_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, type_id) VALUES ('$_id', '$type_id')");
            }
            foreach ($season_ids as $season_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, season_id) VALUES ('$_id', '$season_id')");
            }

            // Insert selected sillage and lasting
            if ($sillage_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, sillage_id) VALUES ('$_id', '$sillage_id')");
            }
            if ($lasting_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, lasting_id) VALUES ('$_id', '$lasting_id')");
            }


            // Prepare format updates and inserts
foreach ($formats as $key => $format) {
    $price = isset($prices[$key]) ? $prices[$key] : '';
    $qty = isset($qtys[$key]) ? $qtys[$key] : '';
    $sale_price = isset($sale_prices[$key]) ? $sale_prices[$key] : '';
    $unit_of_sale = isset($sale_units[$key]) ? $sale_units[$key] : '';
    $unit_of_measure = isset($unit_of_measures[$key]) ? $unit_of_measures[$key] : '';

    // Check if the format already exists in the database
    $checkQuery = "SELECT id FROM product_format WHERE product_id='$_id' AND format='$format'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If the format exists, update the existing record
        $row = mysqli_fetch_assoc($checkResult);
        $formatId = $row['id'];
        $updateQuery = "
            UPDATE product_format 
            SET unit_of_measure='$unit_of_measure', price='$price', qty='$qty', sale_price='$sale_price', unit_of_sale='$unit_of_sale' 
            WHERE id='$formatId'";
        mysqli_query($con, $updateQuery);
    } else {
        // If the format does not exist, insert a new record
        $insertQuery = "
            INSERT INTO product_format (product_id, format, unit_of_measure, price, qty, sale_price, unit_of_sale) 
            VALUES ('$_id', '$format', '$unit_of_measure', '$price', '$qty', '$sale_price', '$unit_of_sale')";
        mysqli_query($con, $insertQuery);
    }
}


            // Process selected image paths (decode the JSON string)
            if (isset($_POST['selected_images']) && !empty($_POST['selected_images'])) {
                $selected_images = json_decode($_POST['selected_images'], true);  // Decode JSON into array
                if (is_array($selected_images)) {
                    foreach ($selected_images as $image_name) {
                        $image_name = mysqli_real_escape_string($con, $image_name); // Escape the image name for security
                        // Insert the image path into the product_images table
                        $insert_image_query = "INSERT INTO product_images (product_id, image_path) 
                                    VALUES ('$_id', '$image_name')";
                        mysqli_query($con, $insert_image_query);
                    }
                }
            }

            // Redirect or show success message
            echo "<script>window.location.href='manage_product?id=$_id'</script>";
            exit();
        } else {

            // Insert the new product first (without images)
            mysqli_query($con, "INSERT INTO product (category_id, sub_category_id, name, brief, description, status, image) 
VALUES ('$category_id', '$sub_category_id', '$name', '$brief', '$description', '1', '$image')");
            $product_id = mysqli_insert_id($con);  // Get the newly inserted product ID

            // Process selected image paths (decode the JSON string)
            if (isset($_POST['selected_images']) && !empty($_POST['selected_images'])) {
                $selected_images = json_decode($_POST['selected_images'], true);  // Decode JSON into array
                if (is_array($selected_images)) {
                    foreach ($selected_images as $image_name) {
                        $image_name = mysqli_real_escape_string($con, $image_name); // Escape the image name for security
                        // Insert the image path into the product_images table
                        $insert_image_query = "INSERT INTO product_images (product_id, image_path) 
                                    VALUES ('$product_id', '$image_name')";
                        mysqli_query($con, $insert_image_query);
                    }
                }
            }

            // Insert gender, genre, type, and season details
            foreach ($gender_ids as $gender_id) {
                $gender_id = mysqli_real_escape_string($con, $gender_id); // Escape for security
                mysqli_query($con, "INSERT INTO product_details (product_id, gender_id) VALUES ('$product_id', '$gender_id')");
            }

            foreach ($genre_ids as $genre_id) {
                $genre_id = mysqli_real_escape_string($con, $genre_id); // Escape for security
                mysqli_query($con, "INSERT INTO product_details (product_id, genre_id) VALUES ('$product_id', '$genre_id')");
            }

            foreach ($type_ids as $type_id) {
                $type_id = mysqli_real_escape_string($con, $type_id); // Escape for security
                mysqli_query($con, "INSERT INTO product_details (product_id, type_id) VALUES ('$product_id', '$type_id')");
            }

            foreach ($season_ids as $season_id) {
                $season_id = mysqli_real_escape_string($con, $season_id); // Escape for security
                mysqli_query($con, "INSERT INTO product_details (product_id, season_id) VALUES ('$product_id', '$season_id')");
            }

            // Insert selected sillage and lasting
            if ($sillage_id) {
                $sillage_id = mysqli_real_escape_string($con, $sillage_id); // Escape for security
                mysqli_query($con, "INSERT INTO product_details (product_id, sillage_id) VALUES ('$product_id', '$sillage_id')");
            }

            if ($lasting_id) {
                $lasting_id = mysqli_real_escape_string($con, $lasting_id); // Escape for security
                mysqli_query($con, "INSERT INTO product_details (product_id, lasting_id) VALUES ('$product_id', '$lasting_id')");
            }

            // Insert formats
            foreach ($formats as $key => $format) {
                $format = mysqli_real_escape_string($con, $format); // Escape for security
                $price = isset($prices[$key]) ? mysqli_real_escape_string($con, $prices[$key]) : 0;
                $sale_price = isset($sale_prices[$key]) ? mysqli_real_escape_string($con, $sale_prices[$key]) : 0;
                $sale_unit = isset($sale_units[$key]) ? mysqli_real_escape_string($con, $sale_units[$key]) : '';
                $unit_of_measure = isset($unit_of_measures[$key]) ? mysqli_real_escape_string($con, $unit_of_measures[$key]) : '';

                if (!empty($format)) {
                    $insert_format_query = "INSERT INTO product_format (product_id, format, unit_of_measure, price, sale_price, unit_of_sale) 
                                VALUES ('$product_id', '$format', '$unit_of_measure', '$price', '$sale_price', '$sale_unit')";
                    mysqli_query($con, $insert_format_query);
                }
            }

            // Redirect or show success message
            echo "<script>window.location.href='product'</script>";
            exit();
        }
    }
}

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Products</h4><span>Form</span>
            </div>
            <div style="color: red; margin: 10px;">
                <?= $msg ?>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="card-body card-block">
                    <div class="form-row">
                        <!-- Categories -->
                        <div class="form-group col-6">
                            <label for="categories" class="form-control-label">Categories</label>
                            <select class="form-control" name="categories_id" id="category">
                                <option>Select Category</option>
                                <?php
                                $categories = mysqli_query($con, "SELECT * FROM categories");
                                while ($row = mysqli_fetch_array($categories)) {
                                    $selected = ($row['id'] == $category_id) ? 'selected' : '';
                                    echo "<option value='{$row['id']}' $selected>{$row['categories']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Sub-Categories -->
                        <div class="form-group col-6">
                            <label for="sub_categories" class="form-control-label">Sub Categories</label>
                            <select class="form-control" name="sub_categories_id" id="sub_category">
                                <option>Select Sub Category</option>
                                <!-- Subcategories will be loaded by AJAX based on the selected category -->
                            </select>
                        </div>
                    </div>
                    <!-- categories Scrippting -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            var category_id = $('#category').val();
                            var selected_sub_category_id = "<?php echo $sub_category_id; ?>";
                            // Load subcategories if a category is already selected
                            if (category_id) {
                                $.ajax({
                                    url: 'get_subcategories',
                                    type: 'POST',
                                    data: {
                                        category_id: category_id
                                    },
                                    success: function(data) {
                                        $('#sub_category').html(data);
                                        // Set the selected subcategory after the options are loaded
                                        $('#sub_category').val(selected_sub_category_id);
                                    }
                                });
                            }
                            // Load subcategories dynamically when the category is changed
                            $('#category').change(function() {
                                var category_id = $(this).val();
                                $.ajax({
                                    url: 'get_subcategories',
                                    type: 'POST',
                                    data: {
                                        category_id: category_id
                                    },
                                    success: function(data) {
                                        $('#sub_category').html(data);
                                    }
                                });
                            });
                        });
                    </script>
                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="product" class="form-control-label">Product name</label>
                        <input type="text" name="name" placeholder="Enter Product name" class="form-control" required
                            value="<?= $name ?>">
                    </div>
                    <style>
                        /* Wrapper for the toggle */
                        .toggle-switch {
                            position: relative;
                            display: inline-block;
                            width: 52px;
                            /* Toggle width */
                            height: 20px;
                            /* Toggle height */
                        }

                        /* Hide the default checkbox */
                        .toggle-switch input {
                            opacity: 0;
                            width: 0;
                            height: 0;
                        }

                        /* Create the slider (background and circle) */
                        .slider {
                            position: absolute;
                            cursor: pointer;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            background-color: #ccc;
                            /* Default background */
                            border-radius: 30px;
                            /* Rounded edges */
                            transition: background-color 0.3s ease;
                        }

                        /* Circle inside the toggle */
                        .slider:before {
                            content: "";
                            position: absolute;
                            height: 17px;
                            width: 17px;
                            left: 2px;
                            bottom: 2px;
                            background-color: white;
                            /* Circle color */
                            border-radius: 50%;
                            transition: transform 0.3s ease;
                        }

                        /* When checked, change background and move the circle */
                        input:checked+.slider {
                            background-color: #70c745;
                            /* Green active background */
                        }

                        input:checked+.slider:before {
                            transform: translateX(30px);
                            /* Move circle to the right */
                        }
                    </style>
                    <hr>
                    <div id="formats-container">
                        <!-- Quick Sale Toggle -->
                        <div style="display: flex; justify-content: end; align-items: center;">
                            <p style="font-size: x-small; color:#888; line-height:12px;margin-bottom:2px;">Enable to apply same sale on every <br> product, From 1st format.</p>
                            </label>
                        </div>
                        <div style="display: flex; justify-content: end; align-items: center; gap: 8px; margin-right:8px;">
                            <label for="quick-sale-toggle">Quick Sale</label>
                            <label class="toggle-switch">
                                <input type="checkbox" id="quick-sale-toggle">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <?php
                        // Fetch units of measure from the database
                        $unitsQuery = "SELECT name FROM units_of_measure"; // Replace with your table and column names
                        $unitsResult = mysqli_query($con, $unitsQuery);

                        $unitsOptions = []; // Initialize an empty array

                        if ($unitsResult) {
                            while ($row = mysqli_fetch_assoc($unitsResult)) {
                                $unitsOptions[] = $row['name']; // Add each unit to the array
                            }
                        }
                        // Check if there are existing formats
                        if (!empty($formats)) {

                            // Loop through the formats array and generate input fields for each format
                            for ($i = 0; $i < count($formats); $i++) {
                        ?>
                                <div class="format-container form-row" id="format-row-<?= $i + 1 ?>">
                                    <div class="form-group col-2">
                                        <label for="format<?= $i + 1 ?>" class="form-control-label">Format</label>
                                        <input type="text" name="formats[]" class="form-control" value="<?= $formats[$i] ?? '' ?>" <?= $i == 0 ? 'required' : '' ?> />
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="unit<?= $i + 1 ?>" class="form-control-label">Unit of Measure</label>
                                        <select name="unit_of_measures[]" class="form-control">
                                            <option value="" <?= isset($unit_of_measures[$i]) && $unit_of_measures[$i] === '' ? 'selected' : '' ?>>None</option>
                                            <?php foreach ($unitsOptions as $unit) { ?>
                                                <option value="<?= $unit ?>" <?= isset($unit_of_measures[$i]) && $unit_of_measures[$i] === $unit ? 'selected' : '' ?>><?= $unit ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-2">
                                        <label for="price<?= $i + 1 ?>" class="form-control-label">Price</label>
                                        <input type="number" step="0.01" name="prices[]" class="form-control" value="<?= $prices[$i] ?? '' ?>" <?= $i == 0 ? 'required' : '' ?> accept="" />
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="sale_price<?= $i + 1 ?>" class="form-control-label">Sale Rate</label>
                                        <input type="number" step="0.01" name="sale_prices[]" class="form-control sale-price" value="<?= $sale_prices[$i] ?? '' ?>" />
                                        <?= $i == 0 ? '<p style="color: #888; font-size: x-small;line-height: 12px;">Sale Price and % will be deducted from original price</p>' : '' ?>

                                    </div>
                                    <div class="form-group col-2">
                                        <label for="sale_unit<?= $i + 1 ?>" class="form-control-label">Sale Unit</label>
                                        <select name="sale_units[]" class="form-control sale-unit">
                                            <option value="Price" <?= isset($sale_units[$i]) && $sale_units[$i] === 'Price' ? 'selected' : '' ?>>Price</option>
                                            <option value="Percentage" <?= isset($sale_units[$i]) && $sale_units[$i] === 'Percentage' ? 'selected' : '' ?>>Percentage</option>
                                        </select>
                                    </div>
                                    <?php if ($i > 0) { ?>
                                        <div class="form-group cols-1">
                                            <button type="button" class="btn btn-danger delete-format-btn" data-row="format-row-<?= $i + 1 ?>" style="margin-top: 55%; margin-left: 20px;">X</button>
                                        </div>
                                    <?php } ?>
                                </div>

                            <?php
                            }
                        } else {
                            ?>
                            <div class="format-container form-row" id="format-row">
                                <div class="form-group col-3">
                                    <label for="format" class="form-control-label">Format</label>
                                    <input type="text" name="formats[]" placeholder="Enter Product Format" class="form-control" required />
                                </div>
                                <div class="form-group col-2">
                                    <label for="unit_of_measures" class="form-control-label">Unit of Measure</label>
                                    <select name="unit_of_measures[]" class="form-control">
                                        <option value="">None</option>
                                        <?php foreach ($unitsOptions as $unit) { ?>
                                            <option value="<?= $unit ?>"><?= $unit ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-2">
                                    <label for="price" class="form-control-label">Price</label>
                                    <input type="number" name="prices[]" placeholder="Enter Price" class="form-control" required />
                                </div>
                                <div class="form-group col-2">
                                    <label for="sale_price" class="form-control-label">Sale</label>
                                    <input type="number" name="sale_prices[]" placeholder="Enter Sale Value" class="form-control sale-price" />
                                    <p style="color: #888; font-size: x-small; line-height: 12px;">Sale Price and % will be deducted from original price</p>

                                </div>
                                <div class="form-group col-2">
                                    <label for="sale_unit" class="form-control-label">Sale Unit</label>
                                    <select name="sale_units[]" class="form-control sale-unit">
                                        <option value="Price">Price</option>
                                        <option value="Percentage">Percentage</option>
                                    </select>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Get references to initial elements
                            const firstSalePrice = document.querySelector("input[name='sale_prices[]']");
                            const firstSaleUnit = document.querySelector("select[name='sale_units[]']");
                            const quickSaleToggle = document.getElementById("quick-sale-toggle");
                            const addFormatBtn = document.getElementById("add-format-btn");
                            const formatsContainer = document.getElementById("formats-container");

                            // Variable to track if syncing is enabled
                            let isSyncEnabled = false;

                            // Function to sync sale values to all other rows
                            const syncSaleValues = () => {
                                if (isSyncEnabled) {
                                    const salePriceValue = firstSalePrice.value;
                                    const saleUnitValue = firstSaleUnit.value;

                                    // Get all sale price and sale unit fields
                                    const allSalePrices = document.querySelectorAll("input[name='sale_prices[]']");
                                    const allSaleUnits = document.querySelectorAll("select[name='sale_units[]']");

                                    allSalePrices.forEach((input, index) => {
                                        if (index > 0) {
                                            input.value = salePriceValue;
                                        }
                                    });

                                    allSaleUnits.forEach((select, index) => {
                                        if (index > 0) {
                                            select.value = saleUnitValue;
                                        }
                                    });
                                }
                            };

                            // Event listener for the Quick Sale toggle
                            quickSaleToggle.addEventListener("change", function() {
                                isSyncEnabled = this.checked; // Enable syncing when checked
                            });

                            // Add event listeners for the first row fields
                            firstSalePrice.addEventListener("input", function() {
                                if (isSyncEnabled) syncSaleValues();
                            });

                            firstSaleUnit.addEventListener("change", function() {
                                if (isSyncEnabled) syncSaleValues();
                            });

                            // Function to add event listeners to new rows
                            const addDynamicListeners = (row) => {
                                const salePrice = row.querySelector("input[name='sale_prices[]']");
                                const saleUnit = row.querySelector("select[name='sale_units[]']");
                                if (salePrice && saleUnit) {
                                    salePrice.addEventListener("input", function() {
                                        if (isSyncEnabled && salePrice === firstSalePrice) {
                                            syncSaleValues();
                                        }
                                    });

                                    saleUnit.addEventListener("change", function() {
                                        if (isSyncEnabled && saleUnit === firstSaleUnit) {
                                            syncSaleValues();
                                        }
                                    });
                                }
                            };

                            // Add Format Button functionality
                            let formatRowCount = <?= count($formats) ?>; // Start from the current count

                            addFormatBtn.addEventListener("click", function() {
                                formatRowCount++;

                                // Create a new format row
                                const newRow = document.createElement("div");
                                newRow.classList.add("form-row", "format-row");
                                newRow.id = `format-row-${formatRowCount}`;

                                newRow.innerHTML = `
            <div class="form-group col-2">
                <label for="format${formatRowCount}" class="form-control-label">Format</label>
                <input type="text" name="formats[]" placeholder="Enter Product Format" class="form-control" required>
            </div>
            <div class="form-group col-2">
                <label for="unit" class="form-control-label">Unit of Measure</label>
                <select name="unit_of_measures[]" class="form-control">
                    <option value="0">None</option>
                    <?= implode('', array_map(function ($unit) {
                        return "<option value='$unit'>$unit</option>";
                    }, $unitsOptions)); ?>
                </select>
            </div>
            <div class="form-group col-2">
                <label for="price${formatRowCount}" class="form-control-label">Price</label>
                <input type="number" name="prices[]" placeholder="Enter Price" class="form-control" required>
            </div>
            <div class="form-group col-2">
                <label for="sale_price${formatRowCount}" class="form-control-label">Sale Rate</label>
                <input type="number" name="sale_prices[]" placeholder="Enter Sale Rate" class="form-control">
            </div>
            <div class="form-group col-2">
                <label for="sale_unit${formatRowCount}" class="form-control-label">Sale Unit</label>
                <select name="sale_units[]" class="form-control">
                    <option value="Price">Price</option>
                    <option value="Percentage">Percentage</option>
                </select>
            </div>
            <div class="form-group col-1">
                <button type="button" class="btn btn-danger delete-format-btn" data-row="format-row-${formatRowCount}" style="margin-top: 30px;">X</button>
            </div>
        `;

                                // Append new row and add event listeners
                                formatsContainer.appendChild(newRow);
                                addDynamicListeners(newRow);

                                // Add delete button functionality
                                const deleteBtn = newRow.querySelector(".delete-format-btn");
                                deleteBtn.addEventListener("click", function() {
                                    formatsContainer.removeChild(newRow);
                                });
                            });

                            // Add event listeners for any pre-existing rows
                            const existingRows = document.querySelectorAll(".format-row");
                            existingRows.forEach((row) => addDynamicListeners(row));
                        });


                        document.addEventListener("DOMContentLoaded", function() {
                            // Select all number input fields
                            const numberInputs = document.querySelectorAll("input[type='number']");

                            numberInputs.forEach((input) => {
                                // Disable scroll on number inputs without blocking page scroll
                                input.addEventListener("wheel", function(event) {
                                    if (document.activeElement === input) {
                                        event.preventDefault(); // Prevent number input value change
                                    }
                                });
                            });
                        });



                        document.addEventListener("DOMContentLoaded", function() {
                            // Get the sale price and sale unit fields for the first format row
                            const firstSalePrice = document.querySelector("input[name='sale_prices[]']");
                            const firstSaleUnit = document.querySelector("select[name='sale_units[]']");

                            // Get all other sale price and sale unit fields
                            const allSalePrices = document.querySelectorAll("input[name='sale_prices[]']");
                            const allSaleUnits = document.querySelectorAll("select[name='sale_units[]']");

                            // Get the quick sale toggle checkbox
                            const quickSaleToggle = document.getElementById("quick-sale-toggle");

                            // Variable to track if syncing is enabled
                            let isSyncEnabled = false;

                            // Function to sync values of sale price and sale unit
                            const syncSaleValues = () => {
                                if (isSyncEnabled) { // Only sync when Quick Sale is enabled
                                    const salePriceValue = firstSalePrice.value;
                                    const saleUnitValue = firstSaleUnit.value;

                                    allSalePrices.forEach(input => {
                                        input.value = salePriceValue;
                                    });

                                    allSaleUnits.forEach(select => {
                                        select.value = saleUnitValue;
                                    });
                                }
                            };

                            // Event listener for quick sale toggle
                            quickSaleToggle.addEventListener("change", function() {
                                if (this.checked) {
                                    isSyncEnabled = true; // Enable syncing when checked
                                } else {
                                    isSyncEnabled = false; // Disable syncing when unchecked
                                }
                            });

                            // Event listeners for the first format's sale price and sale unit fields
                            firstSalePrice.addEventListener("input", syncSaleValues);
                            firstSaleUnit.addEventListener("change", syncSaleValues);
                        });
                    </script>
                    <!-- Add Format Button -->
                    <button type="button" id="add-format-btn" class="btn btn-primary">Add Format</button>

                    <style>
                        /* Hide increment and decrement buttons for all number inputs */
                        input[type="number"]::-webkit-inner-spin-button,
                        input[type="number"]::-webkit-outer-spin-button {
                            -webkit-appearance: none;
                            /* Safari and Chrome */
                            margin: 0;
                        }
                    </style>
                    <br><br>
                    <hr>
                    <!-- Queries For Dropdowns -->
                    <?php

                    if (isset($_GET['id']) && $_GET['id'] != '') {

                        // Fetch the types associated with the product
                        $result = mysqli_query($con, "SELECT * FROM product_details WHERE product_id = '$_id'");
                        $selected_genders = [];
                        $selected_genres = [];
                        $selected_types = [];
                        $selected_seasons = [];
                        $selected_sillages = [];
                        $selected_lastings = [];

                        while ($row = mysqli_fetch_array($result)) {
                            $selected_genders[] = $row['gender_id'];
                            $selected_genres[] = $row['genre_id'];
                            $selected_types[] = $row['type_id'];
                            $selected_seasons[] = $row['season_id'];
                            $selected_sillages[] = $row['sillage_id'];
                            $selected_lastings[] = $row['lasting_id'];
                        }
                    } else {
                        // If product_id is not set, initialize selected_types as an empty array
                        $selected_genders = [];
                        $selected_genres = [];
                        $selected_types = [];
                        $selected_seasons = [];
                        $selected_sillages = [];
                        $selected_lastings = [];
                    }

                    ?>
                    <!-- Types Drpdowns -->
                    <div class="form-row">
                        <!-- Gender Dropdown -->
                        <div class="form-group col-4">
                            <label for="gender" class="form-control-label">Gender</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control"
                                    style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button"
                                    id="genderDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Gender
                                </button>
                                <div class="dropdown-menu" aria-labelledby="genderDropdown">
                                    <div class="mb-3">
                                        <input type="text" id="genderSearch" class="form-control" placeholder="Search..."
                                            onkeyup="filterDropdown(this)">
                                    </div>
                                    <div class="form-check">
                                        <?php
                                        $select_gender = mysqli_query($con, "SELECT * FROM gender");
                                        while ($gender_row = mysqli_fetch_array($select_gender)) {
                                            $selected = in_array($gender_row['id'], $selected_genders) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                            <input type='checkbox' class='form-check-input gender-checkbox' name='gender_id[]' value='" . $gender_row['id'] . "' $selected onchange='updateSelectedOptions(\"gender-checkbox\")'>
                            " . $gender_row['gender'] . "
                        </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Selected Gender Display -->
                            <div id="selectedGenders" class="mt-2"></div>
                        </div>

                        <!-- Genre Dropdown -->
                        <div class="form-group col-4">
                            <label for="genre" class="form-control-label">Genre</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control"
                                    style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button"
                                    id="genreDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Genre
                                </button>
                                <div class="dropdown-menu" aria-labelledby="genreDropdown">
                                    <!-- Search box for filtering options -->
                                    <div class="mb-3">
                                        <input type="text" id="genreSearch" class="form-control" placeholder="Search..."
                                            onkeyup="filterDropdown(this)">
                                    </div>
                                    <div class="form-check">
                                        <?php
                                        $select_genre = mysqli_query($con, "SELECT * FROM genre");
                                        while ($genre_row = mysqli_fetch_array($select_genre)) {
                                            $selected = in_array($genre_row['id'], $selected_genres) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                                <input type='checkbox' class='form-check-input genre-checkbox' name='genre_id[]' value='" . $genre_row['id'] . "' $selected onchange='updateSelectedOptions(\"genre-checkbox\")'>
                                " . $genre_row['genre'] . "
                            </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div id="selectedGenres" class="mt-2"></div>
                        </div>

                        <!-- Type Dropdown -->
                        <div class="form-group col-4">
                            <label for="type" class="form-control-label">Type</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control"
                                    style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button"
                                    id="typeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Type
                                </button>
                                <div class="dropdown-menu" aria-labelledby="typeDropdown">
                                    <!-- Search box for filtering options -->
                                    <div class="mb-3">
                                        <input type="text" id="typeSearch" class="form-control" placeholder="Search..."
                                            onkeyup="filterDropdown(this)">
                                    </div>
                                    <div class="form-check">
                                        <?php
                                        $select_type = mysqli_query($con, "SELECT * FROM type");
                                        while ($type_row = mysqli_fetch_array($select_type)) {
                                            $selected = in_array($type_row['id'], $selected_types) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                                <input type='checkbox' class='form-check-input type-checkbox' name='type_id[]' value='" . $type_row['id'] . "' $selected onchange='updateSelectedOptions(\"type-checkbox\")'>
                                " . $type_row['type'] . "
                            </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div id="selectedTypes" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- Season Dropdown -->
                        <div class="form-group col-4">
                            <label for="season" class="form-control-label">Season</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control"
                                    style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button"
                                    id="seasonDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Season
                                </button>
                                <div class="dropdown-menu" aria-labelledby="seasonDropdown">
                                    <!-- Search box for filtering options -->
                                    <div class="mb-3">
                                        <input type="text" id="seasonSearch" class="form-control" placeholder="Search..."
                                            onkeyup="filterDropdown(this)">
                                    </div>
                                    <div class="form-check">
                                        <?php
                                        $select_season = mysqli_query($con, "SELECT * FROM season");
                                        while ($season_row = mysqli_fetch_array($select_season)) {
                                            $selected = in_array($season_row['id'], $selected_seasons) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                                <input type='checkbox' class='form-check-input season-checkbox' name='season_id[]' value='" . $season_row['id'] . "' $selected onchange='updateSelectedOptions(\"season-checkbox\")'>
                                " . $season_row['season'] . "
                            </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div id="selectedSeasons" class="mt-2"></div>
                        </div>

                        <!-- Sillage Dropdown -->
                        <div class="form-group col-4">
                            <label for="sillage" class="form-control-label">Sillage</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control"
                                    style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button"
                                    id="sillageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Sillage
                                </button>
                                <div class="dropdown-menu" aria-labelledby="sillageDropdown">
                                    <!-- Search box for filtering options -->
                                    <div class="mb-3">
                                        <input type="text" id="sillageSearch" class="form-control" placeholder="Search..."
                                            onkeyup="filterDropdown(this)">
                                    </div>
                                    <div class="form-check">
                                        <?php
                                        $select_sillage = mysqli_query($con, "SELECT * FROM sillage");
                                        while ($sillage_row = mysqli_fetch_array($select_sillage)) {
                                            $selected = in_array($sillage_row['id'], $selected_sillages) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                            <input type='radio' class='form-check-input sillage-checkbox' name='sillage_id' value='" . $sillage_row['id'] . "' $selected onchange='updateSelectedOptions(\"sillage-checkbox\")'>
                            " . $sillage_row['sillage'] . "
                        </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div id="selectedSillages" class="mt-2"></div>
                        </div>

                        <div class="form-group col-4">
                            <label for="lasting" class="form-control-label">Lasting</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control"
                                    style="width: 100%; text-align: left; display: flex; justify-content: space-between;"
                                    type="button" id="lastingDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Lasting
                                </button>

                                <div class="dropdown-menu" aria-labelledby="lastingDropdown">
                                    <!-- Search box for filtering options -->
                                    <div class="mb-3">
                                        <input type="text" id="lastingSearch" class="form-control" placeholder="Search..." onkeyup="filterDropdown(this)">
                                    </div>

                                    <!-- Options list with PHP rendering -->
                                    <div id="lastingOptions" class="form-check">
                                        <?php
                                        $select_lasting = mysqli_query($con, "SELECT * FROM lasting ORDER BY lasting ASC"); // Add ORDER BY clause
                                        while ($lasting_row = mysqli_fetch_array($select_lasting)) {
                                            $selected = in_array($lasting_row['id'], $selected_lastings) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
        <input type='radio' class='form-check-input lasting-checkbox' name='lasting_id' value='" . $lasting_row['id'] . "' $selected onchange='updateSelectedOptions(\"lasting-checkbox\")'>
        " . $lasting_row['lasting'] . "
    </label>";
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div id="selectedLastings" class="mt-2"></div>
                        </div>



                    </div>
                    <!-- Dropdown style -->
                    <style>
                        .dropdown-menu {
                            max-height: 200px;
                            overflow-y: auto;
                            padding: 1rem;
                            width: 100%;
                        }

                        .dropdown-item {
                            cursor: pointer;
                            /* Change cursor to pointer */
                        }

                        .dropdown-item:hover {
                            background-color: aliceblue;
                        }

                        .dropdown-toggle::after {
                            margin-top: 0.5rem;
                        }
                    </style>
                    <!-- Dropdown Scriptting -->
                    <script>
                        $(document).ready(function() {
                            // Open dropdown
                            $('.dropdown-toggle').click(function(e) {
                                e.stopPropagation(); // Stop the event from bubbling up
                                $(this).next('.dropdown-menu').toggle(); // Show or hide the dropdown
                            });

                            // Close dropdown when clicking outside of it
                            $(document).click(function(e) {
                                if (!$(e.target).closest('.dropdown').length) {
                                    $('.dropdown-menu').hide(); // Hide all dropdowns
                                }
                            });
                        });

                        function filterDropdown(input) {
                            // Get the parent dropdown menu of the input
                            var dropdownMenu = input.closest('.dropdown-menu');

                            // Get the value of the search input
                            var filter = input.value.toLowerCase();

                            // Get the labels (dropdown items) within the form-check inside this dropdown
                            var options = dropdownMenu.querySelectorAll('.form-check label');

                            // Loop through the options and hide those that don't match the search query
                            options.forEach(function(option) {
                                var optionText = option.textContent || option.innerText;
                                if (optionText.toLowerCase().indexOf(filter) > -1) {
                                    option.style.display = ""; // Show matching options
                                } else {
                                    option.style.display = "none"; // Hide non-matching options
                                }
                            });
                        }

                        // Function to update selected options based on checkboxes or radio buttons
                        function updateSelectedOptions(changedClass) {
                            let selectedItems = [];
                            let targetElementId = '';

                            // Determine which section to update based on the changed class
                            switch (changedClass) {
                                case 'gender-checkbox':
                                    document.querySelectorAll('.gender-checkbox:checked').forEach(function(checkbox) {
                                        selectedItems.push(checkbox.parentElement.textContent.trim());
                                    });
                                    targetElementId = 'selectedGenders';
                                    break;

                                case 'genre-checkbox':
                                    document.querySelectorAll('.genre-checkbox:checked').forEach(function(checkbox) {
                                        selectedItems.push(checkbox.parentElement.textContent.trim());
                                    });
                                    targetElementId = 'selectedGenres';
                                    break;

                                case 'type-checkbox':
                                    document.querySelectorAll('.type-checkbox:checked').forEach(function(checkbox) {
                                        selectedItems.push(checkbox.parentElement.textContent.trim());
                                    });
                                    targetElementId = 'selectedTypes';
                                    break;

                                case 'season-checkbox':
                                    document.querySelectorAll('.season-checkbox:checked').forEach(function(checkbox) {
                                        selectedItems.push(checkbox.parentElement.textContent.trim());
                                    });
                                    targetElementId = 'selectedSeasons';
                                    break;

                                case 'sillage-checkbox':
                                    document.querySelectorAll('.sillage-checkbox:checked').forEach(function(checkbox) {
                                        selectedItems.push(checkbox.parentElement.textContent.trim());
                                    });
                                    targetElementId = 'selectedSillages';
                                    break;

                                case 'lasting-checkbox':
                                    // Handle radio button selection (only one can be selected)
                                    let selectedRadio = document.querySelector('.lasting-checkbox:checked');
                                    if (selectedRadio) {
                                        selectedItems.push(selectedRadio.parentElement.textContent.trim());
                                    }
                                    targetElementId = 'selectedLastings'; // Update to 'selectedLastings'
                                    break;
                            }

                            // Update the corresponding section based on the targetElementId
                            document.getElementById(targetElementId).innerHTML = selectedItems.length > 0 ?
                                '<strong>Selected ' + changedClass.split('-')[0].charAt(0).toUpperCase() + changedClass.split('-')[0].slice(1) + ':</strong> ' + selectedItems.join(', ') :
                                'No ' + changedClass.split('-')[0] + ' selected';
                        }
                        // Function to initialize selected options on page load
                        function initializeSelections() {
                            // Call updateSelectedOptions for each checkbox category
                            updateSelectedOptions('gender-checkbox');
                            updateSelectedOptions('genre-checkbox');
                            updateSelectedOptions('type-checkbox');
                            updateSelectedOptions('season-checkbox');
                            updateSelectedOptions('sillage-checkbox');
                            updateSelectedOptions('lasting-checkbox');
                        }

                        // Run this function after the DOM is fully loaded
                        window.onload = function() {
                            initializeSelections();
                        };
                    </script>
                    <br><br>
                    <!-- Image Style -->
                    <style>
                        .modal {
                            display: none;
                            position: absolute;
                            z-index: 1000;
                            width: 100%;
                            height: 100%;
                            overflow: auto;
                            background-color: rgb(0, 0, 0);
                            background-color: rgba(0, 0, 0, 0.4);
                        }

                        .modal-content {
                            position: absolute;
                            background-color: #fefefe;
                            left: 10%;
                            bottom: 25%;
                            padding: 20px;
                            border: 1px solid #888;
                            width: 80%;
                        }

                        .close {
                            color: red;
                            float: right;
                            font-size: 28px;
                        }

                        .close:hover,
                        .close:focus {
                            color: black;
                            text-decoration: none;
                            cursor: pointer;
                        }

                        #imageSelector:hover {
                            cursor: pointer;
                        }

                        .image-gallery {
                            display: flex;
                            flex-wrap: wrap;
                            max-height: 400px;
                            overflow-y: auto;
                            gap: 10px;
                        }

                        .gallery-image {
                            width: 100px;
                            height: 120px;
                            object-fit: cover;
                            cursor: pointer;
                        }


                        .gallery-image.selected {
                            border: 4px solid steelblue !important;
                        }

                        .selected-image {
                            position: relative;
                            margin-right: 10px;
                            margin-bottom: 10px;
                        }

                        .selected-image img {
                            border: 1px solid #9999;
                        }

                        .remove-image {
                            position: absolute;
                            top: 0;
                            right: 0;
                            color: white;
                            background-color: red;
                            cursor: pointer;
                            border-radius: 50%;
                            padding: 0 5px;
                        }
                    </style>
                    <hr>
                    <!-- Main Image -->
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="singleImage" class="form-control-label">Select Main Image:</label>
                            <input type="text" id="singleImageSelector" class="form-control" style="cursor: pointer;" placeholder="Select or Upload an Image" readonly onclick="openSingleImageModal()" />
                            <small class="form-text text-muted">Click to select or upload an image.</small>
                        </div>
                        <div class="form-group col-6">
                            <div id="singleSelectedImagePreviewContainer" class="mb-4" style="<?php echo $image == '' ? 'display: none;' : 'display: block;'; ?>">

                                <p>Selected Image:</p>
                                <div id="singleSelectedImagePreview" style="display: flex; flex-wrap: wrap;">
                                    <?php
                                    if ($image !== '') {
                                        echo '<img src="../image/products/' . $image . '" width="100px" />';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- Hidden input to store the single image path -->
                        <input type="hidden" id="singleSelectedImageInput" name="single_selected_image" value="<?= $image ?>">
                    </div>
                    <!-- Modal for Single Image Gallery -->
                    <div id="singleImageModal" class="modal" style="display:none;">
                        <div class="modal-content">
                            <span class="close" onclick="closeSingleImageModal()">&times;</span>

                            <!-- Upload New Image Section -->
                            <div>
                                <label for="singleNewImageUpload">Upload New Image:</label>
                                <input type="file" id="singleNewImageUpload" class="form-control" accept="image/*">
                            </div>
                            <p class="text-muted form-text">Only 800x1200px size images.</p>
                            <p id="singleErrorMessage" style="color: red; display: none;">The image is not 800x1200px and was not uploaded.</p>
                            <p id="singleSuccessMessage" style="color: green; display: none;">Valid Image uploaded successfully!</p>

                            <hr>

                            <!-- Gallery Section to Display Existing Images -->
                            <h3>Or Select an Image</h3>
                            <div id="singleImageGallery" class="image-gallery">
                                <?php
                                // Fetch and display images from the folder
                                $images = glob('../image/products/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                                foreach ($images as $img) {
                                    echo "<img src='$img' class='gallery-image' data-image-url='$img' onclick=\"selectSingleImage('$img')\">";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById("singleNewImageUpload").addEventListener("change", function() {
                            const file = this.files[0]; // Get the first file selected by the user
                            const formData = new FormData();
                            const errorMessage = document.getElementById("singleErrorMessage");
                            const successMessage = document.getElementById("singleSuccessMessage");

                            errorMessage.style.display = "none";
                            successMessage.style.display = "none";

                            // Check image size (800x1200px)
                            const img = new Image();
                            img.onload = function() {
                                if (img.width === 800 && img.height === 1200) {
                                    // Append file as 'images[]' to match backend expectation
                                    formData.append("images[]", file);

                                    console.log("FormData:", formData); // Log FormData content for debugging

                                    fetch("upload.php", {
                                            method: "POST",
                                            body: formData,
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log("Server Response:", data); // Log the server response for debugging
                                            if (data.success) {
                                                successMessage.style.display = "block";
                                                refreshSingleImageGallery(); // Reload the gallery after upload
                                                document.getElementById("singleNewImageUpload").value = ""; // Clear the file input
                                            } else {
                                                errorMessage.textContent = data.message;
                                                errorMessage.style.display = "block";
                                            }
                                        })
                                        .catch(err => {
                                            console.error("Error uploading image:", err);
                                            errorMessage.textContent = "An error occurred while uploading the image.";
                                            errorMessage.style.display = "block";
                                        });
                                } else {
                                    errorMessage.textContent = "The image must be 800x1200px.";
                                    errorMessage.style.display = "block";
                                }
                            };
                            img.src = URL.createObjectURL(file);
                        });



                        // Function to open the modal
                        function openSingleImageModal() {
                            document.getElementById('singleImageModal').style.display = 'block';
                        }

                        // Function to close the modal
                        function closeSingleImageModal() {
                            document.getElementById('singleImageModal').style.display = 'none';
                        }



                        function selectSingleImage(imageUrl) {
                            const previewContainer = document.getElementById('singleSelectedImagePreview');
                            const inputField = document.getElementById('singleImageSelector');
                            const hiddenInput = document.getElementById('singleSelectedImageInput');
                            const previewContainerElement = document.getElementById('singleSelectedImagePreviewContainer');

                            // Extract file name from image URL
                            const fileName = imageUrl.substring(imageUrl.lastIndexOf('/') + 1);

                            // If the clicked image is already selected, deselect it
                            if (hiddenInput.value === fileName) {
                                // Deselect the current image
                                previewContainer.innerHTML = ''; // Clear preview
                                hiddenInput.value = ''; // Clear hidden input value
                                inputField.value = ''; // Clear the input field
                                previewContainerElement.style.display = 'none'; // Hide preview container
                                return; // Exit the function if already selected
                            }

                            // Otherwise, select the new image
                            const imgElement = document.createElement('img');
                            imgElement.src = imageUrl;
                            imgElement.style.maxWidth = '150px';
                            imgElement.style.maxHeight = '150px';

                            // Clear any previous image preview and add the new image
                            previewContainer.innerHTML = ''; // Clear previous preview
                            previewContainer.appendChild(imgElement); // Append new selected image

                            // Update the hidden input and input field with the selected image's file name
                            hiddenInput.value = fileName;


                            // Show the preview container
                            previewContainerElement.style.display = 'block';

                            // Close the modal (optional)
                            closeSingleImageModal();
                        }


                        // Function to refresh the image gallery after uploading
                        function refreshSingleImageGallery() {
                            fetch('fetch_new_images.php')
                                .then(response => response.json())
                                .then(data => {
                                    const gallery = document.getElementById('singleImageGallery');
                                    gallery.innerHTML = ''; // Clear existing gallery

                                    // Check if the server returned images
                                    if (data.success && data.newImages && data.newImages.length > 0) {
                                        // Add new images to the gallery
                                        data.newImages.forEach(imagePath => {
                                            const img = document.createElement('img');
                                            img.src = imagePath; 
                                            img.className = 'gallery-image';
                                            img.onclick = () => selectSingleImage(imagePath);
                                            gallery.appendChild(img);

                                            // Automatically select the newly uploaded image
                                            // If this is the first image added, select it
                                            if (gallery.children.length === 1) {
                                                selectSingleImage(imagePath); // Call the function to select the image
                                            }
                                        });
                                    }

                                    // Check if there's a selected image and restore the preview
                                    const selectedImageUrl = document.getElementById('singleSelectedImageInput').value;
                                    if (selectedImageUrl) {
                                        const previewContainer = document.getElementById('singleSelectedImagePreview');
                                        // Clear previous preview (if any)
                                        previewContainer.innerHTML = '';
                                        const imgElement = document.createElement('img');
                                        imgElement.src = '../image/products/' + selectedImageUrl;
                                        imgElement.style.maxWidth = '150px';
                                        imgElement.style.maxHeight = '150px';
                                        previewContainer.appendChild(imgElement);

                                        // Show the preview container
                                        document.getElementById('singleSelectedImagePreviewContainer').style.display = 'block';
                                    } else {
                                        // Hide the preview container if no image is selected
                                        document.getElementById('singleSelectedImagePreviewContainer').style.display = 'none';
                                    }
                                })
                                .catch(err => {
                                    console.error('Error fetching new images:', err);
                                    // Handle the error gracefully, maybe show a message to the user
                                });
                        }
                    </script>
                    <hr>
                    <!-- Multiple Images -->
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="image" class="form-control-label">Select Other Images Of Product</label>
                            <input type="text" id="imageSelector" class="form-control" placeholder="Select or Upload Images" readonly
                                onclick="openImageModal()" />
                            <small class="form-text text-muted">Click to select or upload images.</small>
                        </div>
                        <div class="form-group col-6">
                            <div id="selectedImagesPreviewContainer" class="mb-4" style="display: <?= !empty($all_images) ? 'block' : 'none' ?>;">
                                <p>Selected Images:</p>
                                <div id="selectedImagesPreview" style="display: flex; flex-wrap: wrap;">
                                    <?php
                                    // Loop through the $all_images array and output an image element for each
                                    foreach ($all_images as $image_path) {
                                    ?>
                                        <div class="selected-image">
                                            <img src="../image/products/<?= $image_path ?>" class="preview-image" data-image-url="../image/products/<?= $image_path ?>" style="max-width:150px; max-height:150px;" />
                                            <span class="remove-image" onclick="removeImageFromPreview('../image/products/<?= $image_path ?>')">&times;</span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- Hidden input to store image paths -->
                        <input type="hidden" id="selectedImagesInput" name="selected_images" value="[]">
                        <script>

                        </script>
                    </div>

                    <!-- Modal for Image Gallery -->
                    <div id="imageModal" class="modal" style="display:none;">
                        <div class="modal-content">
                            <span class="close" onclick="closeImageModal()">&times;</span>

                            <!-- Upload New Image Section -->
                            <div>
                                <label for="newImageUpload">Upload New Images:</label>
                                <input type="file" id="newImageUpload" class="form-control" multiple accept="image/*">
                            </div>
                            <p class="text-muted form-text">Only 800x1200px size images.</p>
                            <p id="error-message" style="color: red; display: none;">Some images are not 800x1200px and were not uploaded.</p>
                            <p id="success-message" style="color: green; display: none;">Valid Images uploaded successfully!</p>

                            <script>

                            </script>
                            <hr>

                            <!-- Gallery Section to Display Existing Images -->
                            <h3>Or Select Images</h3>
                            <div id="imageGallery" class="image-gallery">
                                <?php
                                // Prepend "../image/products/" to each element in the $all_images array
                                $all_images = array_map(function ($image) {
                                    return '../image/products/' . $image;
                                }, $all_images);

                                // Fetch and display images from the folder
                                $images = glob('../image/products/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                                foreach ($images as $img) {
                                    // Check if the image is in the $all_images array
                                    $isSelected = in_array($img, $all_images) ? 'selected' : '';
                                    echo "<img src='$img' class='gallery-image $isSelected' data-image-url='$img' onclick=\"selectImage('$img')\">";
                                }
                                ?>

                            </div>

                        </div>
                    </div>
                    <hr>
                    <script>
                        document.getElementById("newImageUpload").addEventListener("change", function() {
                            const files = this.files;
                            const formData = new FormData();
                            const errorMessage = document.getElementById("error-message");
                            const successMessage = document.getElementById("success-message");

                            errorMessage.style.display = "none";
                            successMessage.style.display = "none";

                            // Append selected files to FormData
                            Array.from(files).forEach(file => {
                                formData.append("images[]", file);
                            });

                            // Send files to the server via AJAX
                            fetch("upload.php", {
                                    method: "POST",
                                    body: formData,
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Show success message
                                        successMessage.style.display = "block";

                                        // Clear the file input
                                        document.getElementById("newImageUpload").value = '';

                                        // Refresh the image gallery
                                        refreshGallery();
                                    } else {
                                        // Show error message
                                        errorMessage.textContent = data.message;
                                        errorMessage.style.display = "block";
                                    }
                                })
                                .catch(err => {
                                    console.error("Error uploading images:", err);
                                    errorMessage.textContent = "An error occurred while uploading images.";
                                    errorMessage.style.display = "block";
                                });
                        });
                        // Initialize the selectedImagesSet and populate it with PHP data
                        const selectedImagesSet = new Set(
                            <?php
                            // Convert the $all_images PHP array to a JSON array for JavaScript
                            echo json_encode($all_images);
                            ?>
                        );

                        function refreshGallery() {
                            // Fetch displayed images from the gallery
                            const displayedImages = new Set(
                                Array.from(document.querySelectorAll('#imageGallery .gallery-image')).map(img => new URL(img.src, window.location.href).href)
                            );

                            fetch('fetch_new_images.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        existingImages: Array.from(displayedImages)
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const gallery = document.getElementById('imageGallery');

                                        data.newImages.forEach(imagePath => {
                                            const absolutePath = new URL(imagePath, window.location.href).href;

                                            // Check if the image is already in the gallery
                                            if (!displayedImages.has(absolutePath)) {
                                                const img = document.createElement('img');
                                                img.src = absolutePath;
                                                img.className = 'gallery-image';
                                                img.onclick = () => selectImage(absolutePath);

                                                // Assign the `data-image-url` attribute
                                                img.dataset.imageUrl = absolutePath;

                                                // Add the image to the gallery
                                                gallery.insertBefore(img, gallery.firstChild);

                                                // Add the image to the displayedImages set
                                                displayedImages.add(absolutePath);

                                                // Trigger selectImage after adding the image
                                                selectImage(absolutePath);
                                            }
                                        });
                                    } else {
                                        console.error(data.message);
                                    }
                                })
                                .catch(err => console.error('Error fetching new images:', err));
                        }



                        // Open modal
                        function openImageModal() {
                            document.getElementById('imageModal').style.display = 'block';
                        }

                        // Close modal
                        function closeImageModal() {
                            document.getElementById('imageModal').style.display = 'none';
                        }


                        // Function to select/deselect an image and manage preview
                        function selectImage(imageUrl) {
                            console.log('Initial selected images:', selectedImagesSet);

                            console.log('selectImage called with:', imageUrl);

                            const imgElement = document.querySelector(`#imageGallery img[data-image-url='${imageUrl}']`);

                            console.log('Image element:', imgElement);
                            const images = document.querySelectorAll('.gallery-image');

                            // Check if the image is already selected
                            if (selectedImagesSet.has(imageUrl)) {
                                console.log('Image is already selected, deselecting...');
                                // Deselect the image if it was already selected
                                imgElement.classList.remove('selected');
                                console.log("Select class removed.");
                                // Remove from preview if deselected
                                removeImageFromPreview(imageUrl);
                                // Remove from selected images set
                                selectedImagesSet.delete(imageUrl);
                                console.log('Image deselected:', imageUrl);
                            } else {
                                console.log('Image not selected, selecting...');
                                // Select the image if it wasn't selected
                                imgElement.classList.add('selected');
                                // Add 'selected' class to the clicked image
                                const selectedImage = Array.from(images).find(img => img.dataset.imageUrl === imageUrl);
                                if (selectedImage) {
                                    selectedImage.classList.add('selected');
                                }
                                console.log("Select class added.");
                                console.log('Image element:', imgElement);



                                // Add to preview if selected, but prevent duplicates
                                addImageToPreview(imageUrl);
                                // Add to selected images set
                                selectedImagesSet.add(imageUrl);
                                console.log('Image selected:', imageUrl);
                            }
                        }

                        // Function to add selected image to preview and handle deselecting/removal
                        function addImageToPreview(imageUrl) {
                            console.log('addImageToPreview called with:', imageUrl);
                            const selectedImagesPreview = document.getElementById('selectedImagesPreview');
                            const selectedImagesPreviewContainer = document.getElementById('selectedImagesPreviewContainer');

                            // Ensure the preview container is displayed
                            selectedImagesPreviewContainer.style.display = 'block'; // Show the preview container
                            console.log('Preview container displayed');

                            // Check if the image is already in the selected images set (this is now a more reliable check)
                            if (selectedImagesSet.has(imageUrl)) {
                                console.log('Image already in preview set, skipping add');
                                return;
                            }

                            // If the image is not already in the preview, add it
                            console.log('Adding image to preview...');
                            const imageDiv = document.createElement('div');
                            imageDiv.className = 'selected-image';

                            const imgElement = document.createElement('img');
                            imgElement.src = imageUrl;
                            imgElement.dataset.imageUrl = imageUrl; // Set the data-image-url to match the gallery image
                            imgElement.style.maxWidth = '150px';
                            imgElement.style.maxHeight = '150px';
                            imageDiv.appendChild(imgElement);

                            // Remove button
                            const removeButton = document.createElement('span');
                            removeButton.className = 'remove-image';
                            removeButton.innerHTML = '&times;';
                            removeButton.onclick = function() {
                                console.log('Removing image from preview:', imageUrl);
                                selectedImagesPreview.removeChild(imageDiv); // Remove from preview when clicking remove
                                // Deselect image from gallery
                                const imgElement = document.querySelector(`img[data-image-url='${imageUrl}']`);
                                if (imgElement) {
                                    imgElement.classList.remove('selected');
                                    console.log('Image deselected from gallery');
                                }
                                // Remove from the Set
                                selectedImagesSet.delete(imageUrl);
                                console.log('Image removed from set:', imageUrl);

                                // Hide the preview container if no images are left
                                if (selectedImagesPreview.children.length === 0) {
                                    const selectedImagesPreviewContainer = document.getElementById('selectedImagesPreviewContainer');
                                    selectedImagesPreviewContainer.style.display = 'none';
                                    console.log('Preview container hidden');
                                }
                            };
                            imageDiv.appendChild(removeButton);

                            // Append the new image div to the preview container
                            selectedImagesPreview.appendChild(imageDiv);
                            console.log('Image added to preview');


                        }

                        // Function to remove image from preview (if deselected)
                        function removeImageFromPreview(imageUrl) {
                            console.log('removeImageFromPreview called with:', imageUrl);
                            const selectedImagesPreview = document.getElementById('selectedImagesPreview');
                            const imageDiv = [...selectedImagesPreview.getElementsByTagName('div')]
                                .find(div => div.querySelector('img').dataset.imageUrl === imageUrl); // Use data-image-url for matching
                            console.log('Found image div for removal:', imageDiv);

                            if (imageDiv) {
                                selectedImagesPreview.removeChild(imageDiv);
                                console.log('Image div removed from preview');
                            }

                            // Deselect the image from the gallery
                            const imgElement = document.querySelector(`img[data-image-url='${imageUrl}']`);
                            if (imgElement) {
                                imgElement.classList.remove('selected');
                                console.log('Selected class removed from gallery image');
                            }

                            // Hide the preview container if no images are left
                            if (selectedImagesPreview.children.length === 0) {
                                const selectedImagesPreviewContainer = document.getElementById('selectedImagesPreviewContainer');
                                selectedImagesPreviewContainer.style.display = 'none';
                                console.log('Preview container hidden');
                            }
                        }
                    </script>



                    <div class="form-group">
                        <label for="description" class="form-control-label">One Liner</label>
                        <input type="text" name="description" value="<?= $description ?>" placeholder="Enter Product Description" class="form-control"
                            required />
                    </div>

                    <!-- Include Quill.js CSS and JS -->
                    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                    <div class="form-group">
                        <label for="brief" class="form-control-label">Description</label>
                        <!-- Quill editor container -->
                        <div id="editor-container" placeholder="Enter Product Brief"><?= $brief ?></div>
                        <!-- Hidden input to store the Quill content -->
                        <input type="hidden" name="brief" id="brief" value="<?= $brief ?>">
                    </div>

                    <!-- Add Quill editor toolbar -->
                    <script>
                        var quill = new Quill('#editor-container', {
                            theme: 'snow',
                            placeholder: 'Enter Product Brief',
                            modules: {
                                toolbar: [
                                    ['bold', 'italic', 'underline'], // Add formatting options
                                    [{
                                        'list': 'bullet'
                                    }, {
                                        'list': 'ordered'
                                    }],
                                    ['link']
                                ]
                            }
                        });

                        // Load the existing PHP content into the editor (ensure it's escaped properly for JavaScript)
                        var briefContent = `<?= addslashes($brief) ?>`; // Escaping the PHP content for use in JS
                        quill.root.innerHTML = briefContent;

                        // Save Quill content to hidden input on form submission
                        document.querySelector('form').onsubmit = function() {
                            document.querySelector('#brief').value = quill.root.innerHTML;
                        };
                        document.querySelector('form').onsubmit = function() {
                            // Collect image paths from the selected images in the preview container
                            const selectedImages = Array.from(document.querySelectorAll('#selectedImagesPreview img'))
                                .map(img => img.getAttribute('src')); // Get the full image paths

                            // Extract file names from the image paths
                            const filteredSelectedImages = selectedImages.map(imageUrl => {
                                return imageUrl.substring(imageUrl.lastIndexOf('/') + 1); // Get file name after the last '/'
                            });

                            // Store the filtered file names in the hidden input field
                            document.getElementById('selectedImagesInput').value = JSON.stringify(filteredSelectedImages);

                            // Check if a Main Image is selected
                            const selectedImage = document.getElementById('singleSelectedImageInput').value;
                            if (!selectedImage) {
                                alert("Please select a Main Image before submitting the form.");
                                return false; // Prevent form submission if no main image is selected
                            }

                            return true; // Allow form submission if everything is valid
                        };
                    </script>


                    <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-primary btn-block">
                        <span id="payment-button-amount">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php
    include "footer.php"
    ?>