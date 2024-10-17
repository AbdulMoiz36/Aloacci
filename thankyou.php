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
?>

<section class="flex justify-center py-20">
    <div class="w-full md:w-4/6 shadow-xl px-8 py-20">
        <h1 class="font-bold text-4xl text-center">
            Thank You! <br> For Shopping From
            <span class="bg-gradient-to-bl from-yellow-400 via-yellow-400 to-amber-600 bg-clip-text text-transparent font-bold">Aloacci</span>.
        </h1>
        <p class="text-slate-600 text-center text-lg mt-14">
            Your order has been placed. Check your account profile for further details.
        </p>
        
        <?php if ($order_id) { ?>
            <p class="text-center text-lg mt-6">
                Your Order ID: 
                <a href="order_details?id=<?= $order_id ?>" class="text-blue-500 hover:underline">
                    #<?= $order_id ?>
                </a>
            </p>
            <p class="text-red-600 text-center text-lg mt-6">
                Please keep the ID safe.
            </p>
            <?php } ?>
    </div>
</section>

<?php
include 'footer.php';
?>
