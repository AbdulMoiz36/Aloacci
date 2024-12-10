<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


// Fetch products from the database
$products = [];
$sql = "SELECT id, name FROM product";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

if (isset($_GET['id']) && $_GET['id'] != 0) {
    $_id = $_GET['id'];
    $fetch_bundle = mysqli_query($con, "SELECT * FROM bundles WHERE id = '$_id'");
    $bundle = mysqli_fetch_assoc($fetch_bundle);
}


?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

                <h4>Manage Bundle</h4>
            </div>
            <script>
                function calculate_discount() {
                    var totalAmount = 0; // Initialize totalAmount

                    // Iterate through all rows in the table
                    $('table tbody tr').each(function() {
                        var rowTotalPrice = parseFloat($(this).find('td:eq(4)').text()); // Get the total price from the 4th index
                        if (!isNaN(rowTotalPrice)) {
                            totalAmount += rowTotalPrice; // Add to the totalAmount
                        }
                    });
                    $('#total-amount').text(totalAmount);

                    // Get the discount value from the input
                    var discount = parseFloat($('#discountValue').val()); // Ensure it's a number

                    // Check if the totalAmount and discount are valid numbers
                    if (!isNaN(totalAmount) && !isNaN(discount) && discount > 0) {
                        // Calculate the discount based on the selected type
                        var discountType = $('#discountType').val();

                        if (discountType === 'price') {
                            totalAmount -= discount; // Subtract fixed discount
                        } else if (discountType === 'percentage') {
                            totalAmount -= (totalAmount * (discount / 100)); // Apply percentage discount
                        }

                        // Ensure totalAmount doesn't go below zero
                        totalAmount = Math.max(totalAmount, 0);

                        // Update the total discount amount in the UI
                        $('#total-discount-amount').text(totalAmount.toFixed(2)); // Format to 2 decimal places
                    } else {
                        // If no valid discount is provided, just show the original total amount
                        $('#total-discount-amount').text(totalAmount.toFixed(2));
                    }
                }
            </script>
            <div class="card-body form-row">
                <!-- Discount Value Input -->
                <div class="form-group col-6">
                    <label for="discountValue">Discount Value</label>
                    <input type="number" id="discountValue" class="form-control" value="<?= $bundle['discount_value'] ?>" placeholder="Enter discount value" min="0" onchange="calculate_discount()">
                </div>

                <!-- Discount Type Dropdown -->
                <div class="form-group col-6">
                    <label for="discountType">Discount Type</label>
                    <select id="discountType" class="form-control" onchange="calculate_discount()">
                        <option value="price" <?php echo (isset($bundle) && $bundle['discount_type'] == 'price') ? 'selected' : ''; ?>>Price (Rs.)</option>
                        <option value="percentage" <?php echo (isset($bundle) && $bundle['discount_type'] == 'percentage') ? 'selected' : ''; ?>>Percentage (%)</option>
                    </select>

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
                    <select class="form-control" name="product_id[]" id="product">
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
                    <select class="form-control" name="product_format_id[]" id="format">
                        <option selected disabled>Select Product Variant</option>
                        <!-- Formats will be loaded by AJAX based on the selected product -->
                    </select>
                </div>

                <div class="form-group col-3">
                    <label for="qty" class="form-control-label">Qty</label>
                    <input type="number" name="qty[]" id="qty" placeholder="Enter Qty" class="form-control" required>
                </div>

                <div class="form-group col-3">
                    <label for="price" class="form-control-label">Price</label>
                    <input type="text" id="price" class="form-control" readonly>
                </div>

            </div>


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
                <h4>Products</h4>
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
                            <?php
                            if (isset($_GET['id']) && $_GET['id'] != 0) {
                                $_id = $_GET['id'];
                                // Note: We use $_id without quotes in the query
                                $fetch_products = mysqli_query($con, "SELECT bd.product_id, bd.format_id, p.name, pf.format, pf.unit_of_measure, bd.qty, pf.price 
                                          FROM bundle_details as bd 
                                          JOIN product as p ON bd.product_id = p.id 
                                          JOIN product_format as pf ON bd.format_id = pf.id 
                                          WHERE bd.bundle_id = '$_id'");

                                // Check if there are products
                                if (mysqli_num_rows($fetch_products) > 0) {
                                    // Initialize the products array for JavaScript
                                    $products = [];
                                    while ($product = mysqli_fetch_assoc($fetch_products)) {
                                        $total_price = $product['qty'] * $product['price']; // Calculate total price
                                        // Store the product info for JavaScript
                                        $products[] = [
                                            'product_id' => $product['product_id'],
                                            'format_id' => $product['format_id'],
                                            'qty' => $product['qty']
                                        ];
                            ?>

                                        <tr data-format-id="<?php echo htmlspecialchars($product['format_id']); ?>">
                                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                                            <td><?php echo htmlspecialchars($product['format'] . $product['unit_of_measure']); ?></td>
                                            <td><?php echo htmlspecialchars($product['qty']); ?></td>
                                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                                            <td><?php echo htmlspecialchars($total_price); ?></td>
                                            <td><button class="btn btn-danger btn-sm delete-product"><i class="fas fa-trash-alt"></i></button></td>
                                        </tr>

                            <?php
                                    }
                                }
                            }
                            ?>

                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: left;"><strong>Total Amount:</strong></td>
                                <td id="total-amount">
                                    <?php
                                    if (isset($_GET['id']) && $_GET['id'] != 0) {
                                        echo $bundle['total_amount'];
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: left;"><strong>Total Amount After Discount:</strong></td>
                                <td id="total-discount-amount">
                                    <?php
                                    if (isset($_GET['id']) && $_GET['id'] != 0) {
                                        echo $bundle['discount_amount'];
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <?php
                    if (isset($_GET['id']) && $_GET['id'] != 0) {
                    ?>
                        <button id="edit-bundle" class="btn btn-lg btn-primary">
                            <span id="edit-bundle">Save Changes</span>
                        </button>
                    <?php
                    } else {
                    ?>
                        <button id="confirm-order" class="btn btn-lg btn-primary">
                            <span id="payment-button-amount">Save Bundle</span>
                        </button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var totalAmount = 0; // Initialize total amount
        // Initially hide the orders table
        <?php
        if (isset($_GET['id']) && $_GET['id'] != 0) {
            echo "var products = " . json_encode($products) . ";";
            echo "$('#order-table').show();";
        } else {
            echo "var products = [];";
            echo "$('#order-table').hide();";
        }
        ?>
        console.log(products);

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
            var format_name = $('#format option:selected').data('format');
            var format_unit = $('#format option:selected').data('unit');
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
                        };
                        products.push(product);
                        // Show the order table if not already visible
                        if (products.length > 0) {
                            $('#order-table').show();
                        }
                        // Create a new row
                        var row = `<tr data-format-id='${format_id}'>
                                                        <td>${product_name}</td>
                                                        <td>${format_name}${format_unit}</td>
                                                        <td>${qty}</td>
                                                        <td>${price}</td>
                                                        <td>${total_price}</td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm delete-product"><i class="fas fa-trash-alt"></i></button>
                                                        </td>
                                                    </tr>`;
                        $('tbody').append(row);

                        calculate_discount();

                        // Clear the input fields
                        $('#qty').val('');
                        $('#price').val(''); // Clear the price field
                        $('#product').prop('selectedIndex',
                            0
                        ); // Reset format dropdown to the first option (default)
                        $('#format').prop('selectedIndex',
                            0
                        ); // Reset format dropdown to the first option (default)
                    }
                });
            } else {
                alert("Please select a product, variant, and quantity.");
            }
        });

        $(document).on('click', '.delete-product', function() {
            var row = $(this).closest('tr');
            var totalAmount = parseFloat($('#total-amount').text());

            // Get the values from the row
            var price = parseFloat(row.find('td:eq(3)').text()); // Price column
            var totalPrice = parseFloat(row.find('td:eq(4)').text()); // Total Price column

            // Get the format_id from the row's data attribute (ensure this is set correctly in HTML)
            var formatId = row.data('format-id').toString(); // Ensure it's a string
            console.log('Retrieved formatId:', formatId); // Log the retrieved formatId

            // Subtract the total price from the total amount
            totalAmount -= totalPrice; // Use totalPrice instead of price since it's already multiplied by qty
            $('#total-amount').text(totalAmount.toFixed(2)); // Update the total in the table

            // Subtract the total price from the total after discount (if discount is applied)
            var discountAmount = parseFloat($('#total-discount-amount').text());
            discountAmount -= totalPrice; // Same logic applies to discount amount
            $('#total-discount-amount').text(discountAmount.toFixed(2)); // Update discount amount

            // Remove the row from the table
            row.remove();

            // Log the current state of the products array
            console.log('Products before removal:', products);

            // Make sure product.format_id is also treated as a string
            var productIndex = products.findIndex(product => product.format_id.toString() === formatId);
            console.log('Product index to remove:', productIndex);

            if (productIndex !== -1) {
                products.splice(productIndex, 1); // Remove product from the array
                console.log('Products after removal:', products);
            } else {
                console.log('Product not found in the array');
            }

            // Check if there are no products left and hide the orders table
            if ($('tbody tr').length === 0) {
                $('#order-table').hide();
            }
        });





        $('#confirm-order').click(function(e) {
            e.preventDefault(); // Prevent default form submission or page reload

            // Collect data
            var discountValue = parseFloat($('#discountValue').val()); // Discount value
            var discountType = $('#discountType').val(); // Discount type (price or percentage)
            var totalAmount = parseFloat($('#total-amount').text()); // Total amount
            var discountAmount = parseFloat($('#total-discount-amount').text()); // Discounted total amount

            // Validate discount value
            if (isNaN(discountValue) || discountValue <= 0) {
                alert("Discount value must be greater than 0.");
                return; // Stop execution if validation fails
            }

            // Prepare data for AJAX
            var requestData = {
                discount_value: discountValue,
                discount_type: discountType || 'price', // Default to 'price' if not selected
                discount_amount: isNaN(discountAmount) ? 0 : discountAmount, // Ensure a valid number
                total_amount: isNaN(totalAmount) ? 0 : totalAmount, // Ensure a valid number
                products: products // The array of products
            };

            // AJAX request
            $.ajax({
                url: 'save_bundle', // Replace with your backend endpoint
                type: 'POST',
                data: JSON.stringify(requestData), // Send data as a JSON string
                contentType: 'application/json', // Specify content type
                success: function(response) {
                    // Handle success response
                    window.location.href = 'bundles';
                    console.log(response); // Debugging/logging response
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert("An error occurred while saving the bundle. Please try again.");
                    console.error("Error:", error);
                }
            });
        });

        $('#edit-bundle').click(function(e) {
            e.preventDefault(); // Prevent default form submission or page reload
            // Get the ID from the URL (assuming the ID is in the query string)
            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id'); // Extract 'id' from the URL

            // Collect data
            var discountValue = parseFloat($('#discountValue').val()); // Discount value
            var discountType = $('#discountType').val(); // Discount type (price or percentage)
            var totalAmount = parseFloat($('#total-amount').text()); // Total amount
            var discountAmount = parseFloat($('#total-discount-amount').text()); // Discounted total amount

            // Validate discount value
            if (isNaN(discountValue) || discountValue <= 0) {
                alert("Discount value must be greater than 0.");
                return; // Stop execution if validation fails
            }

            // Prepare data for AJAX
            var requestData = {
                discount_value: discountValue,
                discount_type: discountType || 'price', // Default to 'price' if not selected
                discount_amount: isNaN(discountAmount) ? 0 : discountAmount, // Ensure a valid number
                total_amount: isNaN(totalAmount) ? 0 : totalAmount, // Ensure a valid number
                products: products, // The array of products
                id: id // Add the ID to the request data
            };

            // AJAX request
            $.ajax({
                url: 'edit_bundle', // Replace with your backend endpoint
                type: 'POST',
                data: JSON.stringify(requestData), // Send data as a JSON string
                contentType: 'application/json', // Specify content type
                success: function(response) {
                    window.location.href = 'manage_bundle?id=' + id;
                    console.log(response); // Debugging/logging response
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    alert("An error occurred while saving the bundle. Please try again.");
                    console.error("Error:", error);
                }
            });
        });


    });
</script>




<?php
include "footer.php"
?>