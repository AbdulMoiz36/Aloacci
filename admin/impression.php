<?php
include "top.php";

/* Restrict employee to access this page */
isAdmin();

if (isset($_POST['submit'])) {
  $product_id = $_POST['product'];
  $impression_name = $_POST['impression'];
  $original_name = $_POST['original'];

  // Check for empty fields
  if (!empty($product_id) && !empty($impression_name) && !empty($original_name)) {
    $insert_query = "INSERT INTO impressions (product_id, impression_name, original_name) VALUES ('$product_id', '$impression_name', '$original_name')";
    if (mysqli_query($con, $insert_query)) {
      echo "<script>window.location.href='impression'</script>";
    } else {
      echo "<script>toastr.error('Error adding impression: " . mysqli_error($con) . "');</script>";
    }
  } else {
    echo "<script>toastr.error('All fields are required');</script>";
  }
}

$select = "SELECT * FROM impressions";
$res = mysqli_query($con, $select);
$serial_no = 1;

// Fetch all products
$product_query = "SELECT id, name FROM product";
$product_result = mysqli_query($con, $product_query);
?>
<style>
  /* Hide the number input spinner (buttons) */
  input[type="number"]::-webkit-outer-spin-button,
  input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Optional: To prevent input from growing larger than the specified width */
  input[type="number"] {
    width: 100%;
  }
</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Add Impression</h4>
      </div>
      <div class="card-body">
        <form method="POST" class="row" id="impression-form">
          <div class="col-3">
            <input type="text" name="impression" hidden id="impression" placeholder="Impression Name" class="form-control" required>
            <select name="product" id="product" class="form-control" required>
              <option value="" disabled selected>Select Product</option>
              <?php
              while ($product = mysqli_fetch_assoc($product_result)) {
                echo '<option value="' . $product['id'] . '" data-name="' . htmlspecialchars($product['name']) . '">' . $product['name'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-3">
            <input type="text" name="original" id="original" placeholder="Name Of Original" class="form-control" required>
          </div>
          <div class="col-3">
            <button type="submit" name="submit" class="btn btn-primary btn-action">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Impressions</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="imptab">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Product Name</th>
                <th>Original Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <?php
            if (mysqli_num_rows($res) > 0) {
            ?>
              <tbody>
                <?php
                while ($row = mysqli_fetch_array($res)) {
                ?>
                  <tr>
                    <td><?= $serial_no++; ?></td>
                    <td><?= $row['impression_name'] ?></td>
                    <td><?= $row['original_name'] ?></td>
                    <td>
                      <a href="manage_imp?id=<?=$row['id']?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a href="imp_delete?id=<?=$row['id']?>" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            <?php
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
  const productSelect = document.getElementById('product');
  const impressionInput = document.getElementById('impression');

  productSelect.addEventListener('change', () => {
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const productName = selectedOption.getAttribute('data-name');

    if (productName) {
      impressionInput.value = productName;
    } else {
      impressionInput.value = ''; // Clear the input if no product is selected
    }
  });
});
$(document).ready(function () {
  $('#imptab').DataTable({
    order: [[0, 'desc']] // Order by the first column (index 0) in descending order
  });
});

  </script>

  <?php include "footer.php"; ?>