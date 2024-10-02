<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$msg = '';
$category_id = '';
$sub_category_id = '';
$name = '';
$format = '';
$format2 = '';
$price = '';
$price2 = '';
$qty = '';
$image = '';
$image2 = '';
$breif = '';
$description = '';
$image_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $_id = get_safe_value($con, $_GET['id']);
    
    // Fetch product details from product table
    $res = mysqli_query($con, "select * from product where id=$_id");
    $check = mysqli_num_rows($res);

    if ($check > 0) {
        $row = mysqli_fetch_array($res);
        $category_id = $row['category_id'];
        $sub_category_id = $row['sub_category_id'];
        $name = $row['name'];
        $qty = $row['qty'];
        $breif = $row['breif'];
        $description = $row['description'];
        $image = $row['image'];
        $image2 = $row['image2'];

        // Fetch product formats and prices from product_format table
        $format_res = mysqli_query($con, "SELECT * FROM product_format WHERE product_id=$_id");
        $formats = [];
        while ($format_row = mysqli_fetch_assoc($format_res)) {
            $formats[] = $format_row;
        }

        if (!empty($formats)) {
            $format = $formats[0]['format'];
            $price = $formats[0]['price'];
            $format2 = isset($formats[1]) ? $formats[1]['format'] : '';
            $price2 = isset($formats[1]) ? $formats[1]['price'] : '';
        }
    } else {
        header('Location: product.php');
        die();
    }
}

if (isset($_REQUEST['submit'])) {
    $category_id = get_safe_value($con, $_REQUEST['categories_id']);
    $sub_category_id = get_safe_value($con, $_REQUEST['sub_categories_id']);
    $name = get_safe_value($con, $_REQUEST['name']);
    $format = get_safe_value($con, $_REQUEST['format']);
    $price = get_safe_value($con, $_REQUEST['price']);
    $format2 = get_safe_value($con, $_REQUEST['format2']);
    $price2 = get_safe_value($con, $_REQUEST['price2']);
    $qty = get_safe_value($con, $_REQUEST['qty']);
    $breif = get_safe_value($con, $_REQUEST['breif']);
    $description = get_safe_value($con, $_REQUEST['description']);

    // Validation for product existence
    $res = mysqli_query($con, "select * from product where category_id='$category_id' and sub_category_id='$sub_category_id' and name='$name'");
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

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            // Update existing product
            if ($_FILES["image"]["name"] != '') {
                $image = $_FILES["image"]["name"];
                $tempname = $_FILES["image"]["tmp_name"];
                $folder = "../image/" . $image;
                move_uploaded_file($tempname, $folder);
            }

            if ($_FILES["image2"]["name"] != '') {
                $image2 = $_FILES["image2"]["name"];
                $tempname2 = $_FILES["image2"]["tmp_name"];
                $folder2 = "../image/" . $image2;
                move_uploaded_file($tempname2, $folder2);
            }

            mysqli_query($con, "update product set category_id='$category_id', sub_category_id='$sub_category_id', name='$name', qty='$qty', breif='$breif', description='$description', image='$image', image2='$image2' where id='$_id'");

            // Update format and price in product_format table
            mysqli_query($con, "DELETE FROM product_format WHERE product_id='$_id'");
            mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`) VALUES ('$_id', '$format', '$price')");
            if ($format2 != '' && $price2 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`) VALUES ('$_id', '$format2', '$price2')");
            }

        } else {
            // Insert new product
            $image = $_FILES["image"]["name"];
            $tempname = $_FILES["image"]["tmp_name"];
            $folder = "../image/" . $image;
            move_uploaded_file($tempname, $folder);

            $image2 = $_FILES["image2"]["name"];
            $tempname2 = $_FILES["image2"]["tmp_name"];
            $folder2 = "../image/" . $image2;
            move_uploaded_file($tempname2, $folder2);

            mysqli_query($con, "INSERT INTO product (`category_id`, `sub_category_id`, `name`, `qty`, `breif`, `description`, `status`, `image`, `image2`) VALUES ('$category_id', '$sub_category_id', '$name', '$qty', '$breif', '$description', '1', '$image', '$image2')");
            $product_id = mysqli_insert_id($con);

            // Insert format and price in product_format table
            mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`) VALUES ('$product_id', '$format', '$price')");
            if ($format2 != '' && $price2 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`) VALUES ('$product_id', '$format2', '$price2')");
            }
        }

        echo "<script>window.location.href='product.php'</script>";
        die();
    }
}

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Products</h4><span>Form</span>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="categories" class="form-control-label">Categories</label>
                        <select class="form-control" name="categories_id" id="category">
                            <option selected disabled>Select Category</option>
                            <?php
                                $categories = mysqli_query($con, "SELECT * FROM categories");
                                while ($row = mysqli_fetch_array($categories)) {
                                    $selected = ($row['id'] == $category_id) ? 'selected' : '';
                                    echo "<option value='{$row['id']}' $selected>{$row['categories']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sub_categories" class="form-control-label">Sub Categories</label>
                        <select class="form-control" name="sub_categories_id" id="sub_category">
                            <option selected disabled>Select Sub Category</option>
                            <!-- Subcategories will be loaded by AJAX based on the selected category -->
                        </select>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            var category_id = $('#category').val();
                            var selected_sub_category_id = "<?php echo $sub_category_id; ?>";
                            // Load subcategories if a category is already selected
                            if (category_id) {
                                $.ajax({
                                    url: 'get_subcategories.php',
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
                                    url: 'get_subcategories.php',
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

                    <div class="form-group">
                        <label for="categories" class="form-control-label">Product name</label>
                        <input type="text" name="name" placeholder="Enter Product name" class="form-control" required
                            value="<?= $name ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="categories" class="form-control-label">Format</label>
                            <input type="text" name="format" placeholder="Enter Product Format" class="form-control"
                                required value="<?= $format ?>">
                        </div>

                        <div class="form-group col-6">
                            <label for="categories" class="form-control-label">Price</label>
                            <input type="text" name="price" placeholder="Enter Product price" class="form-control"
                                required value="<?= $price ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="categories" class="form-control-label">Format 2</label>
                            <input type="text" name="format2" placeholder="Enter Product Format 2" class="form-control"
                                value="<?= $format2 ?>">
                        </div>

                        <div class="form-group col-6">
                            <label for="categories" class="form-control-label">Price</label>
                            <input type="text" name="price2" placeholder="Enter Product Price 2" class="form-control"
                                value="<?= $price2 ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="categories" class="form-control-label">Qty</label>
                        <input type="text" name="qty" placeholder="Enter Qty" class="form-control" required
                            value="<?= $qty ?>">
                    </div>

                    <div class="form-group">
                        <label for="categories" class="form-control-label">Image</label>
                        <input type="file" name="image" class="form-control" <?= $image_required ?>>
                    </div>

                    <div class="form-group">
                        <label for="categories" class="form-control-label">Image 2</label>
                        <input type="file" name="image2" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="categories" class="form-control-label">Brief</label>
                        <textarea name="breif" placeholder="Enter Product Brief"
                            class="form-control"><?= $breif ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="categories" class="form-control-label">Description</label>
                        <textarea name="description" placeholder="Enter Product Description"
                            class="form-control"><?= $description ?></textarea>
                    </div>

                    <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-primary btn-block">
                        <span id="payment-button-amount">Submit</span>
                    </button>
                    <div style="color: red; margin-top: 10px;">
                        <?= $msg ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
include "footer.php"
?>