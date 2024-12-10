<?php
include 'top.php';
isAdmin();
$_id = $_GET['id'];
$select = mysqli_query($con, "SELECT *  FROM impressions WHERE id = '$_id'");
$row = mysqli_fetch_array($select);
// Fetch all products
$product_query = "SELECT id, name FROM product";
$product_result = mysqli_query($con, $product_query);

// Handle the form submission
if (isset($_POST['submit'])) {
    $impression_name = mysqli_real_escape_string($con, $_POST['impression']);
    $product_id = mysqli_real_escape_string($con, $_POST['product']);
    $original_name = mysqli_real_escape_string($con, $_POST['original']);

    // Update the record
    $update_query = "UPDATE impressions 
                     SET impression_name = '$impression_name', 
                         product_id = '$product_id', 
                         original_name = '$original_name' 
                     WHERE id = '$_id'";

    if (mysqli_query($con, $update_query)) {
        echo "<script>
                window.location.href = 'impression'; // Redirect to the impressions list page
              </script>";
    } else {
        echo "<script>alert('Error updating impression. Please try again.');</script>";
    }
}
?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Add Impression</h4>
            </div>
            <div class="card-body">
                <form method="POST" class="row" id="impression-form">
                    <div class="col-3">
                        <input type="text" name="impression" hidden id="impression" placeholder="Impression Name" class="form-control" value="<?=$row['impression_name']?>" required>
                        <select name="product" id="product" class="form-control" required>
                            <option value="" disabled>Select Product</option>
                            <?php
                            while ($product = mysqli_fetch_assoc($product_result)) {
                                $selected = ($row['product_id'] == $product['id']) ? 'selected' : ''; // Check if this is the selected product
                                echo '<option value="' . $product['id'] . '" ' . $selected . ' data-name="' . htmlspecialchars($product['name']) . '">' . $product['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" name="original" id="original" placeholder="Name Of Original" class="form-control" value="<?=$row['original_name']?>" required>
                    </div>
                    <div class="col-3">
                        <button type="submit" name="submit" class="btn btn-primary btn-action">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>