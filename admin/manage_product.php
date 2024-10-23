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
$format3 = '';
$format4 = '';
$format5 = '';
$price = '';
$price2 = '';
$price3 = '';
$price4 = '';
$price5 = '';
$qty = '';
$qty2 = '';
$qty3 = '';
$qty4 = '';
$qty5 = '';
$image = '';
$image2 = '';
$image3 = '';
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
        $breif = $row['breif'];
        $description = $row['description'];
        $image = $row['image'];
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

        // Fetch product formats and prices from product_format table
        $format_res = mysqli_query($con, "SELECT * FROM product_format WHERE product_id=$_id");
        $formats = [];
        while ($format_row = mysqli_fetch_assoc($format_res)) {
            $formats[] = $format_row;
        }

        if (!empty($formats)) {
            $format = $formats[0]['format'];
            $price = $formats[0]['price'];
            $qty = $formats[0]['qty'];
            $format2 = isset($formats[1]) ? $formats[1]['format'] : '';
            $price2 = isset($formats[1]) ? $formats[1]['price'] : '';
            $qty2 = isset($formats[1]) ? $formats[1]['qty'] : '';
            $format3 = isset($formats[2]) ? $formats[2]['format'] : '';
            $price3 = isset($formats[2]) ? $formats[2]['price'] : '';
            $qty3 = isset($formats[2]) ? $formats[2]['qty'] : '';
            $format4 = isset($formats[3]) ? $formats[3]['format'] : '';
            $price4 = isset($formats[3]) ? $formats[3]['price'] : '';
            $qty4 = isset($formats[3]) ? $formats[3]['qty'] : '';
            $format5 = isset($formats[4]) ? $formats[4]['format'] : '';
            $price5 = isset($formats[4]) ? $formats[4]['price'] : '';
            $qty5 = isset($formats[4]) ? $formats[4]['qty'] : '';
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
    $format = get_safe_value($con, $_REQUEST['format']);
    $price = get_safe_value($con, $_REQUEST['price']);
    $qty = get_safe_value($con, $_REQUEST['qty']);
    $format2 = get_safe_value($con, $_REQUEST['format2']);
    $price2 = get_safe_value($con, $_REQUEST['price2']);
    $qty2 = get_safe_value($con, $_REQUEST['qty2']);
    $format3 = get_safe_value($con, $_REQUEST['format3']);
    $price3 = get_safe_value($con, $_REQUEST['price3']);
    $qty3 = get_safe_value($con, $_REQUEST['qty3']);
    $format4 = get_safe_value($con, $_REQUEST['format4']);
    $price4 = get_safe_value($con, $_REQUEST['price4']);
    $qty4 = get_safe_value($con, $_REQUEST['qty4']);
    $format5 = get_safe_value($con, $_REQUEST['format5']);
    $price5 = get_safe_value($con, $_REQUEST['price5']);
    $qty5 = get_safe_value($con, $_REQUEST['qty5']);
    $qty = get_safe_value($con, $_REQUEST['qty']);
    $qty2 = get_safe_value($con, $_REQUEST['qty2']);
    $qty3 = get_safe_value($con, $_REQUEST['qty3']);
    $qty4 = get_safe_value($con, $_REQUEST['qty4']);
    $qty5 = get_safe_value($con, $_REQUEST['qty5']);
    $breif = get_safe_value($con, $_REQUEST['breif']);
    $description = get_safe_value($con, $_REQUEST['description']);

    // Retrieve other form data
    $gender_ids = isset($_POST['gender_id']) ? $_POST['gender_id'] : [];
    $genre_ids = isset($_POST['genre_id']) ? $_POST['genre_id'] : [];
    $type_ids = isset($_POST['type_id']) ? $_POST['type_id'] : [];
    $season_ids = isset($_POST['season_id']) ? $_POST['season_id'] : [];

    // Get selected sillage and lasting
    $sillage_id = isset($_POST['sillage_id']) ? $_POST['sillage_id'] : null;
    $lasting_id = isset($_POST['lasting_id']) ? $_POST['lasting_id'] : null;

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
    if ($_FILES['image3']['type'] != '' && !in_array($_FILES['image3']['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
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

            if ($_FILES["image3"]["name"] != '') {
                $image3 = $_FILES["image3"]["name"];
                $tempname3 = $_FILES["image3"]["tmp_name"];
                $folder3 = "../image/" . $image3;
                move_uploaded_file($tempname3, $folder3);
            }

            // Handle removal of images based on user input

            if (isset($_POST['remove_image2'])) {
                if (file_exists("../image/" . $image2)) {
                    unlink("../image/" . $image2);
                }
                $image2 = ''; // Clear the image2 value
                mysqli_query($con, "UPDATE product SET image2='' WHERE id='$_id'");
            }

            if (isset($_POST['remove_image3'])) {
                if (file_exists("../image/" . $image3)) {
                    unlink("../image/" . $image3);
                }
                $image3 = ''; // Clear the image3 value
                mysqli_query($con, "UPDATE product SET image3='' WHERE id='$_id'");
            }

            mysqli_query($con, "update product set category_id='$category_id', sub_category_id='$sub_category_id', name='$name', breif='$breif', description='$description', image='$image', image2='$image2', image3='$image3' where id='$_id'");

            mysqli_query($con, "DELETE FROM product_details WHERE product_id='$_id'");

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

            // Update format and price in product_format table
            mysqli_query($con, "DELETE FROM product_format WHERE product_id='$_id'");
            mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$_id', '$format', '$price', '$qty')");
            if ($format2 != '' && $price2 != '' && $qty2 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$_id', '$format2', '$price2', '$qty2')");
            }
            if ($format3 != '' && $price3 != '' && $qty3 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$_id', '$format3', '$price3', '$qty3')");
            }
            if ($format4 != '' && $price4 != '' && $qty4 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$_id', '$format4', '$price4', '$qty4')");
            }
            if ($format5 != '' && $price5 != '' && $qty5 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$_id', '$format5', '$price5', '$qty5')");
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

            $image3 = $_FILES["image3"]["name"];
            $tempname3 = $_FILES["image3"]["tmp_name"];
            $folder3 = "../image/" . $image3;
            move_uploaded_file($tempname3, $folder3);

            mysqli_query($con, "INSERT INTO product (`category_id`, `sub_category_id`, `name`, `breif`, `description`, `status`, `image`, `image2`, `image3`) VALUES ('$category_id', '$sub_category_id', '$name', '$breif', '$description', '1', '$image', '$image2', '$image3')");
            $product_id = mysqli_insert_id($con);

            foreach ($gender_ids as $gender_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, gender_id) VALUES ('$product_id', '$gender_id')");
            }
            foreach ($genre_ids as $genre_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, genre_id) VALUES ('$product_id', '$genre_id')");
            }
            foreach ($type_ids as $type_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, type_id) VALUES ('$product_id', '$type_id')");
            }
            foreach ($season_ids as $season_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, season_id) VALUES ('$product_id', '$season_id')");
            }

            // Insert selected sillage and lasting
            if ($sillage_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, sillage_id) VALUES ('$product_id', '$sillage_id')");
            }
            if ($lasting_id) {
                mysqli_query($con, "INSERT INTO product_details (product_id, lasting_id) VALUES ('$product_id', '$lasting_id')");
            }

            // Insert format and price in product_format table
            mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$product_id', '$format', '$price', '$qty')");
            if ($format2 != '' && $price2 != '' && $qty2 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$product_id', '$format2', '$price2', '$qty2')");
            }
            if ($format3 != '' && $price3 != '' && $qty3 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$product_id', '$format3', '$price3', '$qty3')");
            }
            if ($format4 != '' && $price4 != '' && $qty4 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$product_id', '$format4', '$price4', '$qty4')");
            }
            if ($format5 != '' && $price5 != '' && $qty5 != '') {
                mysqli_query($con, "INSERT INTO product_format (`product_id`, `format`, `price`, `qty`) VALUES ('$product_id', '$format5', '$price5', '$qty5')");
            }
        }

        echo "<script>window.location.href='product'</script>";
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
                    <div class="form-row">

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

                        <div class="form-group col-6">
                            <label for="sub_categories" class="form-control-label">Sub Categories</label>
                            <select class="form-control" name="sub_categories_id" id="sub_category">
                                <option>Select Sub Category</option>
                                <!-- Subcategories will be loaded by AJAX based on the selected category -->
                            </select>
                        </div>

                    </div>

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

                    <div class="form-group">
                        <label for="product" class="form-control-label">Product name</label>
                        <input type="text" name="name" placeholder="Enter Product name" class="form-control" required
                            value="<?= $name ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="format" class="form-control-label">Format</label>
                            <input type="text" name="format" placeholder="Enter Product Format" class="form-control"
                                required value="<?= $format ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="price" class="form-control-label">Price</label>
                            <input type="text" name="price" placeholder="Enter Product price" class="form-control"
                                required value="<?= $price ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="qty" class="form-control-label">Qty</label>
                            <input type="text" name="qty" placeholder="Enter Qty" class="form-control" required
                                value="<?= $qty ?>">
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="format2" class="form-control-label">Format</label>
                            <input type="text" name="format2" placeholder="Enter Product Format" class="form-control"
                                value="<?= $format2 ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="price2" class="form-control-label">Price</label>
                            <input type="text" name="price2" placeholder="Enter Product Price" class="form-control"
                                value="<?= $price2 ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="qty2" class="form-control-label">Qty</label>
                            <input type="text" name="qty2" placeholder="Enter Qty" class="form-control"
                                value="<?= $qty2 ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="format3" class="form-control-label">Format</label>
                            <input type="text" name="format3" placeholder="Enter Product Format" class="form-control"
                                value="<?= $format3 ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="price3" class="form-control-label">Price</label>
                            <input type="text" name="price3" placeholder="Enter Product Price" class="form-control"
                                value="<?= $price3 ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="qty3" class="form-control-label">Qty</label>
                            <input type="text" name="qty3" placeholder="Enter Qty" class="form-control"
                                value="<?= $qty3 ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="format4" class="form-control-label">Format</label>
                            <input type="text" name="format4" placeholder="Enter Product Format" class="form-control"
                                value="<?= $format4 ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="price4" class="form-control-label">Price</label>
                            <input type="text" name="price4" placeholder="Enter Product Price" class="form-control"
                                value="<?= $price4 ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="qty4" class="form-control-label">Qty</label>
                            <input type="text" name="qty4" placeholder="Enter Qty" class="form-control"
                                value="<?= $qty4 ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="format5" class="form-control-label">Format</label>
                            <input type="text" name="format5" placeholder="Enter Product Format" class="form-control"
                                value="<?= $format5 ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="price5" class="form-control-label">Price</label>
                            <input type="text" name="price5" placeholder="Enter Product Price" class="form-control"
                                value="<?= $price5 ?>">
                        </div>

                        <div class="form-group col-4">
                            <label for="qty5" class="form-control-label">Qty</label>
                            <input type="text" name="qty5" placeholder="Enter Qty" class="form-control"
                                value="<?= $qty5 ?>">
                        </div>
                    </div>
                    <br><br>

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

                    <div class="form-row">
                        <div class="form-group col-2">
                            <label for="gender" class="form-control-label">Gender</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control" style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button" id="genderDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Gender
                                </button>
                                <div class="dropdown-menu" aria-labelledby="genderDropdown">
                                    <div class="form-check">
                                        <?php
                                        $select_gender = mysqli_query($con, "SELECT * FROM gender");
                                        while ($gender_row = mysqli_fetch_array($select_gender)) {
                                            $selected = in_array($gender_row['id'], $selected_genders) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                                                    <input type='checkbox' class='form-check-input' name='gender_id[]' value='" . $gender_row['id'] . "' $selected>
                                                    " . $gender_row['gender'] . "
                                                </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-2">
                            <label for="genre" class="form-control-label">Genre</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control" style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button" id="genreDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Genre
                                </button>
                                <div class="dropdown-menu" aria-labelledby="genreDropdown">
                                    <div class="form-check">
                                        <?php
                                        $select_genre = mysqli_query($con, "SELECT * FROM genre");
                                        while ($genre_row = mysqli_fetch_array($select_genre)) {
                                            $selected = in_array($genre_row['id'], $selected_genres) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                                                    <input type='checkbox' class='form-check-input' name='genre_id[]' value='" . $genre_row['id'] . "' $selected>
                                                    " . $genre_row['genre'] . "
                                                </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-2">
                            <label for="type" class="form-control-label">Type</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control" style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button" id="typeDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Type
                                </button>
                                <div class="dropdown-menu" aria-labelledby="typeDropdown">
                                    <div class="form-check">
                                        <?php
                                        $select_type = mysqli_query($con, "SELECT * FROM type");
                                        while ($type_row = mysqli_fetch_array($select_type)) {
                                            $selected = in_array($type_row['id'], $selected_types) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                                                    <input type='checkbox' class='form-check-input' name='type_id[]' value='" . $type_row['id'] . "' $selected>
                                                    " . $type_row['type'] . "
                                                </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-2">
                            <label for="season" class="form-control-label">Season</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control" style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button" id="seasonDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Season
                                </button>
                                <div class="dropdown-menu" aria-labelledby="seasonDropdown">
                                    <div class="form-check">
                                        <?php
                                        $select_season = mysqli_query($con, "SELECT * FROM season");
                                        while ($season_row = mysqli_fetch_array($select_season)) {
                                            $selected = in_array($season_row['id'], $selected_seasons) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                                                    <input type='checkbox' class='form-check-input' name='season_id[]' value='" . $season_row['id'] . "' $selected>
                                                    " . $season_row['season'] . "
                                                </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-2">
                            <label for="sillage" class="form-control-label">Sillage</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control" style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button" id="sillageDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Sillage
                                </button>
                                <div class="dropdown-menu" aria-labelledby="sillageDropdown">
                                    <div class="form-check">
                                        <?php
                                        $select_sillage = mysqli_query($con, "SELECT * FROM sillage");
                                        while ($sillage_row = mysqli_fetch_array($select_sillage)) {
                                            $selected = in_array($sillage_row['id'], $selected_sillages) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                            <input type='radio' class='form-check-input' name='sillage_id' value='" . $sillage_row['id'] . "' $selected>
                            " . $sillage_row['sillage'] . "
                        </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-2">
                            <label for="lasting" class="form-control-label">Lasting</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle form-control" style="width: 100%;text-align:left;display: flex;justify-content: space-between;" type="button" id="lastingDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Lasting
                                </button>
                                <div class="dropdown-menu" aria-labelledby="lastingDropdown">
                                    <div class="form-check">
                                        <?php
                                        $select_lasting = mysqli_query($con, "SELECT * FROM lasting");
                                        while ($lasting_row = mysqli_fetch_array($select_lasting)) {
                                            $selected = in_array($lasting_row['id'], $selected_lastings) ? 'checked' : '';
                                            echo "<label class='dropdown-item'>
                            <input type='radio' class='form-check-input' name='lasting_id' value='" . $lasting_row['id'] . "' $selected>
                            " . $lasting_row['lasting'] . "
                        </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
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
                    <script>
                        $(document).ready(function() {
                            // Open dropdown
                            $('.dropdown-toggle').click(function(e) {
                                e.stopPropagation(); // Stop the event from bubbling up
                                $(this).next('.dropdown-menu')
                                    .toggle(); // Show or hide the dropdown
                            });
                            // Close dropdown when clicking outside of it
                            $(document).click(function(e) {
                                if (!$(e.target).closest('.dropdown').length) {
                                    $('.dropdown-menu').hide(); // Hide all dropdowns
                                }
                            });
                        });
                    </script>
                    <br><br>
                    <!-- Image 1 -->
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="image" class="form-control-label">Image 1</label>
                            <input type="file" name="image" class="form-control" id="image" <?= $image_required ?>
                                onchange="validateImageSize('image', 'imagePreview1', 'imagePreviewContainer1')">
                            <small class="form-text text-muted">Please upload an image with dimensions 800x1200
                                pixels.</small>
                        </div>
                        <div class="form-group col-6" style="display: flex;justify-content: space-around;">
                            <div id="imagePreviewContainer1" class="mb-4" style="display:none;">
                                <p>Selected Image:</p>
                                <img id="imagePreview1" src="#" alt="Selected Image 1"
                                    style="max-width: 150px; max-height: 150px;" class="border" />
                            </div>
                            <div style="display: <?= !empty($image) ? 'block' : 'none'; ?>;">
                                <p>Current Image:</p>
                                <img src="<?= !empty($image) ? '../image/' . $image : '#'; ?>" alt="Current Image 1"
                                    style="max-width: 150px; max-height: 150px;" class="border" />
                            </div>
                        </div>
                    </div>
                    <!-- Image 2 -->
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="image2" class="form-control-label">Image 2</label>
                            <input type="file" name="image2" class="form-control" id="image2"
                                onchange="validateImageSize('image2', 'imagePreview2', 'imagePreviewContainer2')">
                            <small class="form-text text-muted">Please upload an image with dimensions 800x1200
                                pixels.</small>
                        </div>
                        <div class="form-group col-6" style="display: flex;justify-content: space-around;">
                            <div id="imagePreviewContainer2" class="mb-4" style="display:none;">
                                <p>Selected Image:</p>
                                <img id="imagePreview2" src="#" alt="Selected Image 2"
                                    style="max-width: 150px; max-height: 150px;" class="border" />
                            </div>
                            <div style="display: <?= !empty($image2) ? 'block' : 'none'; ?>;">
                                <p>Current Image:</p>
                                <img src="<?= !empty($image2) ? '../image/' . $image2 : '#'; ?>" alt="Current Image 1"
                                    style="max-width: 150px; max-height: 150px;" class="border" />
                                <div>
                                    <input type="checkbox" name="remove_image2" value="2"> Remove Image
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Image 3 -->
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="image3" class="form-control-label">Image 3</label>
                            <input type="file" name="image3" class="form-control" id="image3"
                                onchange="validateImageSize('image3', 'imagePreview3', 'imagePreviewContainer3')">
                            <small class="form-text text-muted">Please upload an image with dimensions 800x1200
                                pixels.</small>
                        </div>
                        <div class="form-group col-6" style="display: flex;justify-content: space-around;">
                            <div id="imagePreviewContainer3" class="mb-4" style="display:none;">
                                <p>Selected Image:</p>
                                <img id="imagePreview3" src="#" alt="Selected Image 3"
                                    style="max-width: 150px; max-height: 150px;" class="border" />
                            </div>
                            <div style="display: <?= !empty($image3) ? 'block' : 'none'; ?>;">
                                <p>Current Image:</p>
                                <img src="<?= !empty($image3) ? '../image/' . $image3 : '#'; ?>" alt="Current Image 3"
                                    style="max-width: 150px; max-height: 150px;" class="border" />
                                <div>
                                    <input type="checkbox" name="remove_image3" value="3"> Remove Image
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- JS For Images  -->
                    <script>
                        function validateImageSize(inputId, imgId, containerId) {
                            const fileInput = document.getElementById(inputId);
                            const file = fileInput.files[0];
                            if (file) {
                                const img = new Image();
                                img.onload = function() {
                                    // Check if the image dimensions are 800x1200
                                    if (img.width !== 800 || img.height !== 1200) {
                                        alert('Image must be 800x1200 pixels in size.');
                                        document.getElementById(containerId).style.display = 'none'; // Hide preview
                                        fileInput.value = '';
                                    } else {
                                        previewImage(file, imgId, containerId); // Show preview if valid
                                    }
                                };
                                img.src = URL.createObjectURL(file); // Create a URL for the image
                            }
                        }

                        function previewImage(file, imgId, containerId) {
                            const reader = new FileReader();
                            // Load image preview
                            reader.onload = function(e) {
                                const img = document.getElementById(imgId);
                                img.src = e.target.result;
                                // Show the image preview container
                                document.getElementById(containerId).style.display = 'block';
                            };
                            reader.readAsDataURL(file); // Convert file to base64 string
                        }
                    </script>

                    <div class="form-group">
                        <label for="description" class="form-control-label">Description</label>
                        <textarea name="description" placeholder="Enter Product Description" class="form-control"
                            required><?= $description ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="brief" class="form-control-label">Brief</label>
                        <textarea name="breif" placeholder="Enter Product Brief"
                            class="form-control"><?= $breif ?></textarea>
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