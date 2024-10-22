<?php
include 'header.php';
if (!isset($_GET['id'])) {
    echo "<script>window.location.href='index'</script>";
}
$id = $_GET['id'];

// Query to fetch order details based on the order ID
$sql = mysqli_query($con, "SELECT o.*, s.name as order_status FROM `orders` as o JOIN order_status as s ON o.order_status = s.id WHERE o.id = '$id'");

// Fetch the result
$order = mysqli_fetch_array($sql);

// Check if the order exists
if (!$order) {
    // If no data is found, redirect to index
    echo "<script>window.location.href='index'</script>";
    exit; // Make sure to exit after the redirect to stop further execution
}

if($order['user_id'] != 0 || $order['user_id'] != ''){
    $uid = $order['user_id']; 
    $usql = mysqli_query($con,"SELECT `name` FROM `users` WHERE `id` = $uid");
    $user = mysqli_fetch_array($usql);
}

// Function to get the appropriate CSS class based on the status
function getStatusClass($status)
{
    switch (strtolower($status)) {
        case 'pending':
            return 'bg-yellow-50 text-yellow-600'; // Yellow for pending
        case 'processing':
            return 'bg-blue-50 text-blue-600'; // Blue for processing
        case 'shipped':
            return 'bg-indigo-50 text-indigo-600'; // Indigo for shipped
        case 'cancelled':
            return 'bg-red-50 text-red-600'; // Red for cancelled
        case 'complete':
            return 'bg-emerald-50 text-emerald-600'; // Green for complete
        default:
            return 'bg-gray-50 text-gray-600'; // Gray as default (unknown status)
    }
}
?>

