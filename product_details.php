<?php
include 'header.php';
$product_id = mysqli_real_escape_string($con, $_GET['id']);

if ($product_id > 0) {
    $get_product = get_product($con, '', '', $product_id);
} else {
    echo "<script>window.location.href='index.php'</script>";
}

// Escape product data for output
$product_image = htmlspecialchars($get_product[0]['image']);
$product_image2 = htmlspecialchars($get_product[0]['image2']);
$product_name = htmlspecialchars($get_product[0]['name']);
$product_price = htmlspecialchars($get_product[0]['price']);
$product_formats = array_map('htmlspecialchars', array_column($get_product, 'format'));
$product_prices = array_map('htmlspecialchars', array_column($get_product, 'price'));
?>

<section class="container">
    <div class="flex flex-wrap p-2 md:p-10">
        <div class="w-100 md:w-1/2 flex gap-2">
            <!-- Sidebar Thumbnails (only displayed if there is more than one image) -->
            <?php if (!empty($product_image2)): ?>
                <div class="w-1/6 space-y-2">
                    <?php if (!empty($product_image)): ?>
                        <img src="./image/<?= $product_image ?>" alt="Thumbnail 1"
                            class="cursor-pointer border-2 border-slate-200" onclick="changeImage(this.src)">
                    <?php endif; ?>
                    <?php if (!empty($product_image2)): ?>
                        <img src="./image/<?= $product_image2 ?>" alt="Thumbnail 2"
                            class="cursor-pointer border-2 border-slate-200" onclick="changeImage(this.src)">
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Main Image -->
            <div class="<?= empty($product_image2) ? 'w-full' : 'w-5/6' ?>">
                <img id="mainImage" src="./image/<?= $product_image ?>" alt="Selected Product Image"
                    class="border-2 border-slate-200 max-h-[850px]">
            </div>
        </div>

        <div class="w-full md:w-1/2 flex flex-col justify-center md:justify-start p-10 gap-6">
            <div>
                <h1 class="font-bold text-3xl"><?= $product_name ?></h1>
                <p>12 Reviews</p>
            </div>

            <?php
            $productSoldQtyByProductId = productSoldQtyByProductId($con, $get_product[0]['id']);
            $cart_show = 'yes';
            $stock = ($get_product[0]['qty'] > $productSoldQtyByProductId) ? 'In Stock' : 'Not in Stock';
            if ($stock === 'Not in Stock') $cart_show = '';
            ?>

            <!-- Product Formats and Prices -->
            <div class="mt-4">
                <p class="font-semibold">Select Format:</p>
                <div id="format-container" class="flex flex-col">
                    <?php foreach ($product_formats as $index => $format): ?>
                        <div class="format-option border-2 border-black p-2 cursor-pointer my-2 <?= $index === 0 ? 'bg-gray-200' : '' ?> w-fit"
                            data-price="<?= $product_prices[$index] ?>">
                            <?= $format ?> - Rs. <?= $product_prices[$index] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p id="product-price" class="font-semibold text-lg mt-2">Price: Rs. <?= $product_prices[0] ?></p>
            </div>

            <div class="products--meta">
                <p>
                    <span>Availability:</span>
                    <span class="<?= $cart_show ? '' : 'text-red-600' ?> mb-4"><?= $stock ?></span>
                </p>
            </div>

            <!-- Quantity Selector -->
            <div>
                <p class="font-semibold">Quantity:</p>
                <form method="post">
                    <div class="flex items-center space-x-2">
                        <span class="qty-minus hover:cursor-pointer" onclick="changeQty(-1)"><i class="fa fa-minus"
                                aria-hidden="true"></i></span>
                        <input id="qty" name="quantity" type="number" min="1" value="1"
                            class="w-16 text-center border border-gray-300 rounded-md py-1" />
                        <span class="qty-plus hover:cursor-pointer " onclick="changeQty(1)"><i class="fa fa-plus"
                                aria-hidden="true"></i></span>
                    </div>

                    <script>
                        function changeQty(change) {
                            var qtyInput = document.getElementById('qty');
                            var newValue = parseInt(qtyInput.value) + change;
                            qtyInput.value = newValue > 0 ? newValue : 1; // Prevent negative or zero quantities
                        }
                    </script>
            </div>

            <script>
                // Handle format selection and price update
                document.querySelectorAll('.format-option').forEach(option => {
                    option.addEventListener('click', function() {
                        document.querySelectorAll('.format-option').forEach(opt => opt.classList.remove(
                            'bg-gray-200'));
                        this.classList.add('bg-gray-200');
                        const price = this.dataset.price;
                        document.getElementById('product-price').innerText = `Price: Rs. ${price}`;
                    });
                });

                function addToCart(productId) {
                    const selectedFormat = document.querySelector(
                        '#format-container .bg-gray-200'); // Get the selected format
                    const quantity = document.getElementById('qty').value; // Get the quantity
                    if (selectedFormat) {
                        const format = selectedFormat.innerText.split(' - ')[0]; // Get the format text (remove price)
                        const price = selectedFormat.dataset.price; // Get the price of the selected format
                        // Call manage_cart with the current product ID, selected format, and quantity
                        manage_cart(productId, 'add', quantity, format, price); // Pass the quantity and format
                    } else {
                        alert("Please select a format before adding to cart.");
                    }
                }
            </script>

            <!-- Add to Cart Button -->
            <?php if (!isset($_SESSION['USER_LOGIN'])): ?>
                <div>
                    <a href="login.php" class="border-2 border-black text-lg font-semibold rounded-full mb-2"
                        style="padding:15px 250px;">Add To Cart</a>
                </div>
            <?php else: ?>
                <button id="addToCartBtn" class="border-2 border-black text-lg font-semibold rounded-full mb-2"
                    style="padding:15px 250px;" onclick="addToCart('<?= $get_product[0]['id'] ?>')">Add To Cart</button>
            <?php endif; ?>

            </form>

            <script>
    function addToCart(productId) {
        const selectedFormat = document.querySelector('#format-container .bg-gray-200'); // Get the selected format
        const quantity = document.getElementById('qty').value; // Get the quantity
        if (selectedFormat) {
            const format = selectedFormat.innerText.split(' - ')[0]; // Get the format text (remove price)
            const price = selectedFormat.dataset.price; // Get the price of the selected format
            // Call manage_cart with the current product ID, selected format, and quantity
            manage_cart(productId, 'add', quantity, format, price); // Pass the quantity and format
        }
    }
