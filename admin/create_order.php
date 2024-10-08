<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>User Information</h4><span>Form</span>
            </div>
            <div class="card-body card-block">
                <div class="form-row">

                    <div class="form-group col-6">
                        <label for="mobile" class="form-control-label">Phone Number*</label>
                        <input type="text" name="mobile" placeholder="Enter Phone Number" class="form-control" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="email" class="form-control-label">Email <span>(optional)</span></label>
                        <input type="email" name="email" placeholder="Enter Email" class="form-control">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-6">
                        <label for="city" class="form-control-label">City*</label>
                        <input type="text" name="city" placeholder="Enter City" class="form-control" required>
                    </div>

                    <div class="form-group col-6">
                        <label for="address" class="form-control-label">Address*</label>
                        <input type="text" name="address" placeholder="Enter Address" class="form-control" required>
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

                    <div class="form-group col-4">
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

                    <div class="form-group col-4">
                        <label for="product_format" class="form-control-label">Product Variant</label>
                        <select class="form-control" name="product_format_id" id="format">
                            <option selected disabled>Select Product Variant</option>
                            <!-- Formats will be loaded by AJAX based on the selected product -->
                        </select>
                    </div>

                    <div class="form-group col-4">
                        <label for="qty" class="form-control-label">Qty</label>
                        <input type="text" name="qty" placeholder="Enter Qty" class="form-control" required>
                    </div>

                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    $(document).ready(function() {
                        // Load product formats dynamically when the product is changed
                        $('#product').change(function() {
                            var product_id = $(this).val();
                            $.ajax({
                                url: 'get_formats.php', // Make sure this URL is correct
                                type: 'POST',
                                data: {
                                    product_id: product_id
                                },
                                success: function(data) {
                                    $('#format').html(data);
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
            <div class="card">
                <div class="card-header">
                    <h4>Orders</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Format</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class=" pb-0">
                                    <td>Musk</td>
                                    <td>50ml</td>
                                    <td>2</td>
                                    <td>350</td>
                                    <td>700</td>
                                </tr>
                                <tr class=" pb-0">
                                    <td>Blue Sea</td>
                                    <td>20ml</td>
                                    <td>3</td>
                                    <td>200</td>
                                    <td>600</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center" ; colspan="3"><b>Total Amount</b></td>
                                    <td><b>1300</b></td>
                                </tr>
                            </tbody>
                        </table>
                    <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-primary btn-block">
                        <span id="payment-button-amount">Confirm Order</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php"
?>