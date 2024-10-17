<?php
include 'header.php';

// Ensure user is logged in
if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN'] == '') {
    echo "<script>window.location.href='index'</script>";
    die();
}

if (!isset($_SERVER['HTTP_REFERER'])) {
    // echo("Access Denied");
    echo "<script>window.location.href='shop'</script>";
    exit;
  }

$user_id = $_SESSION['USER_ID'];
$sql = mysqli_query($con, "SELECT `name`, `email`, `mobile`, `address`, `city` FROM `users` WHERE `id` = '$user_id'");
$data = mysqli_fetch_assoc($sql);

// Initialize cart total
$cart_total = 0;
$cart_empty = true;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart_empty = false;
    foreach ($_SESSION['cart'] as $key => $val) {
        // Split the $key into $pid and $format
        list($pid, $selected_format) = explode('_', $key);

        // Fetch product details using only $pid
        $productArr = get_product($con, '', '', $pid);
        $price = $val['price'];
        $qty = $val['qty'];
        $total_price = $price * $qty;
        $cart_total += $total_price; // Calculate total
    }
}

if (isset($_POST['submit'])) {
    $address = get_safe_value($con, $_POST['address']);
    $email = get_safe_value($con, $_POST['email']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $city = get_safe_value($con, $_POST['city']);
    $total_price = $cart_total; // Use the calculated total price
    $order_status = '1';
    $date = date('Y-m-d H:i:s'); // Proper date format

    // Insert order details into the orders table
    mysqli_query($con, "INSERT INTO orders (user_id, email, mobile, address, city, total_price, order_status, date) 
                        VALUES ('$user_id', '$email', '$mobile', '$address', '$city', '$total_price', '$order_status', '$date')");

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

    // Clear the cart after the order is placed
    unset($_SESSION['cart']);
    echo "<script>window.location.href='thankyou'</script>";
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
            <form method="POST" class="mt-5 flex flex-col gap-8">
                <div class="flex flex-col">
                    <label for="">Email:</label>
                    <input type="text" name="email" value="<?= $data['email'] ?>"
                        class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <div class="flex flex-col">
                    <label for="city" class="flex flex-col">
                        City:
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
                    </label>
                </div>
                <div class="flex flex-col">
                    <label for="">Address:</label>
                    <input type="text" name="address" value="<?= $data['address'] ?>"
                        class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2" required>
                </div>
                <div class="flex flex-col">
                    <label for="">Phone Number:</label>
                    <input type="text" name="mobile" value="<?= $data['mobile'] ?>"
                        class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <div class="flex flex-col mt-4 border-y py-5">
                    <label class="text-lg font-semibold">Select Payment Method:</label>
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
                    <p>FREE</p>
                </div>
                <div class="flex justify-center md:justify-between mt-4 border-t p-5 text-lg ">
                    <p class="font-bold">Total:</p>
                    <p class="font-bold">Rs.<?= number_format($cart_total, 2) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>