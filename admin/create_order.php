<?php
include "top.php";

/* Restrict employee to access this page */
isAdmin();
?>

<style>
    /* For Chrome, Safari, Edge, and Opera */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* For Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>User Information</h4><span>Form</span>
            </div>
            <div class="card-body card-block">
                <div class="form-row">

                    <div class="form-group col-6">
                        <label for="name" class="form-control-label">Name</label>
                        <input type="text" name="name" placeholder="Enter Name" class="form-control">
                    </div>

                    <div class="form-group col-6">
                        <label for="mobile" class="form-control-label">Phone Number</label>
                        <input type="text" name="mobile" placeholder="Enter Phone Number" class="form-control">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-6">
                        <label for="city" class="form-control-label">City</label>
                        <input type="text" name="city" placeholder="Enter City" class="form-control">
                    </div>

                    <div class="form-group col-6">
                        <label for="address" class="form-control-label">Address</label>
                        <input type="text" name="address" placeholder="Enter Address" class="form-control">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Add Product</h4><span>Form</span>
            </div>
            <div class="card-body card-block">
                <div class="form-row">

                    <div class="form-group col-3">
                        <label for="product" class="form-control-label">Product</label>
                        <select class="form-control" name="product_id" id="product" onchange="fetchFormats(this.value)">
                            <option selected disabled>Select Product</option>
                            <?php
                            $product = mysqli_query($con, "SELECT * FROM product");
                            while ($row = mysqli_fetch_array($product)) {
                                $selected = ($row['id'] == $product_id) ? 'selected' : '';
                                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-3">
                        <label for="product_format" class="form-control-label">Product Variant</label>
                        <select class="form-control" name="product_format_id" id="format">
                            <option selected disabled>Select Product Variant</option>
                            <!-- Formats will be loaded by AJAX based on the selected product -->
                        </select>
                    </div>

                    <div class="form-group col-3">
                        <label for="qty" class="form-control-label">Qty</label>
                        <input type="number" name="qty" id="qty" placeholder="Enter Qty" class="form-control" required>
                    </div>

                    <div class="form-group col-3">
                        <label for="price" class="form-control-label">Price</label>
                        <input type="text" id="price" class="form-control" readonly>
                    </div>

                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    $(document).ready(function() {
                        var products = [];
                        var totalAmount = 0; // Initialize total amount
                        // Initially hide the orders table
                        $('#order-table').hide();
                        // Load product formats dynamically when the product is changed
                        $('#product').change(function() {
                            var product_id = $(this).val();
                            $.ajax({
                                url: 'get_formats',
                                type: 'POST',
                                data: {
                                    product_id: product_id
                                },
                                success: function(data) {
                                    $('#format').html(data);
                                    $('#price').val(''); // Clear price when product changes
                                }
                            });
                        });
                        // Update the price when a product format is selected
                        $('#format').change(function() {
                            var price = $('#format option:selected').data('price');
                            $('#price').val(price); // Set price in price field
                        });
                        $('#payment-button').click(function(e) {
                            e.preventDefault();
                            var product_id = $('#product').val();
                            var format_id = $('#format').val();
                            var qty = $('#qty').val();
                            var product_name = $('#product option:selected').text();
                            var format_name = $('#format option:selected').text();
                            var price = $('#format option:selected').data(
                                'price'); // Get price from the selected format
                            var total_price = qty * price;
                            // Validate if quantity is greater than 0
                            if (qty <= 0) {
                                alert("Quantity must be greater than zero.");
                                return;
                            }
                            if (product_id && format_id && qty) {
                                // Check stock availability
                                $.ajax({
                                    url: 'check_stock',
                                    type: 'POST',
                                    data: {
                                        product_id: product_id,
                                        format_name: format_name
                                    },
                                    success: function(response) {
                                        var data = JSON.parse(response);
                                        var available_stock = data.available_stock;
                                        // Check if requested quantity exceeds available stock
                                        if (qty > available_stock) {
                                            alert("Requested quantity exceeds available stock. Available: " +
                                                available_stock);
                                            return; // Stop the execution
                                        }
                                        // Proceed to add the product to the order
                                        var product = {
                                            product_id: product_id,
                                            format_id: format_id,
                                            qty: qty,
                                            price: price,
                                            total_price: total_price
                                        };
                                        products.push(product);
                                        // Show the order table if not already visible
                                        if (products.length > 0) {
                                            $('#order-table').show();
                                        }
                                        // Create a new row
                                        var row = `<tr>
                    <td>${product_name}</td>
                    <td>${format_name}</td>
                    <td>${qty}</td>
                    <td>${price}</td>
                    <td>${total_price}</td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-product"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>`;
                                        $('tbody').append(row);
                                        // Update total amount
                                        totalAmount += parseFloat(total_price);
                                        $('#total-amount').text(totalAmount.toFixed(
                                            2)); // Update the total in the table
                                        // Clear the input fields
                                        $('#qty').val('');
                                        $('#price').val(''); // Clear the price field
                                        $('#format').prop('selectedIndex',
                                            0
                                        ); // Reset format dropdown to the first option (default)
                                    }
                                });
                            } else {
                                alert("Please select a product, variant, and quantity.");
                            }
                        });
                        // Delete product functionality
                        $(document).on('click', '.delete-product', function() {
                            var row = $(this).closest('tr');
                            // Subtract the total price from the total amount
                            totalAmount -= parseFloat(row.find('td:eq(4)').text());
                            $('#total-amount').text(totalAmount.toFixed(
                                2)); // Update the total in the table
                            // Remove the row from the table
                            row.remove();
                            // Check if there are no products left and hide the orders table
                            if ($('tbody tr').length === 0) {
                                $('#order-table').hide();
                            }
                        });
                        // Confirm and submit the order
                        $('#confirm-order').click(function(e) {
                            e.preventDefault();
                            if (products.length === 0) {
                                alert("No products added!");
                                return;
                            }
                            // Collect user information
                            var mobile = $('input[name="mobile"]').val();
                            var name = $('input[name="name"]').val();
                            var city = $('input[name="city"]').val();
                            var address = $('input[name="address"]').val();
                            // Check if required user fields are empty
                            if (!name || !mobile || !city || !address) {
                                alert("Please fill out all empty fields");
                                return;
                            }
                            $.ajax({
                                url: 'save_order',
                                type: 'POST',
                                data: {
                                    products: products,
                                    mobile: mobile,
                                    name: name,
                                    city: city,
                                    address: address
                                },
                                success: function(response) {
                                    // Display SweetAlert notification
                                    swal({
                                        title: "Order Confirmed!",
                                        text: "Your order has been successfully placed.",
                                        icon: "success",
                                        button: "OK",
                                    });

                                    // Clear input fields
                                    $('input[name="name"]').val('');
                                    $('input[name="mobile"]').val('');
                                    $('input[name="city"]').val('');
                                    $('input[name="address"]').val('');
                                    $('#qty').val(''); // Clear quantity field
                                    $('#price').val(''); // Clear price field
                                    $('#format').prop('selectedIndex', 0); // Reset format dropdown to the first option (default)
                                    $('#product').prop('selectedIndex', 0); // Reset product dropdown to the first option (default)

                                    // Clear the order table and reset total amount
                                    products = [];
                                    totalAmount = 0;
                                    $('tbody').empty();
                                    $('#total-amount').text(totalAmount.toFixed(2)); // Reset total amount display
                                    $('#order-table').hide(); // Hide the table after order confirmation
                                },
                                error: function(xhr, status, error) {
                                    alert("An error occurred: " + xhr.responseText);
                                }
                            });
                        });
                    });
                </script>

                <button id="payment-button" name="submit" class="btn btn-lg btn-primary">
                    <span id="payment-button-amount">Add Product</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card" id="order-table" style="display: none;">
                <div class="card-header">
                    <h4>Orders</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Format</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- Products will be appended here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: left;"><strong>Total Amount:</strong></td>
                                    <td id="total-amount">0</td>
                                </tr>
                            </tfoot>
                        </table>
                        <button id="confirm-order" class="btn btn-lg btn-primary btn-block">
                            <span id="payment-button-amount">Confirm Order</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>