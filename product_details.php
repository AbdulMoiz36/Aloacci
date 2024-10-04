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
$brief = htmlspecialchars($get_product[0]['breif']);
$product_formats = array_map('htmlspecialchars', array_column($get_product, 'format'));
$product_prices = array_map('htmlspecialchars', array_column($get_product, 'price'));
$reviewsql = mysqli_query($con,"SELECT COUNT(*) AS total_reviews FROM reviews WHERE product_id = '$product_id';");
$total_reviews = mysqli_fetch_array($reviewsql);
?>

<section class="w-full">
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
                    class="border-2 border-slate-200 max-h-[850px] mx-auto">
            </div>
        </div>

        <div class="w-full md:w-1/2 flex flex-col justify-center md:justify-start p-10 gap-6">
            <div>
                <h1 class="font-bold text-3xl"><?= $product_name ?></h1>
                <p><?= $total_reviews['total_reviews'] ?> Reviews</p>
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
                <div id="format-container" class="flex gap-3 flex-wrap">
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
                    <a href="login.php">
                        <div class="border-2 border-black text-lg font-semibold rounded-full text-center mb-2 p-3 w-full">Add To Cart</div>
                    </a>
                </div>
            <?php else: ?>
                <button id="addToCartBtn" class="border-2 border-black text-lg font-semibold rounded-full mb-2 p-3"
                    onclick="addToCart('<?= $get_product[0]['id'] ?>')">Add To Cart</button>
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

                function buyNow(productId) {
                    const selectedFormat = document.querySelector('#format-container .bg-gray-200'); // Get the selected format
                    const quantity = document.getElementById('qty').value; // Get the quantity
                    if (selectedFormat) {
                        const format = selectedFormat.innerText.split(' - ')[0]; // Get the format text (remove price)
                        const price = selectedFormat.dataset.price; // Get the price of the selected format

                        // Call manage_cart and then immediately redirect
                        manage_cart(productId, 'add', quantity, format, price);

                        // Redirect to checkout
                        window.location.href = "checkout.php";
                    }
                }
            </script>

            <!-- Buy It Now Button -->
            <?php if (!isset($_SESSION['USER_LOGIN'])): ?>
                <div>
                    <a href="login.php">
                        <div class="w-full p-3 border-2 hover:cursor-pointer bg-gradient-to-bl text-center from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-xl transition-shadow ease-in-out duration-300 font-semibold rounded-full text-white">Buy It Now</div>
                    </a>
                </div>
            <?php else: ?>
                <div onclick="buyNow('<?= $get_product[0]['id'] ?>')" class="w-full p-3 text-center border-2 hover:cursor-pointer bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-xl transition-shadow ease-in-out duration-300 font-semibold rounded-full text-white">Buy It Now</div>
            <?php endif; ?>


            <!-- Tabs -->
            <div>
                <!-- Tab Buttons -->
                <div class="flex justify-evenly flex-wrap lg:flex-nowrap items-center">
                    <button class="tab-button font-bold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black" onclick="showTab(1)">Description</button>
                    <!-- <button class="tab-button font-bold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black" onclick="showTab(2)">Description</button> -->
                    <button class="tab-button font-bold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black" onclick="showTab(3)">Performance</button>
                    <button class="tab-button font-bold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black" onclick="showTab(4)">Shipping</button>
                </div>

                <!-- Tab Contents -->
                <div class="bg-white p-6 rounded-b-lg shadow-lg">
                    <div id="tab1" class="tab-content block">
                        <p><?=$brief?></p>
                    </div>

                    <!-- <div id="tab2" class="tab-content hidden">
                        <h2 class="text-xl font-semibold">Description Content</h2>
                        <p>This is the content for the Description tab.</p>
                    </div> -->

                    <div id="tab3" class="tab-content hidden">
                        <h2 class="text-xl font-semibold">Performance Content</h2>
                        <p>This is the content for the Performance tab.</p>
                    </div>

                    <div id="tab4" class="tab-content hidden">
                        <h2 class="text-xl font-semibold">Shipping Content</h2>
                        <p>This is the content for the Shipping tab.</p>
                    </div>
                </div>
            </div>

            <script>
                function showTab(tabIndex) {
                    // Hide all tab contents
                    const tabContents = document.querySelectorAll('.tab-content');
                    tabContents.forEach(tabContent => {
                        tabContent.classList.add('hidden'); // Add hidden class to hide content
                        tabContent.classList.remove('block'); // Remove block class to prevent display
                    });

                    // Show the selected tab content
                    const selectedTab = document.getElementById('tab' + tabIndex);
                    selectedTab.classList.remove('hidden'); // Remove hidden class to show content
                    selectedTab.classList.add('block'); // Add block class to ensure content is displayed

                    // Remove active class from all buttons
                    const tabButtons = document.querySelectorAll('.tab-button');
                    tabButtons.forEach(tabButton => {
                        tabButton.classList.remove('bg-slate-200', 'text-black');
                        tabButton.classList.add('bg-slate-900', 'text-white');
                    });

                    // Set active class to clicked button
                    tabButtons[tabIndex - 1].classList.remove('bg-slate-900', 'text-white');
                    tabButtons[tabIndex - 1].classList.add('bg-slate-200', 'text-black');
                }

                // Show the first tab by default on page load
                document.addEventListener('DOMContentLoaded', () => showTab(1));
            </script>

        </div>

        <!-- Reviews Section -->
        <div class="w-full mt-20">
            <h2 class="text-center text-4xl mb-4 font-bold">Reviews</h2>
            <div class="flex flex-col w-full">
                <?php
                // Query to fetch reviews for the given product_id
                $rsql = mysqli_query($con, "SELECT r.*,u.name FROM `reviews` as r JOIN `orders` as o ON r.order_id = o.id JOIN `users` as u ON o.user_id = u.id WHERE `product_id` = '$product_id'");

                // Check if there are reviews for the product
                if (mysqli_num_rows($rsql) > 0) {
                    // Loop through each review
                    while ($review = mysqli_fetch_assoc($rsql)) {
                       
                ?>
                        <div class="border-y border-slate-300 py-5">
                            <div class="flex flex-col md:flex-row justify-between gap-4">
                                <div class="flex flex-col gap-4 justify-center">
                                    <div class="flex justify-center md:justify-start gap-2">
                                        <p class="font-semibold text-xl"><?= htmlspecialchars($review['name']) ?></p>
                                        <p class="text-gray-500 mt-1 border-l pl-3"><?= htmlspecialchars($review['date']) ?></p> <!-- Assuming created_at holds the time info -->
                                    </div>
                                    <div class="flex justify-center md:justify-start">
                                        <?php
                                        // Assuming 'rating' is a numeric value (e.g., 4 means 4 stars)
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($i < $review['rating']) {
                                                echo '<i class="fa-solid fa-star text-yellow-500"></i>'; // filled star
                                            } else {
                                                echo '<i class="fa-solid fa-star text-gray-300"></i>'; // empty star
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="flex justify-center md:justify-start">
                                        <p><?= htmlspecialchars($review['comment']) ?></p>
                                    </div>
                                </div>
                                <?php if (!empty($review['image'])) { // Check if review has an image 
                                ?>
                                    <div class="flex justify-center md:justify-start">
                                        <img src="./<?= htmlspecialchars($review['image']) ?>" alt="Review Image" width="150px" class="cursor-pointer" onclick="openModal('<?= htmlspecialchars($review['image']) ?>')">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Modal for Image Zoom -->
                        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75  items-center justify-center hidden">
                            <span class="absolute top-5 right-5 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
                            <img id="modalImage" src="" alt="Zoomed Image" class="max-w-full max-h-full">
                        </div>
                        <script>
                            // Function to open the modal and display the clicked image
                            function openModal(imageSrc) {
                                const modal = document.getElementById('imageModal');
                                const modalImage = document.getElementById('modalImage');
                                modalImage.src = './' + imageSrc; // Set the modal image source
                                modal.classList.remove('hidden'); // Show the modal
                                modal.classList.add('flex'); // Show the modal
                            }

                            // Function to close the modal
                            function closeModal() {
                                const modal = document.getElementById('imageModal');
                                modal.classList.add('hidden'); // Hide the modal
                            }
                        </script>
                <?php
                    }
                } else {
                    // Message if no reviews are found
                    echo '<div><p class="text-center border-t py-10">No reviews found for this product.</p></div>';
                }
                ?>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>