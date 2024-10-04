<?php
include 'header.php';

// Ensure user is logged in
if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN'] == '') {
    echo "<script>window.location.href='index.php'</script>";
    die();
}

$user_id = $_SESSION['USER_ID'];
$sql = mysqli_query($con, "SELECT `name`, `email`, `mobile`, `address`, `city` FROM `users` WHERE `id` = '$user_id'");
$data = mysqli_fetch_assoc($sql);

// Initialize cart total
$cart_total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $val) {
        $productArr = get_product($con, '', '', $key);
        $price = $val['price'];
        $qty = $val['qty'];
        $selected_format = $val['format'];
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
    $date = date('y-m-d h:m:s');

    mysqli_query($con, "INSERT INTO orders (user_id, email, mobile, address, city, total_price, order_status, date) VALUES ('$user_id', '$email', '$mobile', '$address', '$city', '$total_price', '$order_status', '$date')");

    $order_id = mysqli_insert_id($con);

    foreach ($_SESSION['cart'] as $key => $val) {
        $productArr = get_product($con, '', '', $key);
        $price = $val['price'];;
        $qty = $val['qty'];
        $selected_format = $val['format'];

        mysqli_query($con, "INSERT INTO orders_detail (order_id, product_id, format, qty, price) VALUES ('$order_id', '$key', '$selected_format', '$qty', '$price')");
    }

    unset($_SESSION['cart']);
    echo "<script>window.location.href='thankyou.php'</script>";
}
?>


<section class="flex justify-center py-10">
    <div class="w-full md:w-11/12 p-5 shadow-lg flex flex-col md:flex-row">
        <div class="w-full md:w-7/12 py-10 px-40">
            <h2 class="text-3xl font-bold">Delivery:</h2>
            <form method="POST" class="mt-5 flex flex-col gap-8">
                <div class="flex flex-col">
                    <label for="">Email:</label>
                    <input type="text" name="email" value="<?= $data['email'] ?>" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <div class="flex flex-col">
                    <label for="">City:</label>
                    <input type="text" name="city" value="<?= $data['city'] ?>" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2" required>
                </div>
                <div class="flex flex-col">
                    <label for="">Address:</label>
                    <input type="text" name="address" value="<?= $data['address'] ?>" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2" required>
                </div>
                <div class="flex flex-col">
                    <label for="">Phone Number:</label>
                    <input type="text" name="mobile" value="<?= $data['mobile'] ?>" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <input type="submit" name="submit" value="Place Order" class="bg-black hover:bg-slate-900 text-white p-5 rounded-md font-bold"></input>
            </form>
        </div>

        <div class="w-full md:w-5/12 px-5 md:px-10 md:border-l border-slate-400">
            <!-- Products -->
            <div class="w-full">
                <?php
                if (isset($_SESSION['cart'])) {
                    $cart_total = 0;
                    foreach ($_SESSION['cart'] as $key => $val) {
                        $productArr = get_product($con, '', '', $key);
                        $image = $productArr[0]['image'];
                        $pname = $productArr[0]['name'];
                        $qty = $val['qty'];
                        $price = $val['price']; // Get the price from the session
                        $selected_format = $val['format']; // Get the selected format
                        $total_price = $price * $qty;

                        // Calculate cart total
                        $cart_total += $total_price;
                ?>
                <!-- Card -->
                <div class="flex justify-between p-2 w-full border-b">
                    <div class="flex">
                        <div class="relative px-2 w-[70px] h-[70px]">
                            <img src="./image/<?= $image ?>" class="w-[70px] h-[70px]" alt="Product Image">
                            <p class="rounded-full bg-red-700 absolute -top-2 -right-2 text-sm px-2 py-1 text-white font-bold"><?= $qty ?></p>
                        </div>
                        <div class="self-center ml-2">
                            <p class="self-center text-wrap"><?= $pname ?></p>
                            <p class="self-center text-sm text-slate-600">Format: <?= $selected_format ?></p>
                        </div>
                    </div>
                    <div class="self-center text-wrap">
                        <p>Rs.<?= number_format($total_price, 2) ?></p>
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
                <div class="flex justify-between text-sm">
                    <p>Subtotal:</p>
                    <p>Rs.<?= number_format($cart_total, 2) ?></p>
                </div>
                <div class="flex justify-between mt-2 text-sm">
                    <p>Shipping:</p>
                    <p>FREE</p>
                </div>
                <div class="flex justify-between mt-4 border-t p-5 text-lg ">
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
