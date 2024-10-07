<?php
include 'header.php';
// User must login first to access this page.//
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
} else {
    echo "<script>window.location.href='index.php'</script>";
    die();
}

if (!isset($_SERVER['HTTP_REFERER'])) {
    // echo("Access Denied");
    echo "<script>window.location.href='shop.php'</script>";
    exit;
  }

$cart_total = 0;
?>

<section class="px-2 py-5 md:px-32 md:py-10 w-full">
    <h1 class="text-4xl font-bold text-center">Cart</h1>
    <div class="flex flex-col md:flex-row mt-10 gap-2">
        <div class="w-full md:w-4/6">
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
            <div class="flex gap-5 border-b border-slate-200 pb-3 p-10">
                <div class="w-1/6"><img src="./image/<?= $image ?>" class="rounded-md" alt=""></div>
                <div class="w-5/6 flex flex-col justify-evenly">
                    <p class="font-bold text-lg"><?= $pname ?></p>
                    <p><span class="font-semibold">Format:</span> <?= $selected_format ?></p>
                    <!-- Quantity Selector -->
                    <div style="margin-bottom:20px">
                        <p class="font-semibold">Quantity:</p>
                        <div class="flex items-center space-x-2">
                            <span class="qty-minus" onclick="changeQty('<?= $key ?>', -1)"><i class="fa fa-minus"
                                    aria-hidden="true"></i></span>
                            <input id="qty_<?= $key ?>" name="quantity" type="number" min="1" value="<?= $qty ?>"
                                class="w-16 text-center border border-gray-300 rounded-md py-1"
                                onchange="updateCartTotal('<?= $key ?>')" />
                            <span class="qty-plus" onclick="changeQty('<?= $key ?>', 1)"><i class="fa fa-plus"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <a href="javascript:void(0)"
                            onclick="manage_cart('<?php echo $pid ?>', 'remove', 1, '<?php echo $selected_format ?>', '<?php echo $price ?>')"
                            class="font-semibold underline cursor-pointer">Remove</a>

                        <p class="font-semibold text-lg">Rs. <?= $price ?></p>
                    </div>
                </div>
            </div>
            <?php
                }
                
            }
            ?>
        </div>
        <div class="w-full md:w-2/6">
            <div class="bg-gray-100 p-10">
                <div class="flex justify-around text-wrap">
                    <p class="font-semibold text-xl">Subtotal:</p>
                    <p id="cart-total" class="font-semibold text-xl">Rs. <?= $cart_total ?></p>
                </div>
                <div class="mt-7">
                    <a href="checkout.php"><button
                            class="w-full p-2 border-2 hover:cursor-pointer bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-lg transition-shadow ease-in-out duration-300 font-semibold rounded-full text-white">Checkout</button></a>
                </div>
                <div class="mt-7">
                    <p class="text-center text-sm">Taxes and Shipping calculated at checkout.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function changeQty(productId, change) {
        var qtyInput = document.getElementById('qty_' + productId);
        var newValue = parseInt(qtyInput.value) + change;
        qtyInput.value = newValue > 0 ? newValue : 1; // Prevent negative or zero quantities
        updateCartTotal(productId); // Update cart total when quantity changes
    }

    function updateCartTotal(productId) {
    var qtyInput = document.getElementById('qty_' + productId);
    var quantity = parseInt(qtyInput.value);
    var price = <?= json_encode(array_column($_SESSION['cart'], 'price')) ?>; // Get prices from session data
    var pricePerUnit = price[productId]; // Get price of current product
    var subtotalElement = document.getElementById('cart-total');

    // Calculate new total
    var newTotal = 0;
    <?php foreach ($_SESSION['cart'] as $key => $val): ?>
        newTotal += (parseInt(document.getElementById('qty_<?= $key ?>').value) * <?= $val['price'] ?>);
    <?php endforeach; ?>
    subtotalElement.innerText = 'Rs. ' + newTotal; // Update total display

    // Update the session on the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // Optional: check response for debugging
        }
    };
    xhr.send("productId=" + productId + "&quantity=" + quantity);
}

</script>

<?php
include 'footer.php';
?>