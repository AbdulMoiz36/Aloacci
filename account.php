<?php
include "header.php";
// User must login first to access this page.//
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
} else {
    echo "<script>window.location.href='index.php'</script>";
    die();
}
$user_id = $_SESSION['USER_ID'];
$sql = mysqli_query($con, "SELECT `name`,`email`,`mobile`,`address`,`city` FROM `users` WHERE `id` = '$user_id'");
$user = mysqli_fetch_assoc($sql);
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
                            <tr class="border-t">
                                <td class="py-2 px-4 border text-center">1</td>
                                <td class="py-2 px-4 border text-center">11-3-24</td>
                                <td class="py-2 px-4 border text-center">Rs.5000</td>
                                <td class="py-2 px-4 border text-center">Pending</td>
                                <td class="py-2 px-4 border text-center">
                                    <a href="order_details.php" class="text-amber-600 hover:text-blue-800">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="w-4/12 pt-5 md:pt-0 md:p-5 border-l-2 border-slate-200">
            <h1 class="text-2xl font-bold underline mb-2">Account Details</h1>
            <p class="font-semibold mb-2"><?= $user['name'] ?></p>
            <p class="font-semibold mb-2"><?= $user['email'] ?></p>
            <p class="font-semibold mb-2"><?= $user['mobile'] ?></p>
            <p class="text-gray-700 mb-2 text-wrap"><?= $user['address'] ?>,<?= $user['city'] ?></p>
            <a href="edit_address.php"><button class="p-2 rounded-md text-white font-semibold bg-amber-500 mt-4">Edit Address</button></a>
        </div>
    </div>
    </div>
</section>


<?php
include "footer.php";
?>