<section class="py-24 relative">
    <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">
        <h2 class="font-manrope font-bold text-4xl leading-10 text-black text-center">
            Order Details
        </h2>
        <p class="mt-4 font-normal text-lg leading-8 text-gray-500 mb-11 text-center">Dear <?= $order['name'] == '' ? $user['name'] : $order['name'] ?>, Thank You for making a purchase.</p>
        <div class="main-box border border-gray-200 rounded-xl pt-6 max-w-xl max-lg:mx-auto lg:max-w-full bg-slate-50">
            <div
                class="flex flex-col lg:flex-row lg:items-center justify-between px-6 pb-6 border-b border-gray-200">
                <div class="data">
                    <p class="font-semibold text-base leading-7 text-black">Order Id: <span class="text-amber-600 font-medium">#<?= $id ?></span></p>
                    <p class="font-semibold text-base leading-7 text-black mt-4">Order Date : <span class="text-gray-500 font-medium"><?= $order['date'] ?></span></p>
                    <p class="font-semibold text-base leading-7 text-black mt-4">Order Status :
                    <span class="font-medium text-sm leading-6 whitespace-nowrap py-0.5 px-3 rounded-full lg:mt-3 <?= getStatusClass($order['order_status']) ?>">
                        <?= $order['order_status'] ?>
                    </span>
                    </p>
                </div>
                <div class="data mt-4 md:mt-0">
                    <p class="font-semibold text-base leading-7 text-black">Name: <span class="text-gray-500 font-medium"><?= $order['name'] == '' ? $user['name'] : $order['name'] ?></span></p>
                    <p class="font-semibold text-base leading-7 text-black mt-4">Email: <span class="text-gray-500 font-medium"><?= $order['email'] ?></span></p>
                    <p class="font-semibold text-base leading-7 text-black mt-4">Phone Number: <span class="text-gray-500 font-medium"><?= $order['mobile'] ?></span></p>
                </div>

            </div>
            <div class="w-full px-3 min-[400px]:px-6">

                <?php
                $order_details = mysqli_query($con, "SELECT od.*, p.image, p.name,g.gender FROM `orders_detail` as od JOIN `product` as p ON od.product_id = p.id JOIN gender as g ON p.gender_id = g.id WHERE od.order_id = '$id'");

                while ($order_d = mysqli_fetch_assoc($order_details)) {
                    // Extract values from the current row
                    $product_image = $order_d['image'];
                    $product_name = $order_d['name'];
                    $quantity = $order_d['qty'];
                    $price = $order_d['price'];
                    $format = $order_d['format'];
                ?>

                    <!-- Order Detail Structure -->
                    <div class="flex flex-col lg:flex-row items-center py-6 border-b border-gray-200 gap-6 w-full">
                        <div class="img-box max-lg:w-full">
                            <img src="./image/<?= $product_image ?>" alt="<?= $product_name ?> image"
                                class="aspect-square w-full lg:max-w-[140px] rounded-xl object-cover">
                        </div>
                        <div class="flex flex-row items-center w-full">
                            <div class="grid grid-cols-1 lg:grid-cols-2 w-full">
                                <div class="flex items-center">
                                    <div class="">
                                        <h2 class="font-semibold text-xl leading-8 text-black mb-3"><?= $product_name ?></h2>
                                        <p class="font-normal text-lg leading-8 text-gray-500 mb-3">
                                            <?= $order_d['gender'] ?></p>
                                        <div class="flex items-center">
                                            <p class="font-medium text-base leading-7 text-black pr-4 mr-4 border-r border-gray-200">
                                                Size: <span class="text-gray-500"><?= $format ?></span></p> <!-- Add size dynamically if needed -->
                                            <p class="font-medium text-base leading-7 text-black">Qty: <span class="text-gray-500"><?= $quantity ?></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row justify-start md:justify-end gap-5 md:gap-10">
                                    <div class="col-span-1 flex items-center max-lg:mt-3">
                                        <div class="flex gap-3 lg:block">
                                            <p class="font-medium text-sm leading-7 text-black">Price</p>
                                            <p class="lg:mt-4 font-medium text-sm leading-7 text-green-700">Rs.<?= $price ?></p>
                                        </div>
                                    </div>
                                    <div class="col-span-1 flex items-center max-lg:mt-3">
                                        <div class="flex gap-3 lg:block">
                                            <p class="font-medium text-sm leading-7 text-black">Subtotal</p>
                                            <p class="lg:mt-4 font-semibold text-sm leading-7 text-green-600">Rs.<?= $price * $quantity ?></p>
                                        </div>
                                    </div>
                                    
                                    <?php
                                    if ($order['user_id'] != 0) {
                                    ?>
                                        <div class="col-span-2 flex items-center max-lg:mt-3">
                                            <div class="flex gap-3 lg:block">
                                                <p class="font-medium text-sm leading-7 text-black">Write A Review</p>
                                                <a href="review?pid=<?= $order_d['product_id'] ?>&oid=<?= $id ?>&format=<?= $format ?>" class="font-medium text-sm leading-6 whitespace-nowrap py-1 px-3 rounded-full lg:mt-3 flex items-center justify-center">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>


                <?php
                } // End of while loop
                ?>

            </div>
            <div class="w-full border-t border-gray-200 px-6 flex flex-col lg:flex-row items-center justify-between ">
                <p class="font-semibold text-lg text-black py-6">Shipping:
                    <span class="text-amber-600">
                        <?= $order['shipping'] == 0 ? "Free" : "Rs." . $order['shipping'] ?>
                    </span>
                </p>
                <p class="font-semibold text-lg text-black py-6">Address: <span class="text-amber-600"><?= $order['address'] ?>, <?= $order['city'] ?></span></p>
                <div class="flex flex-col py-6">
                    <p class="font-semibold text-lg text-black ">Total Price: <span class="text-amber-600">Rs.<?= $order['total_price'] ?></span></p>
                    <p class="text-xs text-gray-400">*Including Shipping Charges</p>
                </div>

            </div>

        </div>
    </div>
</section>

<?php
include 'footer.php';
?>