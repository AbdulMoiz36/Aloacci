<?php
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$select = "select ps.*,p.name,pf.format,pf.unit_of_measure from product_stock as ps JOIN product as p ON ps.product_id = p.id JOIN product_format as pf ON ps.format_id = pf.id";
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
        <h4>Add New Stock</h4>
      </div>
      <div class="card-body">
        <form action="" class="row" id="stock-form">
          <div class="col-3"><select name="product" id="product" class="form-control">
              <option value="" disabled selected>Select Product</option>
              <?php
              while ($product = mysqli_fetch_assoc($product_result)) {
                echo '<option value="' . $product['id'] . '">' . $product['name'] . '</option>';
              }
              ?>
            </select></div>
          <div class="col-3"><select name="format" id="format" class="form-control">
              <option value="" disabled selected>Select Format</option>
            </select></div>
          <div class="col-3"> <input type="number" name="quantity" id="quantity" class="form-control" min="1" placeholder="Enter Quantity"></div>
          <div class="col-3"><button type="submit" class="btn btn-primary btn-action">Add Stock</button></div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Stock</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="mytab">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Product Name</th>
                <th>Product Format</th>
                <th>Qty Added</th>
                <th>Date</th>
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
                  <tr class=" pb-0">
                    <td> <?= $row['id'] ?> </td>
                    <td> <?= $row['name'] ?> </td>
                    <td> <?= $row['format'] ?> <?= $row['unit_of_measure'] ?></td>
                    <td> <?= $row['qty'] ?> </td>
                    <td> <?= $row['date'] ?> </td>
                    <td>

                      <a href="manage_stock?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1"
                        data-toggle="tooltip" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a href="#" class="btn btn-danger btn-action btn-delete" data-url="stock_delete.php?id=<?= $row['id'] ?>" data-toggle="tooltip"
                        title="Delete">
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
  <style>
    /* Custom Modal Styling */
    .custom-modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      z-index: 1;
      /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
      /* Background overlay */
    }

    .custom-modal-content {
      background-color: #fff;
      margin: 15% auto;
      padding: 20px;
      border-radius: 8px;
      width: 50%;
    }

    .custom-modal-header {
      display: flex;
      /* justify-content: ; */
      align-items: center;
    }

    .custom-modal-header h5 {
      margin: 0 auto;
      align-self: center;
    }

    .custom-modal-close {
      font-size: 28px;
      font-weight: bold;
      color: #aaa;
      cursor: pointer;
    }

    .custom-modal-close:hover,
    .custom-modal-close:focus {
      color: black;
      text-decoration: none;
    }

    .custom-modal-body {
      margin-top: 20px;
    }

    .custom-modal-footer {
      display: flex;
      justify-content: flex-end;
      margin-top: 20px;
    }

    .custom-modal-footer button {
      margin-left: 10px;
    }
  </style>

  <!-- Custom Delete Confirmation Modal -->
  <div id="customDeleteModal" class="custom-modal">
    <div class="custom-modal-content">
      <div class="custom-modal-header">
        <span id="closeModal" class="custom-modal-close">&times;</span>
        <h5 class="">Confirm Deletion</h5>
      </div>
      <div class="custom-modal-body">
        Are you sure you want to delete this stock item?
      </div>
      <div class="custom-modal-footer">
        <button id="cancelDelete" class="btn btn-secondary">Cancel</button>
        <button id="confirmDelete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>

  <script>
    let deleteUrl = ''; // To store the delete URL dynamically

    $(document).ready(function() {
      // Trigger the custom modal and set the delete URL
      $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        deleteUrl = $(this).data('url'); // Get the delete URL from data-url attribute
        $('#customDeleteModal').fadeIn(); // Show the custom modal
      });

      // Close the modal
      $('#closeModal, #cancelDelete').on('click', function() {
        $('#customDeleteModal').fadeOut(); // Close the modal
      });

      // Handle the delete confirmation
      $('#confirmDelete').on('click', function() {
        if (deleteUrl) {
          window.location.href = deleteUrl; // Redirect to the delete URL
        }
      });

    });

    // Disable scrolling on number input
    document.addEventListener("DOMContentLoaded", function() {
      const quantityInput = document.getElementById("quantity");

      // Disable scrolling on number input
      quantityInput.addEventListener("wheel", function(event) {
        event.preventDefault(); // Prevent scroll behavior on the number input
      });
    });

    $(document).ready(function() {
      // Initialize the DataTable with descending order on the first column (index 0)
      $('#mytab').DataTable({
        "order": [
          [0, 'desc']
        ],
      });

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

      // Handle form submission via AJAX
      $('#stock-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Validate form inputs
        var product = $('#product').val();
        var format = $('#format').val();
        var quantity = $('#quantity').val();

        if (product === "" || format === "" || quantity === "") {
          alert('Please fill all fields.');
          return;
        }

        // AJAX request to submit the data to the server
        $.ajax({
          url: 'add_stock.php', // Backend file for adding stock
          type: 'POST',
          contentType: 'application/json', // Send data as JSON
          data: JSON.stringify({
            product: product,
            format: format,
            quantity: quantity
          }),
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              // Clear form inputs after success
              $('#product').val('');
              $('#format').html('<option value="">Select Format</option>');
              $('#quantity').val('');

              // Reload the stock table with the updated data
              loadStockTable(response.data);
              // Show success toast notification
              toastr.success('Stock added successfully!');
            } else {
              alert('Failed to add stock. Please try again.');
            }
          },
          error: function() {
            alert('An error occurred. Please try again.');
          }
        });
      });

      // Function to load the updated stock table
      function loadStockTable(stockData) {
        var tableBody = $('#mytab tbody');
        tableBody.empty(); // Clear existing table rows

        if (stockData.length > 0) {
          // Get the DataTable instance
          var table = $('#mytab').DataTable();

          // Clear existing data in the table
          table.clear();

          // Add new data to the table
          table.rows.add(stockData.map(function(row) {
            return [
              row.id, // First column: id
              row.name, // Second column: name
              row.format + ' ' + row.unit_of_measure, // Third column: format
              row.qty, // Fourth column: qty
              row.date, // Fifth column: date
              '<a href="manage_stock?id=' + row.id + '" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">' +
              '<i class="fas fa-pencil-alt"></i>' +
              '</a>' +
              '<a href="#" class="btn btn-danger btn-action btn-delete" data-url="stock_delete.php?id=' + row.id + '" data-toggle="tooltip" title="Delete">' +
              '<i class="fas fa-trash-alt"></i>' +
              '</a>'
            ];
          }));

          // Draw the table to reflect the changes
          table.draw();
        } else {
          tableBody.append('<tr><td colspan="6">No stock data available</td></tr>');
        }
      }
    });
  </script>


  <?php
  include "footer.php";
  ?>