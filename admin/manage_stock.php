<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$product_id = '';
$format_id = '';
$quantity = '';
$msg = '';
$_id = $_GET['id'];
$select = "select qty from product_stock WHERE id = '$_id'";
$res = mysqli_query($con, $select);
$row = mysqli_fetch_array($res);

// Fetch all products
$product_query = "SELECT id, name FROM product";
$product_result = mysqli_query($con, $product_query);

if (isset($_GET['id']) && $_GET['id'] != '') {
   $_id = get_safe_value($con, $_GET['id']);
   $res = mysqli_query($con, "select * from product_stock where id=$_id");

   $check = mysqli_num_rows($res);

   if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $product_id = $row['product_id'];
      $format_id = $row['format_id'];
      $quantity = $row['qty'];
   } else {
      echo "<script>window.location.href='stock'</script>";
      die();
   }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $product_id_in = get_safe_value($con, $_POST['product']);
   $format_id_in = get_safe_value($con, $_POST['format']);
   $quantity_in = get_safe_value($con, $_POST['quantity']);

   if (empty($product_id_in)) {
      $msg = "Please select a product.";
   } elseif (empty($format_id_in)) {
      $msg = "Please select a format.";
   } elseif (empty($quantity_in) || $quantity_in <= 0) {
      $msg = "Please enter a valid quantity.";
   } else {
      // Proceed with the database update
      if (isset($_GET['id']) && $_GET['id'] != '') {
         $query = mysqli_query($con, "SELECT qty FROM product_format WHERE product_id = '$product_id' AND id = '$format_id'");
         $f_row = mysqli_fetch_assoc($query);
         $qty_previous = $f_row['qty'] - $quantity;
         mysqli_query($con, "UPDATE product_format set qty='$qty_previous' WHERE product_id = '$product_id' AND id = '$format_id'");
         $fn_query = mysqli_query($con, "SELECT qty FROM product_format WHERE id = '$format_id_in'");
         $fn_row = mysqli_fetch_array($fn_query);
         $qty_new_previous = $fn_row['qty'];
         mysqli_query($con, "update product_stock set qty='$quantity_in',product_id='$product_id_in',format_id='$format_id_in' where id='$_id'");
         $final_qty = $qty_new_previous + $quantity_in;
         mysqli_query($con, "update product_format set qty='$final_qty' WHERE product_id='$product_id_in'AND id='$format_id_in'");
      }

      echo "<script>window.location.href='stock'</script>";
      die();
   }
}



  

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
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h4>Stock</h4><span>Edit Form</span>
         </div>
         <form method="post" onsubmit="return validateForm()">
            <div class="card-body card-block">
               <div class="row">
                  <!-- Product Select -->
                  <div class="col-3">
                     <select name="product" id="product" class="form-control" required>
                        <option value="" disabled selected>Select Product</option>
                        <?php
                        while ($product = mysqli_fetch_assoc($product_result)) {
                           $selected = ($product_id == $product['id']) ? 'selected' : '';
                           echo '<option value="' . $product['id'] . '" ' . $selected . '>' . $product['name'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
                  <!-- Format Select -->
                  <div class="col-3">
                     <select name="format" id="format" class="form-control" required>
                        <option value="" disabled selected>Select Format</option>
                        <?php
                        $format_result = mysqli_query($con, "SELECT id,format,unit_of_measure FROM product_format WHERE product_id = '$product_id'");
                        if (!empty($format_result)) {
                           while ($format = mysqli_fetch_assoc($format_result)) {
                              $selected = ($format_id == $format['id']) ? 'selected' : '';
                              echo '<option value="' . $format['id'] . '" ' . $selected . '>' . $format['format'] . ' ' . $format['unit_of_measure'] . '</option>';
                           }
                        }
                        ?>
                     </select>
                  </div>
                  <!-- Quantity Input -->
                  <div class="col-3">
                     <input type="number" name="quantity" id="quantity" value="<?= $row['qty'] ?>" class="form-control" min="1" placeholder="Enter Quantity" required>
                  </div>
               </div>
               <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-primary btn-block mt-3">
                  <span id="payment-button-amount ">Submit</span>
               </button>
               <div style="color: red; margin-top: 10px;">
                  <?= $msg ?>
               </div>
            </div>
         </form>

      </div>
   </div>
   <script>
      function validateForm() {
         const product = document.getElementById("product").value;
         const format = document.getElementById("format").value;
         const quantity = document.getElementById("quantity").value;

         if (!product) {
            alert("Please select a product.");
            return false;
         }
         if (!format) {
            alert("Please select a format.");
            return false;
         }
         if (!quantity || quantity <= 0) {
            alert("Please enter a valid quantity.");
            return false;
         }

         return true;
      }

      document.addEventListener("DOMContentLoaded", function() {
         const quantityInput = document.getElementById("quantity");

         // Disable scrolling on number input
         quantityInput.addEventListener("wheel", function(event) {
            event.preventDefault(); // Prevent scroll behavior on the number input
         });
      });

      $(document).ready(function() {
         // When a product is selected
         $('#product').on('change', function() {
            let productId = $(this).val();

            // Clear previous formats
            $('#format').html('<option value="">Select Format</option>');

            if (productId) {
               // AJAX request to fetch formats
               $.ajax({
                  url: 'fetch_formats.php', // Backend file to fetch formats
                  type: 'POST',
                  data: {
                     product_id: productId
                  },
                  dataType: 'json',
                  success: function(data) {
                     if (data.length > 0) {
                        $.each(data, function(index, format) {
                           $('#format').append('<option value="' + format.id + '">' + format.format + ' ' + format.unit_of_measure + '</option>');
                        });
                     } else {
                        $('#format').html('<option value="">No formats available</option>');
                     }
                  },
                  error: function() {
                     alert('Failed to fetch formats. Please try again.');
                  }
               });
            }
         });
      });
   </script>

   <?php
   include "footer.php"
   ?>