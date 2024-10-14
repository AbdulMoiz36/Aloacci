<?php
include 'header.php';
$product_id = mysqli_real_escape_string($con, $_GET['id']);

if ($product_id > 0) {
    $get_product = get_product($con, '', '', $product_id);
} else {
    echo "<script>window.location.href='index'</script>";
}

// Escape product data for output
$product_image = htmlspecialchars($get_product[0]['image']);
$product_image2 = htmlspecialchars($get_product[0]['image2']);
$product_image3 = htmlspecialchars($get_product[0]['image3']);
$product_name = htmlspecialchars($get_product[0]['name']);
$product_gender_id = htmlspecialchars($get_product[0]['gender_id']);
$product_genre_id = htmlspecialchars($get_product[0]['genre_id']);
$product_type_id = htmlspecialchars($get_product[0]['type_id']);
$product_season_id = htmlspecialchars($get_product[0]['season_id']);
$product_sillage_id = htmlspecialchars($get_product[0]['sillage_id']);
$product_lasting_id = htmlspecialchars($get_product[0]['lasting_id']);
$brief = htmlspecialchars($get_product[0]['breif']);
$product_formats = array_map('htmlspecialchars', array_column($get_product, 'format'));
$product_prices = array_map('htmlspecialchars', array_column($get_product, 'price'));
$product_quantities = array_column($get_product, 'qty'); // Fetch the quantity of each format
$reviewsql = mysqli_query($con, "SELECT COUNT(*) AS total_reviews FROM reviews WHERE product_id = '$product_id';");
$total_reviews = mysqli_fetch_array($reviewsql);
$performance_sql = mysqli_query($con, "SELECT gen.gender,ge.genre,l.lasting,s.season,si.sillage,t.type FROM `product`as p JOIN gender as gen ON gen.id = p.gender_id JOIN genre as ge ON ge.id = p.genre_id JOIN lasting as l ON l.id = p.lasting_id JOIN season as s ON s.id = p.sillage_id JOIN sillage as si ON si.id = p.sillage_id JOIN `type` as t On t.id = p.type_id  WHERE p.id = '$product_id'");
$performance = mysqli_fetch_array($performance_sql);

