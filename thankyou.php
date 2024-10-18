<?php
include 'header.php';

if (!isset($_SERVER['HTTP_REFERER'])) {
    echo "<script>window.location.href='shop'</script>";
    exit;
}

// Get the order_id from the query string
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
if (!isset($order_id)) {
    echo "<script>window.location.href='index'</script>";
}
$phoneNumber = $_GET['pn'];
?>

<section class="flex justify-center py-20">
    <div class="w-full md:w-4/6 shadow-xl px-8 py-20 border">
        <h1 class="font-bold text-4xl text-center">
            Thank You! <br> For Shopping From
            <span class="bg-gradient-to-bl from-yellow-400 via-yellow-400 to-amber-600 bg-clip-text text-transparent font-bold">Aloacci</span>.
        </h1>
        


        <?php if ($order_id) { ?>
            <p class="text-center text-lg mt-14">
                Your Order ID:
                <a href="order_details?id=<?= $order_id ?>" class="text-blue-500 hover:underline font-bold">
                    #<?= $order_id ?>
                </a>
            </p>
            <?php
        if (isset($_SESSION['USER_LOGIN'])) {
        ?>
            <p class="text-slate-600 text-center text-lg mt-6">
                Your order has been placed. Check your account profile for further details.
            </p>
        <?php
        }
        ?>
            <?php
        if (!isset($_SESSION['USER_LOGIN'])) {
        ?>
            <p class="text-center text-lg mt-6d">
            Your Phone Number: 
            <span class="text-blue-500 font-bold"><?= $phoneNumber ?></span>
            </p>
            <p class="text-center text-lg mt-6">
                Please ensure that you keep your <b class="text-red-600">Order ID</b> and <b class="text-red-600">Phone Number</b> secure, as they will be required to track your order
            </p>
        <?php } } ?>
    </div>
</section>

<?php
include 'footer.php';
?>