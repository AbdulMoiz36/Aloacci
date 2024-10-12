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
$gender_id = '';
$genre_id = '';
$type_id = '';
$season_id = '';
$sillage_id = '';
$lasting_id = '';
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
        $gender_id = $row['gender_id'];
        $genre_id = $row['genre_id'];
        $type_id = $row['type_id'];
        $season_id = $row['season_id'];
        $sillage_id = $row['sillage_id'];
        $lasting_id = $row['lasting_id'];
        $breif = $row['breif'];
        $description = $row['description'];
        $image = $row['image'];
        $image2 = $row['image2'];
        $image3 = $row['image3'];

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
    $gender_id = get_safe_value($con, $_REQUEST['gender_id']);
    $genre_id = get_safe_value($con, $_REQUEST['genre_id']);
    $type_id = get_safe_value($con, $_REQUEST['type_id']);
    $season_id = get_safe_value($con, $_REQUEST['season_id']);
    $sillage_id = get_safe_value($con, $_REQUEST['sillage_id']);
    $lasting_id = get_safe_value($con, $_REQUEST['lasting_id']);
    $qty = get_safe_value($con, $_REQUEST['qty']);
    $qty2 = get_safe_value($con, $_REQUEST['qty2']);
    $qty3 = get_safe_value($con, $_REQUEST['qty3']);
    $qty4 = get_safe_value($con, $_REQUEST['qty4']);
    $qty5 = get_safe_value($con, $_REQUEST['qty5']);
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

            mysqli_query($con, "update product set category_id='$category_id', sub_category_id='$sub_category_id', name='$name', gender_id='$gender_id', genre_id='$genre_id', type_id='$type_id', season_id='$season_id', sillage_id='$sillage_id', lasting_id='$lasting_id', breif='$breif', description='$description', image='$image', image2='$image2', image3='$image3' where id='$_id'");

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

            mysqli_query($con, "INSERT INTO product (`category_id`, `sub_category_id`, `name`, `gender_id`, `genre_id`, `type_id`, `season_id`, `sillage_id`, `lasting_id`, `breif`, `description`, `status`, `image`, `image2`, `image3`) VALUES ('$category_id', '$sub_category_id', '$name', '$gender_id', '$genre_id', '$type_id', '$season_id', '$sillage_id', '$lasting_id', '$breif', '$description', '1', '$image', '$image2', '$image3')");
            $product_id = mysqli_insert_id($con);

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
                    <div class="form-row">

                        <div class="form-group col-6">
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

                        <div class="form-group col-6">
                            <label for="sub_categories" class="form-control-label">Sub Categories</label>
                            <select class="form-control" name="sub_categories_id" id="sub_category">
                                <option selected disabled>Select Sub Category</option>
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

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="gender" class=" form-control-label">Gender</label>
                            <select class="form-control" name="gender_id">

                                <option value="" selected disabled>Select Gender</option>

                                <?php

									$select_gender = mysqli_query($con,"select * from gender");

									while($gender_row = mysqli_fetch_array($select_gender)){
										if($gender_row['id']==$gender_id){
											echo "<option selected value=".$gender_row['id']."> ".$gender_row['gender']." </option>";
										}
										else{
											echo "<option value=".$gender_row['id']."> ".$gender_row['gender']." </option>";
										}
									}

									?>

                            </select>

                        </div>
                        <div class="form-group col-4">
                            <label for="genre" class=" form-control-label">Genre</label>
                            <select class="form-control" name="genre_id">

                                <option value="" selected disabled>Select Genre</option>

                                <?php

									$select_genre = mysqli_query($con,"select * from genre");

									while($genre_row = mysqli_fetch_array($select_genre)){
										if($genre_row['id']==$genre_id){
											echo "<option selected value=".$genre_row['id']."> ".$genre_row['genre']." </option>";
										}
										else{
											echo "<option value=".$genre_row['id']."> ".$genre_row['genre']." </option>";
										}
									}

									?>

                            </select>

                        </div>
                        <div class="form-group col-4">
                            <label for="type" class=" form-control-label">Type</label>
                            <select class="form-control" name="type_id">

                                <option value="" selected disabled>Select Type</option>

                                <?php

									$select_type = mysqli_query($con,"select * from type");

									while($type_row = mysqli_fetch_array($select_type)){
										if($type_row['id']==$type_id){
											echo "<option selected value=".$type_row['id']."> ".$type_row['type']." </option>";
										}
										else{
											echo "<option value=".$type_row['id']."> ".$type_row['type']." </option>";
										}
									}

									?>

                            </select>

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="season" class=" form-control-label">Season</label>
                            <select class="form-control" name="season_id">

                                <option value="" selected disabled>Select Season</option>

                                <?php

									$select_season = mysqli_query($con,"select * from season");

									while($season_row = mysqli_fetch_array($select_season)){
										if($season_row['id']==$season_id){
											echo "<option selected value=".$season_row['id']."> ".$season_row['season']." </option>";
										}
										else{
											echo "<option value=".$season_row['id']."> ".$season_row['season']." </option>";
										}
									}

									?>

                            </select>

                        </div>
                        <div class="form-group col-4">
                            <label for="sillage" class=" form-control-label">Sillage</label>
                            <select class="form-control" name="sillage_id">

                                <option value="" selected disabled>Select Sillage</option>

                                <?php

									$select_sillage = mysqli_query($con,"select * from sillage");

									while($sillage_row = mysqli_fetch_array($select_sillage)){
										if($sillage_row['id']==$sillage_id){
											echo "<option selected value=".$sillage_row['id']."> ".$sillage_row['sillage']." </option>";
										}
										else{
											echo "<option value=".$sillage_row['id']."> ".$sillage_row['sillage']." </option>";
										}
									}

									?>

                            </select>

                        </div>
                        <div class="form-group col-4">
                            <label for="lasting" class=" form-control-label">Lasting</label>
                            <select class="form-control" name="lasting_id">

                                <option value="" selected disabled>Select Lasting</option>

                                <?php

									$select_lasting = mysqli_query($con,"select * from lasting");

									while($lasting_row = mysqli_fetch_array($select_lasting)){
										if($lasting_row['id']==$lasting_id){
											echo "<option selected value=".$lasting_row['id']."> ".$lasting_row['lasting']." </option>";
										}
										else{
											echo "<option value=".$lasting_row['id']."> ".$lasting_row['lasting']." </option>";
										}
									}

									?>

                            </select>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-control-label">Image</label>
                        <input type="file" name="image" class="form-control" <?= $image_required ?>>
                    </div>

                    <div class="form-group">
                        <label for="image2" class="form-control-label">Image 2</label>
                        <input type="file" name="image2" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image3" class="form-control-label">Image 3</label>
                        <input type="file" name="image3" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-control-label">Description</label>
                        <textarea name="description" placeholder="Enter Product Description"
                            class="form-control" required><?= $description ?></textarea>
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