// Fetch the quantity for each format from product_format and subtract the sold quantity
$product_quantities = [];
foreach ($get_product as $product) {
    $format = $product['format']; // Assuming format exists in the product data

    // Query to get the total ordered quantity from order_details for the current format
    $order_qty_result = mysqli_query($con, "SELECT SUM(qty) AS total_ordered_qty FROM orders_detail WHERE product_id = '$product_id' AND format = '$format'");
    $order_qty_row = mysqli_fetch_assoc($order_qty_result);
    $total_ordered_qty = $order_qty_row['total_ordered_qty'] ?? 0; // If no orders, default to 0

    // Subtract total ordered quantity from available stock in product_format
    $available_qty = $product['qty'] - $total_ordered_qty;
    $product_quantities[] = max(0, $available_qty); // Ensure we don't have negative quantities
}
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
                    <?php if (!empty($product_image3)): ?>
                        <img src="./image/<?= $product_image3 ?>" alt="Thumbnail 2"
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

        <div class="w-full md:w-1/2 flex flex-col justify-center md:justify-start p-2 md:p-10 gap-6">
            <div>
                <h1 class="font-bold text-3xl"><?= $product_name ?></h1>
                <p><?= $total_reviews['total_reviews'] ?> Reviews</p>
            </div>

            <!-- Product Formats and Prices -->
            <div class="mt-4">
                <p class="font-semibold">Select Format:</p>
                <div id="format-container" class="flex gap-3 flex-wrap">
                    <?php
                    $defaultSelected = false; // Flag to track if a default format is selected
                    foreach ($product_formats as $index => $format):
                        $isAvailable = $product_quantities[$index] > 0;
                    ?>
                        <div class="format-option border-2 p-2 cursor-pointer my-2 <?= !$defaultSelected && $isAvailable ? 'bg-gray-200' : '' ?> w-fit
                            <?= $isAvailable ? 'border-black' : 'border-gray-400 text-gray-400 cursor-not-allowed' ?>"
                            data-price="<?= $product_prices[$index] ?>" data-qty="<?= $product_quantities[$index] ?>"
                            <?= $isAvailable ? '' : 'data-disabled="true"' ?>>
                            <?= $format ?>
                        </div>
                    <?php
                        if ($isAvailable && !$defaultSelected) {
                            $defaultSelected = true; // Mark the first available format as selected
                        }
                    endforeach;
                    ?>
                </div>
                <p id="product-price" class="font-semibold text-lg mt-2">Price: Rs. <?= $product_prices[0] ?></p>
            </div>

            <div class="products--meta">
                <p>
                    <span>Availability:</span>
                    <span id="availability" class="<?= $product_quantities[0] > 0 ? '' : 'text-red-600' ?> mb-4"><?= $product_quantities[0] > 0 ? 'In Stock' : 'Not in Stock' ?></span>
                </p>
            </div>

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
                </form>

                <script>
                    function changeQty(change) {
                        var qtyInput = document.getElementById('qty');
                        var selectedFormat = document.querySelector('#format-container .bg-gray-200');
                        var availableQty = selectedFormat ? parseInt(selectedFormat.dataset.qty) : 1;
                        var newValue = parseInt(qtyInput.value) + change;

                        // Check if the new value exceeds available stock
                        if (newValue > availableQty) {
                            alert("You cannot select more than the available stock. Available stock: " + availableQty);
                            qtyInput.value = availableQty; // Set to max available quantity
                        } else {
                            qtyInput.value = Math.max(1, newValue); // Prevent negative or zero quantities
                        }
                    }

                    // Ensure that manual changes in the quantity field also respect the stock limit
                    document.getElementById('qty').addEventListener('input', function() {
                        var selectedFormat = document.querySelector('#format-container .bg-gray-200');
                        var availableQty = selectedFormat ? parseInt(selectedFormat.dataset.qty) : 1;

                        // Check if the manually entered value exceeds available stock
                        if (parseInt(this.value) > availableQty) {
                            alert("You cannot select more than the available stock. Available stock: " + availableQty);
                            this.value = availableQty; // Set to max available quantity
                        } else if (this.value < 1 || isNaN(this.value)) {
                            this.value = 1; // Prevent less than 1 or invalid input
                        }
                    });

                    // Handle format selection and price/availability update
                    document.querySelectorAll('.format-option').forEach(option => {
                        if (option.dataset.disabled === 'true') {
                            // Skip disabled formats
                            return;
                        }

                        option.addEventListener('click', function() {
                            // Reset background for all options
                            document.querySelectorAll('.format-option').forEach(opt => opt.classList.remove('bg-gray-200'));
                            this.classList.add('bg-gray-200');

                            // Update price
                            const price = this.dataset.price;
                            document.getElementById('product-price').innerText = `Price: Rs. ${price}`;

                            // Update availability
                            const qty = this.dataset.qty;
                            const availability = document.getElementById('availability');
                            availability.innerText = qty > 0 ? 'In Stock' : 'Not in Stock';
                            availability.classList.toggle('text-red-600', qty <= 0); // Add red color if out of stock

                            // Update quantity field max based on selected format's available quantity
                            var qtyInput = document.getElementById('qty');
                            qtyInput.value = Math.min(qtyInput.value, qty); // Ensure current quantity doesn't exceed available
                        });
                    });

                    // Automatically select the first available format on page load
                    window.onload = function() {
                        const defaultOption = document.querySelector('.format-option.bg-gray-200');
                        if (defaultOption) {
                            defaultOption.click(); // Simulate a click on the default selected format
                        }
                    };
                </script>
            </div>


            <!-- Add to Cart Button -->
            <?php if (!isset($_SESSION['USER_LOGIN'])): ?>
                <div>
                    <a href="login">
                        <div class="border-2 border-black text-lg font-semibold rounded-full text-center mb-2 p-3 w-full">Add To Cart</div>
                    </a>
                </div>
            <?php else: ?>
                <button id="addToCartBtn" class="border-2 border-black text-lg font-semibold rounded-full mb-2 p-3"
                    onclick="addToCart('<?= $get_product[0]['id'] ?>')">Add To Cart</button>
            <?php endif; ?>

            </form>

            <!-- Buy It Now Button -->
            <?php if (!isset($_SESSION['USER_LOGIN'])): ?>
                <div>
                    <a href="login">
                        <div class="w-full p-3 border-2 hover:cursor-pointer bg-gradient-to-bl text-center from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-xl transition-shadow ease-in-out duration-300 font-semibold rounded-full text-white">Buy It Now</div>
                    </a>
                </div>
            <?php else: ?>
                <div onclick="addToCartAndCheckout(<?= $product_id ?>)" class="w-full p-3 text-center border-2 hover:cursor-pointer bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-xl transition-shadow ease-in-out duration-300 font-semibold rounded-full text-white">Buy It Now</div>
            <?php endif; ?>

            <script>
                function addToCart(productId) {
                    const selectedFormat = document.querySelector('#format-container .bg-gray-200'); // Get the selected format
                    const quantity = document.getElementById('qty').value; // Get the quantity
                    if (selectedFormat) {
                        const format = selectedFormat.innerText.split(' - ')[0]; // Get the format text (remove price)
                        const price = selectedFormat.dataset.price; // Get the price of the selected format
                        const qty = selectedFormat.dataset.qty; // Get the available quantity of the selected format

                        if (parseInt(quantity) > parseInt(qty)) {
                            alert("Selected quantity exceeds available stock.");
                            return;
                        }

                        // Call manage_cart with the current product ID, selected format, and quantity
                        manage_cart(productId, 'add', quantity, format, price); // Pass the quantity and format
                    } else {
                        alert("Please select a format before adding to cart.");
                    }
                }

                function addToCartAndCheckout(productId) {
                    const selectedFormat = document.querySelector('#format-container .bg-gray-200'); // Get the selected format
                    const quantity = document.getElementById('qty').value; // Get the quantity

                    if (selectedFormat) {
                        const format = selectedFormat.innerText.split(' - ')[0]; // Get the format text (remove price)
                        const price = selectedFormat.dataset.price; // Get the price of the selected format

                        // Use AJAX to call manage_cart without reloading the page
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'manage_cart', true); // Adjust this URL if needed
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                // Once the item is added to the cart, redirect to checkout
                                window.location.href = 'checkout';
                            }
                        };

                        // Send the cart data (adjust these parameters as needed)
                        xhr.send(`pid=${productId}&type=add&qty=${quantity}&format=${format}&price=${price}`);
                    }
                }
            </script>


            <!-- Tabs -->
            <div>
                <!-- Tab Buttons -->
                <div class="flex justify-evenly flex-wrap lg:flex-nowrap items-center">
                    <button class="tab-button font-bold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black" onclick="showTab(1)">Description</button>
                    <button class="tab-button font-bold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black" onclick="showTab(2)">Performance</button>
                    <button class="tab-button font-bold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black" onclick="showTab(3)">Shipping</button>
                </div>

                <!-- Tab Contents -->
                <div class="bg-white p-6 rounded-b-lg shadow-lg">
                    <div id="tab1" class="tab-content block">
                        <p><?= $brief ?></p>
                    </div>

                    <div id="tab2" class="tab-content hidden flex flex-col gap-4">
                        <p class="font-semibold text-black"><span class="font-semibold text-amber-600">Sillage:</span> <?=$performance['sillage']?></p>
                        <p class="font-semibold text-black"><span class="font-semibold text-amber-600">Lasting:</span> <?=$performance['lasting']?>hrs</p>
                        <p class="font-semibold text-black"><span class="font-semibold text-amber-600">Gender:</span> <?=$performance['gender']?></p>
                        <p class="font-semibold text-black"><span class="font-semibold text-amber-600">Genre:</span> <?=$performance['genre']?></p>
                        <p class="font-semibold text-black"><span class="font-semibold text-amber-600">Type:</span> <?=$performance['type']?></p>
                        <p class="font-semibold text-black"><span class="font-semibold text-amber-600">Season:</span> <?=$performance['season']?></p>
                    </div>

                    <div id="tab3" class="tab-content hidden">
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

        <!-- Review Section -->
        <div class="w-full mt-20">
            <h2 class="text-center text-4xl mb-4 font-bold">Reviews</h2>
            <div class="flex flex-col w-full">
                <?php
                // Query to fetch reviews for the given product_id
                $rsql = mysqli_query($con, "SELECT r.*, u.name FROM `reviews` as r 
                    JOIN `orders` as o ON r.order_id = o.id 
                    JOIN `users` as u ON o.user_id = u.id 
                    WHERE `product_id` = '$product_id'");

                // Store all reviews in an array
                $reviews = [];
                while ($review = mysqli_fetch_assoc($rsql)) {
                    $reviews[] = $review; // Store reviews in an array
                }

                // Set how many reviews to show at first
                $reviewsPerPage = 5;
                $totalReviews = count($reviews);
                $currentReviews = array_slice($reviews, 0, $reviewsPerPage); // Get the first set of reviews
                $showMoreButton = $totalReviews > $reviewsPerPage; // Check if more reviews exist
                ?>

                <!-- Display reviews -->
                <div id="reviewsContainer">
                    <?php if ($totalReviews > 0): ?>
                        <?php foreach ($currentReviews as $review): ?>
                            <?php
                            // Split the image string by comma to get multiple image paths
                            $images = explode(',', $review['image']);
                            $imageCount = count($images); // Get number of images
                            ?>
                            <div class="border-y border-slate-300 py-5">
                                <div class="flex flex-col md:flex-row justify-between gap-4">
                                    <div class="flex flex-col gap-4 justify-center">
                                        <div class="flex justify-center md:justify-start gap-2">
                                            <p class="font-semibold text-xl"><?= htmlspecialchars($review['name']) ?></p>
                                            <p class="text-gray-500 mt-1 border-l pl-3"><?= htmlspecialchars($review['date']) ?></p>
                                        </div>
                                        <div class="flex justify-center md:justify-start">
                                            <?php
                                            // Display star rating
                                            for ($i = 0; $i < 5; $i++) {
                                                if ($i < $review['rating']) {
                                                    echo '<i class="fa-solid fa-star text-yellow-500"></i>';
                                                } else {
                                                    echo '<i class="fa-solid fa-star text-gray-300"></i>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="flex justify-center md:justify-start">
                                            <p><?= htmlspecialchars($review['comment']) ?></p>
                                        </div>
                                    </div>

                                    <?php if (!empty($review['image'])): ?>
                                        <!-- Image Slider -->
                                        <div class="flex flex-col justify-center md:justify-start w-full md:w-[400px]">
                                            <div class="relative">
                                                <!-- Use data-slider-id instead of id -->
                                                <div class="slider flex gap-2 overflow-x-scroll hide-scrollbar <?= $imageCount <= 2 ? 'justify-start md:justify-end' : 'justify-start'; ?>" data-slider-id="slider<?= $review['order_id'] ?>">
                                                    <?php foreach ($images as $image): ?>
                                                        <div class="flex-shrink-0 z-0">
                                                            <img src="./image/<?= htmlspecialchars(trim($image)) ?>" alt="Review Image" class="cursor-pointer w-48 h-48 object-cover" onclick="openModal('<?= htmlspecialchars(trim($image)) ?>')">
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>

                                                <?php if ($imageCount > 1): ?>
                                                    <!-- Show navigation buttons only if there are multiple images -->
                                                    <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black text-white p-2" onclick="scrollLeftBtn(this)">‹</button>
                                                    <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black text-white p-2" onclick="scrollRight(this)">›</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                </div>
                <!-- Show More button -->
                <?php if ($showMoreButton): ?>
                    <div class="text-center py-5" id="showMoreBtndiv">
                        <button id="showMoreBtn" class="bg-amber-500 text-white px-4 py-2 rounded" onclick="loadMoreReviews()">Show More</button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div>
                    <p class="text-center border-t py-10">No reviews found for this product.</p>
                </div>
            <?php endif; ?>
            </div>
        </div>

        <!-- Modal for Image Zoom -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 items-center justify-center hidden z-50">
            <span class="absolute top-5 right-5 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
            <img id="modalImage" src="" alt="Zoomed Image" class="w-auto max-h-full">
        </div>
        <script>
            // Function to open the modal and display the clicked image
            function openModal(imageSrc) {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                modalImage.src = './image/' + imageSrc; // Set the modal image source
                modal.classList.remove('hidden'); // Show the modal
                modal.classList.add('flex'); // Show the modal
            }

            // Function to close the modal
            function closeModal() {
                const modal = document.getElementById('imageModal');
                modal.classList.add('hidden'); // Hide the modal
            }

            // Function to scroll slider left
            function scrollLeftBtn(btn) {
                // Find the slider container inside the same div as the button
                const slider = btn.closest('.relative').querySelector('[data-slider-id]');
                slider.scrollBy({
                    left: -300,
                    behavior: 'smooth'
                });
            }

            // Function to scroll slider right
            function scrollRight(btn) {
                // Find the slider container inside the same div as the button
                const slider = btn.closest('.relative').querySelector('[data-slider-id]');
                slider.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            }

            let currentReviewIndex = 5; // Start loading from the 6th review
            let currentDiv = 1; // Initialize outside to persist across multiple clicks

            function loadMoreReviews() {
                const reviewsContainer = document.getElementById('reviewsContainer');
                const allReviews = <?= json_encode($reviews) ?>; // Encode the reviews array in PHP to JavaScript

                // Get the next set of reviews
                const nextReviews = allReviews.slice(currentReviewIndex, currentReviewIndex + 5);
                currentReviewIndex += 5; // Update the index for the next load

                // Create a temporary HTML string for new reviews
                let newReviewsHtml = '';
                nextReviews.forEach(review => {
                    currentDiv++; // Increment for each new review block
                    newReviewsHtml += `
            <div class="border-y border-slate-300 py-5" id="reviews${currentDiv}">
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <div class="flex flex-col gap-4 justify-center">
                        <div class="flex justify-center md:justify-start gap-2">
                            <p class="font-semibold text-xl">${review.name}</p>
                            <p class="text-gray-500 mt-1 border-l pl-3">${review.date}</p>
                        </div>
                        <div class="flex justify-center md:justify-start">
                            ${'<i class="fa-solid fa-star text-yellow-500"></i>'.repeat(review.rating) + '<i class="fa-solid fa-star text-gray-300"></i>'.repeat(5 - review.rating)}
                        </div>
                        <div class="flex justify-center md:justify-start">
                            <p>${review.comment}</p>
                        </div>
                    </div>
                    ${review.image ? `
                        <div class="flex flex-col justify-center md:justify-start w-full md:w-[400px]">
                            <div class="relative">
                                <div class="slider flex gap-2 overflow-x-scroll hide-scrollbar ${review.image.split(',').length <= 2 ? 'justify-end' : 'justify-start'}">
                                    ${review.image.split(',').map(image => `
                                        <div class="flex-shrink-0 z-0">
                                            <img src="./image/${image.trim()}" alt="Review Image" class="cursor-pointer w-48 h-48 object-cover " onclick="openModal('${image.trim()}')">
                                        </div>
                                    `).join('')}
                                </div>
                                <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black text-white p-2" onclick="scrollLeftBtn(this)">‹</button>
                                <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black text-white p-2" onclick="scrollRight(this)">›</button>
                            </div>
                        </div>` : ''}
                </div>
            </div>
        `;
                });

                // Insert the new reviews at the top of the container
                reviewsContainer.insertAdjacentHTML('beforeend', newReviewsHtml);

                // Scroll to the top of the newly added reviews
                const newReviewDiv = document.getElementById(`reviews${currentDiv}`);
                newReviewDiv.scrollIntoView({
                    behavior: 'smooth'
                });

                // Hide the button if no more reviews are left to load
                if (currentReviewIndex >= allReviews.length) {
                    document.getElementById('showMoreBtndiv').style.display = 'none';
                }
            }
        </script>



    </div>
</section>
<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
        /* Hide scrollbar in webkit browsers */
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .single-image {
        overflow: hidden;
        /* Hide scroll for single-image sliders */
    }
</style>

<?php include 'footer.php'; ?>