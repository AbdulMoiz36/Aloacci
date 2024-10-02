<?php
include 'header.php';
// Get the category or sub-category id from the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$sub_category_id = isset($_GET['sub_category_id']) ? $_GET['sub_category_id'] : '';
$price_filter = isset($_GET['price_filter']) ? $_GET['price_filter'] : '';

// Modify the product query to filter based on category, sub-category, or price filter
if ($price_filter == 'less_1500') {
    // Filter products where the price is less than 1500
    $get_product = get_product($con, '', $category_id, '', '', false, $sub_category_id, 1500);
} else if ($sub_category_id) {
    // Filter products by sub-category
    $get_product = get_product($con, '', '', '', '', false, $sub_category_id);
} else if ($category_id) {
    // Filter products by category
    $get_product = get_product($con, '', $category_id);
} else {
    // Get all products if no filters applied
    $get_product = get_product($con);
}

// Fetch distinct genders using a JOIN between product and gender tables
$genderQuery = mysqli_query($con, "SELECT DISTINCT g.gender, g.id FROM gender g 
                                   JOIN product p ON g.id = p.gender_id 
                                   WHERE p.status = 1");
$genders = [];
while ($row = mysqli_fetch_assoc($genderQuery)) {
    $genders[] = $row;
}

// Fetch distinct genders using a JOIN between product and genre tables
$genreQuery = mysqli_query($con, "SELECT DISTINCT g.genre, g.id FROM genre g 
                                   JOIN product p ON g.id = p.genre_id 
                                   WHERE p.status = 1");
$genres = [];
while ($row = mysqli_fetch_assoc($genreQuery)) {
    $genres[] = $row;
}
?>

<div class="w-full p-10 ">
    <h1 class="font-bold text-4xl">Products</h1>
    <p><?= count(array_unique(array_column($get_product, 'id'))) ?> Products</p>
</div>

<!-- Sticky filter and sort section -->
<div
    class="w-full py-3 flex justify-around md:justify-end px-2 md:px-10 border-b-2 border-slate-200 sticky md:static top-0 z-10 bg-white">
    <p class="md:hidden cursor-pointer" id="filter-btn"><span class="mr-2"><i
                class="fa-solid fa-sliders"></i></span>Filter</p>
    <div>
        <label for=""><span class="mr-2"><i class="fa-solid fa-arrow-down-wide-short"></i></span>Sort By: </label>
        <select>
            <option value="">One</option>
            <option value="">Two</option>
            <option value="">Three</option>
        </select>
    </div>
</div>

<!-- Main section with filter and products -->
<section class="flex">
    <!-- Filters div -->
    <div class="w-3/4 md:w-1/5 fixed md:relative border-r-2 border-slate-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out bg-white h-screen top-0 z-20 p-5"
        id="filters">
        <button id="close-filter" class="md:hidden cursor-pointer mb-5 border-b-2 border-slate-400"><span
                class="mr-2"><i class="fa-solid fa-xmark"></i></span>Close</button>
        <div id="selected-values" class="flex flex-wrap gap-2">
            <!-- Selected values will be added here dynamically -->
        </div>

        <!-- Gender filter section -->
        <div class="mt-4">
            <div class="relative">
                <!-- Dropdown trigger -->
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-gender-btn">
    Genders
    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-gender-icon"></i></span>
</p>
                <!-- Dropdown content -->
                <div id="dropdown-gender-content" class="mt-2 text-lg">
                    <?php
            foreach ($genders as $gender) {
                ?>
                    <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                        <input type="checkbox" value="<?= htmlspecialchars($gender['id']) ?>"
                            id="checkbox-<?= strtolower($gender['gender']) ?>" class="custom-checkbox mr-2"
                            onclick="updateSelectedValues()">
                        <?= htmlspecialchars($gender['gender']) ?>
                    </label>
                    <?php
            }
            ?>
                </div>
            </div>
        </div>

        <!-- genre filter section -->
        <div class="mt-4">
            <div class="relative">
                <!-- Dropdown trigger -->
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-genre-btn">
                    Genre
                    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-icon"></i></span>
                </p>
                <!-- Dropdown content -->
                <div id="dropdown-genre-content" class="mt-2 text-lg">
                    <?php
            foreach ($genres as $genre) {
                ?>
                    <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                        <input type="checkbox" value="<?= htmlspecialchars($genre['id']) ?>"
                            id="checkbox-<?= strtolower($genre['genre']) ?>" class="custom-checkbox mr-2"
                            onclick="updateSelectedValues()">
                        <?= htmlspecialchars($genre['genre']) ?>
                    </label>
                    <?php
            }
            ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Products section -->
    <div class="w-full p-3 flex flex-wrap justify-center gap-5">
        <?php
    $unique_products = [];
    foreach ($get_product as $list) {
        if (in_array($list['id'], $unique_products)) continue;
        $unique_products[] = $list['id'];

        $product_formats = []; // Get product formats
        foreach ($get_product as $p) {
            if ($p['id'] == $list['id']) {
                $product_formats[] = [
                    'format' => $p['format'],
                    'price' => $p['price']
                ];
            }
        }
    ?>
        <div class="w-96 md:w-72 h-[40rem] md:h-[30rem] flex gap-2 flex-col relative group shadow">
            <!-- Plus icon with hover effect -->
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
                data-product-id="<?= $list['id'] ?>" data-product-name="<?= $list['name'] ?>"
                data-product-formats="<?= htmlspecialchars(json_encode($product_formats)) ?>">
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=<?= $list['id'] ?>" class="product-link w-full">
                    <!-- Default image -->
                    <img src="./image/<?= $list['image'] ?>" alt="<?= $list['name'] ?>"
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <!-- Second image to show on hover -->
                    <?php if ($list['image2'] != '') { ?>
                    <img src="./image/<?= $list['image2'] ?>" alt="<?= $list['name'] ?> Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                    <?php } else { ?>
                    <img src="./image/<?= $list['image'] ?>" alt="<?= $list['name'] ?> Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                    <?php } ?>
                </a>
            </div>

    <!-- Product details -->
<div class="px-4 py-2 h-full flex flex-col justify-evenly">
    <a href="product_details.php?id=<?= $list['id'] ?>" class="product-link w-full">
        <p class="font-bold text-xl"><?= $list['name'] ?></p>
        <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2"><?= $list['description'] ?></p>
        <p class="text-red-600 font-extrabold text-xl">Rs. <?= $product_formats[0]['price'] ?></p>
    </a>
</div>

</div>

        <?php
        }
        ?>
    </div>
</section>

<!-- Modal Overlay -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 items-center justify-center hidden z-50">
    <div class="bg-white p-10 rounded-lg shadow-lg w-5/6 md:w-2/3 lg:w-1/3 relative">
        <h2 class="text-2xl font-bold mb-4" id="modal-product-name">Product Name</h2>
        <!-- Options -->
        <div id="modal-formats" class="mt-2">
            <p class="font-semibold">Formats:</p>
            <div id="format-container" class="flex gap-2">
                <!-- Formats will be inserted here dynamically -->
            </div>
        </div>
        <!-- Price -->
        <div class="mt-2">
            <p class="font-semibold">Price:</p>
            <p style="padding-bottom: 20px;" id="modal-product-price" class="text-xl font-semibold text-red-500">Rs.
                Price</p>
        </div>
        <!-- Quantity Selector -->
        <div style="margin-bottom:20px">
            <p class="font-semibold">Quantity:</p>
            <form method="post">
                <div class="flex items-center space-x-2">
                    <span class="qty-minus" onclick="changeQty(-1)"><i class="fa fa-minus"
                            aria-hidden="true"></i></span>
                    <input id="qty" name="quantity" type="number" min="1" value="1"
                        class="w-16 text-center border border-gray-300 rounded-md py-1" />
                    <span class="qty-plus" onclick="changeQty(1)"><i class="fa fa-plus" aria-hidden="true"></i></span>
                </div>

                <script>
                    function changeQty(change) {
                        var qtyInput = document.getElementById('qty');
                        var newValue = parseInt(qtyInput.value) + change;
                        qtyInput.value = newValue > 0 ? newValue : 1; // Prevent negative or zero quantities
                    }
                </script>
        </div>
        <!-- Inside the Modal -->
        <?php if (!isset($_SESSION['USER_LOGIN'])): ?>
        <a href="login.php">
            <div class="w-full p-3 border-2 text-center border-black text-lg font-semibold rounded-full text-black">Add
                To
                Cart</div>
        </a>
        <?php else: ?>
        <a href="javascript:void(0)">
            <div id="addToCartBtn"
                class="w-full p-3 border-2 text-center border-black text-lg font-semibold rounded-full text-black">Add
                To
                Cart</div>
        </a>
        <?php endif; ?>
        <a href="product_details.php?id=">
            <div style="margin-top: 20px;"
                class="w-full p-3 border-2 hover:cursor-pointer bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-lg transition-shadow ease-in-out duration-300 font-semibold rounded-full text-white text-center">
                Buy It
                Now</div>
        </a>
        <div id="closeModalBtn"
            class="absolute -top-2 -right-2 hover:cursor-pointer shadow-md hover:shadow-xl font-bold bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 text-white px-4 py-2 rounded-full hover:bg-red-600 focus:outline-none">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
</div>

<!-- Script for Modal Functionality -->
<script>
    const openModalBtns = document.querySelectorAll('.openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('modal');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalProductPrice = document.getElementById('modal-product-price');
    let currentProductId = null; // Variable to store the current product ID
    openModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const productName = btn.getAttribute('data-product-name');
            const productFormats = JSON.parse(btn.getAttribute('data-product-formats'));
            // Populate modal
            document.getElementById('modal-product-name').innerText = productName;
            // Clear previous formats
            const formatContainer = document.getElementById('format-container');
            formatContainer.innerHTML = ''; // Clear previous formats
            productFormats.forEach((formatObj, index) => {
                const formatDiv = document.createElement('div');
                formatDiv.className = 'border-2 border-black p-2 cursor-pointer w-fit my-2';
                formatDiv.innerText = `${formatObj.format}ml`;
                formatDiv.dataset.price = formatObj.price;
                // Select the first format by default
                if (index === 0) {
                    formatDiv.classList.add('bg-gray-200');
                    modalProductPrice.innerText = `Rs. ${formatObj.price}`;
                }
                // Add click event listener for selecting a format
                formatDiv.addEventListener('click', () => {
                    // Remove 'selected' class from all formats
                    document.querySelectorAll('#format-container div').forEach(div => {
                        div.classList.remove('bg-gray-200');
                    });
                    // Add 'selected' class to the clicked format
                    formatDiv.classList.add('bg-gray-200');
                    // Update price in modal
                    modalProductPrice.innerText = `Rs. ${formatDiv.dataset.price}`;
                });
                formatContainer.appendChild(formatDiv);
            });
            // Set the current product ID
            currentProductId = btn.getAttribute('data-product-id');
            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modalOverlay.classList.remove('hidden');
        });
    });
    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modalOverlay.classList.add('hidden');
    });
    modalOverlay.addEventListener('click', () => {
        modal.classList.add('hidden');
        modalOverlay.classList.add('hidden');
    });
    // Add to Cart button event listener
    document.getElementById('addToCartBtn').addEventListener('click', () => {
        const selectedFormat = document.querySelector('#format-container .bg-gray-200');
        const quantity = document.getElementById('qty').value; // Get the quantity from the input
        if (selectedFormat) {
            const format = selectedFormat.innerText; // Get the selected format text
            const price = selectedFormat.dataset.price; // Get the selected format price
            // Call manage_cart with the current product ID, selected format, and quantity
            manage_cart(currentProductId, 'add', quantity, format, price); // Pass the quantity and format
        }
    });
    // modal close with escape key
    document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        modal.classList.add('hidden');
        modalOverlay.classList.add('hidden');
    }
});

</script>

<?php
include 'footer.php';
?>