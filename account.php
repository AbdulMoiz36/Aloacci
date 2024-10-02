<?php
include "header.php";
// User must login first to access this page.
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
} else {
    echo "<script>window.location.href='index.php'</script>";
    die();
}

$user_id = $_SESSION['USER_ID'];
$sql = mysqli_query($con, "SELECT `name`,`email`,`mobile`,`address`,`city` FROM `users` WHERE `id` = '$user_id'");
$user = mysqli_fetch_assoc($sql);

// Fetch all orders related to the user with the order status
$osql = mysqli_query($con, "SELECT o.total_price, o.id, o.date, os.name as order_status FROM `orders` as o JOIN `order_status` as os on o.order_status = os.id WHERE `user_id` = '$user_id'");
?>

<section class="md:p-10 flex justify-center align-middle">
    <div class="shadow-xl p-5 md:p-10 md:w-11/12 w-full flex flex-col">
        <div class="flex justify-between w-full md:mb-3">
            <h2 class="text-3xl font-bold">My Account</h2>
            <a href="./logout.php">
                <p class="underline cursor-pointer font-semibold">Log out</p>
            </a>
        </div>
        <div class="flex flex-col-reverse md:flex-row">
            <div class="w-full md:w-8/12 pt-5 md:pt-0 md:p-5">
                <h1 class="text-2xl font-bold mb-5">Order History</h1>

                <!-- Responsive table wrapper -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border-collapse border">
                        <thead class="bg-amber-500 text-white">
                            <tr>
                                <th class="py-2 px-4 text-center border ">Order ID</th>
                                <th class="py-2 px-4 text-center border">Date</th>
                                <th class="py-2 px-4 text-center border">Price</th>
                                <th class="py-2 px-4 text-center border">Status</th>
                                <th class="py-2 px-4 text-center border">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through all orders and display them in the table
                            while ($order = mysqli_fetch_assoc($osql)) {
                                // Format the date to day-month-year
                                $formatted_date = date("d-m-Y", strtotime($order['date']));

                                // Define background color for status
                                $status_class = '';
                                switch (strtolower($order['order_status'])) {
                                    case 'pending':
                                        $status_class = 'bg-yellow-500 text-white';
                                        break;
                                    case 'processing':
                                        $status_class = 'bg-blue-500 text-white';
                                        break;
                                    case 'shipped':
                                        $status_class = 'bg-purple-500 text-white';
                                        break;
                                    case 'cancelled':
                                        $status_class = 'bg-red-500 text-white';
                                        break;
                                    case 'complete':
                                        $status_class = 'bg-green-500 text-white';
                                        break;
                                }

                                echo "<tr class='border-t'>";
                                echo "<td class='py-2 px-4 border text-center'>{$order['id']}</td>";
                                echo "<td class='py-2 px-4 border text-center'>{$formatted_date}</td>";
                                echo "<td class='py-2 px-4 border text-center'>Rs.{$order['total_price']}</td>";
                                echo "<td class='py-2 px-4 border text-center {$status_class}'>{$order['order_status']}</td>";
                                echo "<td class='py-2 px-4 border text-center'>
                                        <a href='order_details.php?id={$order['id']}' class='text-amber-600 hover:text-blue-800'>
                                            <i class='fa-regular fa-eye'></i>
                                        </a>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full md:w-4/12 pt-5 md:pt-0 md:p-5 border-l-2 border-slate-200">
                <h1 class="text-2xl font-bold underline mb-2">Account Details</h1>
                <p class=" mb-2"><?= $user['name'] ?></p>
                <p class=" mb-2"><?= $user['email'] ?></p>
                <p class=" mb-2"><?= $user['mobile'] ?></p>
                <p class="text-gray-700 mb-2 text-wrap"><?= $user['address'] ?>, <?= $user['city'] ?></p>
                <a href="edit_address.php"><button class="p-2 rounded-md text-white font-semibold bg-amber-500 mt-4">Edit Address</button></a>
            </div>
        </div>
    </div>
</section>

<?php
include "footer.php";
?>