</script>

            <!-- Buy It Now Button -->
            <div>
            <button class="w-full p-3 border-2 border-amber-600 text-lg font-semibold shadow-sm hover:shadow-lg transition-shadow ease-in-out duration-300 rounded-full bg-yellow-500 text-white">Buy It Now</button>
            </div>  

            <!-- Tabs -->
            <div>
                <div class="flex justify-evenly flex-wrap lg:flex-nowrap align-middle">
                    <?php
                    $tabs = ['Brief', 'Description', 'Performance', 'Shipping', 'Unboxing Video'];
                    foreach ($tabs as $index => $tab) {
                        $activeClass = $index === 0 ? 'bg-slate-900' : 'bg-slate-900';
                        echo "<button class='tab-button font-bold text-white $activeClass p-3 w-full hover:bg-slate-200 hover:text-black' onclick='showTab(\"tab" . ($index + 1) . "\")'>$tab</button>";
                    }
                    ?>
                </div>

                <div class="bg-white p-6 rounded-b-lg shadow-lg">
                    <?php foreach ($tabs as $index => $tab): ?>
                        <div id="tab<?= $index + 1 ?>" class="tab-content <?= $index === 0 ? 'active' : '' ?>">
                            <h2 class="text-xl font-semibold">Tab <?= $index + 1 ?> Content</h2>
                            <p>This is the content for Tab <?= $index + 1 ?>.</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="w-full mt-20">
            <h2 class="text-center text-4xl mb-4 font-bold">Reviews</h2>
            <div class="flex flex-col">
                <div class="border-y border-slate-300 py-5">
                    <div class="flex flex-col gap-4">
                        <div class="flex gap-2">
                            <p class="font-semibold text-xl">User Name</p>
                            <p class="text-gray-500">1 Year Ago</p>
                        </div>
                        <div>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consequuntur facilis
                                nemo? Iure, dolorum molestias. Aperiam iusto nam necessitatibus, dolorum voluptas sed
                                vel consectetur possimus nulla! Unde odit nobis omnis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>