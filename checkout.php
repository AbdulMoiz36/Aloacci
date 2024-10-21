<?php
include 'header.php';

// $user_id = $_SESSION['USER_ID'];
$user_id = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;

if (!isset($_SERVER['HTTP_REFERER'])) {
    echo "<script>window.location.href='shop'</script>";
    exit;
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "<script>window.location.href='shop'</script>";
}


$data = ['name' => '', 'email' => '', 'mobile' => '', 'address' => '', 'city' => ''];
if ($user_id) {
    $sql = mysqli_query($con, "SELECT `name`, `email`, `mobile`, `address`, `city` FROM `users` WHERE `id` = '$user_id'");
    $data = mysqli_fetch_assoc($sql);
}


// Initialize cart total
$cart_total = 0;
$cart_empty = true;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart_empty = false;
    foreach ($_SESSION['cart'] as $key => $val) {
        // Split the $key into $pid and $format
        list($pid, $selected_format) = explode('_', $key);
        $productArr = get_product($con, '', '', $pid);
        $price = $val['price'];
        $qty = $val['qty'];
        $total_price = $price * $qty;
        $cart_total += $total_price; // Calculate total
    }
}

$shipping_cost = 250; // Default shipping cost
if (isset($_POST['submit'])) {
    $address = get_safe_value($con, $_POST['address']);
    $email = get_safe_value($con, $_POST['email']);
    $name = get_safe_value($con, $_POST['name']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $city = get_safe_value($con, $_POST['city']);

    // Check city for shipping cost
    if ($city === 'Karachi') {
        $shipping_cost = 180;
    }

    // Check if the subtotal exceeds the shipping price from the shipment table
    $shipment_sql = mysqli_query($con, "SELECT `price` FROM `shipment` WHERE `status` = 1");
    $shipment_data = mysqli_fetch_assoc($shipment_sql);
    $shipment_price = $shipment_data['price'];

    if ($cart_total > $shipment_price) {
        $shipping_cost = 0; // Free shipping if subtotal exceeds shipment price
    }

    $total_price = $cart_total + $shipping_cost; // Total price including shipping
    $order_status = '1';
    $date = date('Y-m-d H:i:s'); // Proper date format
    if ($user_id == null) {
        // Insert order details into the orders table
        mysqli_query($con, "INSERT INTO orders (name, email, mobile, address, city, total_price, shipping, order_status, date) 
                        VALUES ('$name', '$email', '$mobile', '$address', '$city', '$total_price', '$shipping_cost', '$order_status', '$date')");
        $order_id = mysqli_insert_id($con); // Get the order ID for the order
        // Insert each product in the cart into orders_detail
        foreach ($_SESSION['cart'] as $key => $val) {
            list($pid, $selected_format) = explode('_', $key); // Split product ID and format
            $price = $val['price'];
            $qty = $val['qty'];

            // Insert each product format into the orders_detail table
            mysqli_query($con, "INSERT INTO orders_detail (order_id, product_id, format, qty, price) 
                            VALUES ('$order_id', '$pid', '$selected_format', '$qty', '$price')");
        }
    } else {
        // Insert order details into the orders table
        mysqli_query($con, "INSERT INTO orders (user_id, name, email, mobile, address, city, total_price, shipping, order_status, date) 
                        VALUES ('$user_id', '$name', '$email', '$mobile', '$address', '$city', '$total_price', '$shipping_cost', '$order_status', '$date')");
        $order_id = mysqli_insert_id($con); // Get the order ID for the order
        // Insert each product in the cart into orders_detail
        foreach ($_SESSION['cart'] as $key => $val) {
            list($pid, $selected_format) = explode('_', $key); // Split product ID and format
            $price = $val['price'];
            $qty = $val['qty'];

            // Insert each product format into the orders_detail table
            mysqli_query($con, "INSERT INTO orders_detail (order_id, product_id, format, qty, price) 
                            VALUES ('$order_id', '$pid', '$selected_format', '$qty', '$price')");
        }
    }


    $order_id = mysqli_insert_id($con); // Get the order ID for the order

    // Clear the cart after the order is placed
    unset($_SESSION['cart']);

    // Redirect to Thank You page with order ID
    echo "<script>window.location.href='thankyou.php?order_id=$order_id&pn=$mobile'</script>";
}

// Fetch cities from the database
$cities_result = mysqli_query($con, "SELECT `id`, `cities` FROM `cities` ORDER BY `cities` ASC");
$cities = [];
while ($row = mysqli_fetch_assoc($cities_result)) {
    $cities[] = $row;
}
?>

<section class="flex justify-center py-10">
    <div class="w-full md:w-11/12 p-5 shadow-lg flex flex-col-reverse md:flex-row">
        <div class="w-full md:w-7/12 py-10 px-0 sm:px-10 lg:px-40">
            <h2 class="text-3xl font-bold">Delivery:</h2>
            <p class="text-xs text-gray-600 mt-2">All fields are requrired to be filled correctly.</p>
            <form method="POST" class="mt-5 flex flex-col gap-8">

                <?php if (!$user_id) { ?>
                    <div class="flex flex-col">
                        <label for="">Name:<span class="text-red-600 font-bold">*</span></label>
                        <input type="text" name="name" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2" required>
                    </div>
                <?php } ?>

                <div class="flex flex-col">
                    <label for="">Email:<span class="text-red-600 font-bold">*</span></label>
                    <input type="text" name="email" value="<?= $data['email'] ?>"
                        class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2" required>
                </div>
                <div class="flex flex-col">
                    <label for="mobile">Phone Number:<span class="text-red-600 font-bold">*</span></label>
                    <input type="tel" name="mobile" value="<?= $data['mobile'] ?>"
                        placeholder="Phone Number (11 Digits)"
                        class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2"
                        required pattern="\d{11}" title="Phone number must contain 11 digits">
                </div>
                <div class="flex flex-col">
                    <label for="city" class="flex ">
                        City:<span class="text-red-600 font-bold">*</span></label>
                    <select name="city"
                        class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2 font-normal"
                        required>
                        <option value="" selected disabled>Select a City</option>
                        <?php foreach ($cities as $city) { ?>
                            <option value="<?= $city['cities'] ?>"
                                <?= ($city['cities'] == $data['city']) ? 'selected' : '' ?>>
                                <?= $city['cities'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>


                <div class="flex flex-col">
                    <label for="">Address:<span class="text-red-600 font-bold">*</span></label>
                    <input type="text" name="address" value="<?= $data['address'] ?>"
                        class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2" required>
                </div>


                <div class="flex flex-col mt-4 border-y py-5">
                    <label class="text-lg font-semibold">Select Payment Method:<span class="text-red-600 font-bold">*</span></label>
                    <div class="flex flex-col gap-4 mt-2">

                        <?php
                        $formats = ['Cash On Delivery (COD)', 'Credit/Debit Card', 'Bank Deposit'];
                        foreach ($formats as $format) {
                        ?>
                            <div class="flex items-center gap-2">
                                <input type="radio" name="format" id="<?= $format ?>" value="<?= $format ?>" class="hidden"
                                    required>
                                <label for="<?= $format ?>"
                                    class="cursor-pointer p-2 w-full rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-200">
                                    <?= $format ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <style>
                    input[type="radio"]:checked+label {
                        background-color: #F59E0B;
                        color: white;
                        border-color: #F59E0B;
                    }
                </style>

                <input type="submit" name="submit" value="Place Order"
                    class="bg-black hover:bg-slate-900 text-white p-5 rounded-md font-bold hover:cursor-pointer"></input>
            </form>
        </div>

        <div class="w-full md:w-5/12 px-5 md:px-10 md:border-l border-slate-400">
            <!-- Products -->
            <div class="w-full">
                <?php
                if (isset($_SESSION['cart'])) {
                    $cart_total = 0;
                    foreach ($_SESSION['cart'] as $key => $val) {
                        // Extract product ID and format from the key
                        list($pid, $format) = explode('_', $key);

                        $productArr = get_product($con, '', '', $pid); // Fetch product by ID
                        $image = $productArr[0]['image'];
                        $pname = $productArr[0]['name'];
                        $qty = $val['qty'];
                        $price = $val['price'];
                        $selected_format = $val['format'];

                        $cart_total += $price * $qty;
                ?>
                        <!-- Card -->
                        <div class="flex justify-between p-2 w-full border-b flex-wrap">
                            <div class="flex">
                                <div class="relative px-2 w-[70px] h-[70px]">
                                    <img src="./image/<?= $image ?>" class="w-[70px] h-[70px]" alt="Product Image">
                                    <p
                                        class="rounded-full bg-red-700 absolute -top-2 -right-2 text-sm px-2 py-1 text-white font-bold">
                                        <?= $qty ?></p>
                                </div>
                                <div class="self-center ml-2">
                                    <p class="self-center text-wrap"><?= $pname ?></p>
                                    <p class="self-center text-sm text-slate-600">Format: <?= $selected_format ?></p>
                                </div>
                            </div>
                            <div class="self-center text-wrap">
                                <p>Rs.<?= number_format($price * $qty, 2) ?></p>
                            </div>
                        </div>
                        <!-- Card End -->
                <?php
                    }
                }
                ?>
            </div>

            <!-- Total Area -->
            <div class="w-full mt-5">
                <div class="flex justify-between text-sm flex-wrap">
                    <p>Subtotal:</p>
                    <p>Rs.<?= number_format($cart_total, 2) ?></p>
                </div>
                <div class="flex justify-between mt-2 text-sm">
                    <p>Shipping:</p>
                    <p id="shippingCost">Rs. 0.00</p> <!-- Default shipping cost set to 0 -->
                </div>
                <div class="flex justify-center md:justify-between mt-4 border-t p-5 text-lg ">
                    <p class="font-bold">Total:</p>
                    <p class="font-bold" id="totalPrice">Rs.<?= number_format($cart_total, 2) ?></p>
                    <!-- Default total -->
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const citySelect = document.querySelector('select[name="city"]');
        const shippingDisplay = document.querySelector('#shippingCost');
        const totalDisplay = document.querySelector('#totalPrice');

        // Default values
        let subtotal = parseFloat("<?= $cart_total ?>");
        let initialShippingCost = 0; // Default shipping cost

        // Display initial total
        totalDisplay.innerText = `Rs. ${subtotal.toFixed(2)}`;

        citySelect.addEventListener('change', function() {
            const selectedCity = this.value;

            // Make AJAX request to calculate shipping and total
            fetch('calculate_shipping.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        city: selectedCity,
                        subtotal: subtotal
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Update the shipping cost and total price in the UI
                    shippingDisplay.innerText = `Rs. ${data.shipping}`;
                    totalDisplay.innerText = `Rs. ${data.total}`;
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>



<?php
include 'footer.php';
?>