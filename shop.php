<?php
include 'header.php';
// Get the category or sub-category id from the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$sub_category_id = isset($_GET['sub_category_id']) ? $_GET['sub_category_id'] : '';
$price_filter = isset($_GET['price_filter']) ? $_GET['price_filter'] : '';
$search_str = isset($_GET['search']) ? get_safe_value($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : ''; // Get the sort parameter

// Function to build the URL with query parameters
function build_url($base_url, $params)
{
    $query_string = http_build_query(array_filter($params));
    return $base_url . '?' . $query_string;
}

// Initialize parameters for the URL
$params = [
    'category_id' => $category_id,
    'sub_category_id' => $sub_category_id,
    'price_filter' => $price_filter,
    'search' => $search_str,
    'sort' => $sort // Include sort in the parameters
];

// Get the base URL
$base_url = $_SERVER['PHP_SELF'];

// Construct the URL based on the parameters
$current_url = build_url($base_url, $params);

// Fetch products based on filters and sorting
if ($search_str) {
    $get_product = get_product($con, '', '', '', $search_str, false, '', '', $sort); // Pass sort to the function
} elseif ($price_filter == 'less_1500') {
    $get_product = get_product($con, '', $category_id, '', '', false, $sub_category_id, 1500, $sort); // Pass sort to the function
} elseif ($sub_category_id) {
    $get_product = get_product($con, '', '', '', '', false, $sub_category_id, '', $sort); // Pass sort to the function
} elseif ($category_id) {
    $get_product = get_product($con, '', $category_id, '', '', false, '', '', $sort); // Pass sort to the function
} else {
    $get_product = get_product($con, '', '', '', '', '', '', '', $sort); // Pass sort to the function
}

// Fetch distinct genders using a JOIN between product and gender tables
$genderQuery = mysqli_query($con, "SELECT DISTINCT g.gender, g.id FROM gender g 
                                   JOIN product p ON g.id = p.gender_id 
                                   WHERE p.status = 1");
$genders = [];
while ($row = mysqli_fetch_assoc($genderQuery)) {
    $genders[] = $row;
}

// Fetch distinct genres using a JOIN between product and genre tables
$genreQuery = mysqli_query($con, "SELECT DISTINCT g.genre, g.id FROM genre g 
                                   JOIN product p ON g.id = p.genre_id 
                                   WHERE p.status = 1");
$genres = [];
while ($row = mysqli_fetch_assoc($genreQuery)) {
    $genres[] = $row;
}

// Fetch distinct types using a JOIN between product and type tables
$typeQuery = mysqli_query($con, "SELECT DISTINCT g.type, g.id FROM type g 
                                   JOIN product p ON g.id = p.type_id 
                                   WHERE p.status = 1");
$types = [];
while ($row = mysqli_fetch_assoc($typeQuery)) {
    $types[] = $row;
}

// Fetch distinct seasons using a JOIN between product and season tables
$seasonQuery = mysqli_query($con, "SELECT DISTINCT g.season, g.id FROM season g 
                                   JOIN product p ON g.id = p.season_id 
                                   WHERE p.status = 1");
$seasons = [];
while ($row = mysqli_fetch_assoc($seasonQuery)) {
    $seasons[] = $row;
}

// Fetch distinct sillages using a JOIN between product and sillage tables
$sillageQuery = mysqli_query($con, "SELECT DISTINCT g.sillage, g.id FROM sillage g 
                                   JOIN product p ON g.id = p.sillage_id 
                                   WHERE p.status = 1");
$sillages = [];
while ($row = mysqli_fetch_assoc($sillageQuery)) {
    $sillages[] = $row;
}

// Fetch distinct lastings using a JOIN between product and lasting tables
$lastingQuery = mysqli_query($con, "SELECT DISTINCT g.lasting, g.id FROM lasting g 
                                   JOIN product p ON g.id = p.lasting_id 
                                   WHERE p.status = 1");
$lastings = [];
while ($row = mysqli_fetch_assoc($lastingQuery)) {
    $lastings[] = $row;
}
?>

<div class="w-full p-10 ">
    <h1 class="font-bold text-4xl">Products</h1>
    <p><?= count(array_unique(array_column($get_product, 'id'))) ?> Products</p>
</div>

<!-- Sticky filter and sort section -->
<div
    class="w-full py-3 flex flex-wrap justify-around md:justify-end px-2 md:px-10 border-b-2 border-slate-200 sticky md:static top-0 z-10 bg-white">
    <p class="md:hidden cursor-pointer" id="filter-btn"><span class="mr-2"><i
                class="fa-solid fa-sliders"></i></span>Filter</p>
    <div>
        <label for=""><span class="mr-2"><i class="fa-solid fa-arrow-down-wide-short"></i></span>Sort By: </label>
        <select class="w-auto pr-2" id="sort-dropdown" onchange="applySort(this.value)">
            <option value="" <?= ($sort == '') ? 'selected' : '' ?>>Select</option>
            <option value="a_to_z" <?= ($sort == 'a_to_z') ? 'selected' : '' ?>>A to Z</option>
            <option value="z_to_a" <?= ($sort == 'z_to_a') ? 'selected' : '' ?>>Z to A</option>
            <option value="price_low_high" <?= ($sort == 'price_low_high') ? 'selected' : '' ?>>Price: Low to High
            </option>
            <option value="price_high_low" <?= ($sort == 'price_high_low') ? 'selected' : '' ?>>Price: High to Low
            </option>
            <option value="newest" <?= ($sort == 'newest') ? 'selected' : '' ?>>Newest</option>
        </select>

    </div>
</div>

<!-- Main section with filter and products -->
<section class="flex">
    <!-- Filters div -->
    <div class="w-3/4 md:w-1/5 fixed md:relative border-r-2 border-slate-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out bg-white h-screen md:h-fit overflow-y-auto overflow-hidden  top-0 z-20 p-5"
        id="filters">
        <button id="close-filter" class="md:hidden cursor-pointer mb-5 border-b-2 border-slate-400">
            <span class="mr-2"><i class="fa-solid fa-xmark"></i></span>Close
        </button>
        <div id="selected-values" class="flex flex-wrap gap-2">
            <!-- Selected values will be added here dynamically -->
        </div>

        <!-- Gender filter section -->
        <div class="mt-4">
            <div class="relative">
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-gender-btn"
                    data-icon="dropdown-gender-icon">
                    Genders
                    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-gender-icon"></i></span>
                </p>
                <div id="dropdown-gender-content" class="mt-2 text-lg">
                    <?php foreach ($genders as $gender): ?>
                        <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                            <input type="checkbox" value="<?= htmlspecialchars($gender['id']) ?>"
                                class="gender-checkbox custom-checkbox mr-2" data-name="<?= $gender['gender'] ?>"
                                onclick="filterProducts()">
                            <?= htmlspecialchars($gender['gender']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Genre filter section -->
        <div class="mt-4">
            <div class="relative">
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-genre-btn">
                    Genre
                    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-icon"></i></span>
                </p>
                <div id="dropdown-genre-content" class="mt-2 text-lg">
                    <?php foreach ($genres as $genre): ?>
                        <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                            <input type="checkbox" value="<?= htmlspecialchars($genre['id']) ?>"
                                class="genre-checkbox custom-checkbox mr-2" data-name="<?= $genre['genre'] ?>"
                                onclick="filterProducts()">
                            <?= htmlspecialchars($genre['genre']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Type filter section -->
        <div class="mt-4">
            <div class="relative">
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-type-btn">
                    Type
                    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-icon"></i></span>
                </p>
                <div id="dropdown-type-content" class="mt-2 text-lg">
                    <?php foreach ($types as $type): ?>
                        <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                            <input type="checkbox" value="<?= htmlspecialchars($type['id']) ?>"
                                class="type-checkbox custom-checkbox mr-2" onclick="filterProducts()">
                            <?= htmlspecialchars($type['type']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Season filter section -->
        <div class="mt-4">
            <div class="relative">
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-season-btn">
                    Season
                    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-icon"></i></span>
                </p>
                <div id="dropdown-season-content" class="mt-2 text-lg">
                    <?php foreach ($seasons as $season): ?>
                        <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                            <input type="checkbox" value="<?= htmlspecialchars($season['id']) ?>"
                                class="season-checkbox custom-checkbox mr-2" onclick="filterProducts()">
                            <?= htmlspecialchars($season['season']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Sillage filter section -->
        <div class="mt-4">
            <div class="relative">
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-sillage-btn">
                    Sillage
                    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-icon"></i></span>
                </p>
                <div id="dropdown-sillage-content" class="mt-2 text-lg">
                    <?php foreach ($sillages as $sillage): ?>
                        <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                            <input type="checkbox" value="<?= htmlspecialchars($sillage['id']) ?>"
                                class="sillage-checkbox custom-checkbox mr-2" onclick="filterProducts()">
                            <?= htmlspecialchars($sillage['sillage']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Lasting filter section -->
        <div class="mt-4">
            <div class="relative">
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-lasting-btn">
                    Lasting
                    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-icon"></i></span>
                </p>
                <div id="dropdown-lasting-content" class="mt-2 text-lg">
                    <?php foreach ($lastings as $lasting): ?>
                        <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                            <input type="checkbox" value="<?= htmlspecialchars($lasting['id']) ?>"
                                class="lasting-checkbox custom-checkbox mr-2" onclick="filterProducts()">
                            <?= htmlspecialchars($lasting['lasting']) ?> hrs
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Products section -->
    <div id="products-container" class="w-full p-3 flex flex-wrap justify-center gap-5">
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
            <div class="product-card w-96 md:w-72 h-[40rem] md:h-[30rem] flex gap-2 flex-col relative group shadow"
                data-gender-id="<?= $list['gender_id'] ?>" data-genre-id="<?= $list['genre_id'] ?>"
                data-type-id="<?= $list['type_id'] ?>" data-season-id="<?= $list['season_id'] ?>"
                data-sillage-id="<?= $list['sillage_id'] ?>" data-lasting-id="<?= $list['lasting_id'] ?>">
                <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
                    data-product-id="<?= $list['id'] ?>" data-product-name="<?= $list['name'] ?>"
                    data-product-formats="<?= htmlspecialchars(json_encode($product_formats)) ?>">
                    <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                </div>

                <!-- Product image wrapper -->
                <div class="relative h-[70%] w-full">
                    <a href="product_details.php?id=<?= $list['id'] ?>" class="product-link w-full">
                        <img src="./image/<?= $list['image'] ?>" alt="<?= $list['name'] ?>"
                            class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <?php if ($list['image2'] != ''): ?>
                            <img src="./image/<?= $list['image2'] ?>" alt="<?= $list['name'] ?> Hover"
                                class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                        <?php else: ?>
                            <img src="./image/<?= $list['image'] ?>" alt="<?= $list['name'] ?> Hover"
                                class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Product details -->
                <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                    <a href="product_details.php?id=<?= $list['id'] ?>"
                        class="text-lg font-bold hover:underline"><?= htmlspecialchars($list['name']) ?></a>
                    <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                        <?= htmlspecialchars($list['description']) ?></p>
                    <p class="text-lg font-bold text-red-500">Rs. <?= htmlspecialchars($list['price']) ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<script>
    function filterProducts() {
        const selectedGenders = Array.from(document.querySelectorAll('.gender-checkbox:checked')).map(checkbox =>
            checkbox.value);
        const selectedGenres = Array.from(document.querySelectorAll('.genre-checkbox:checked')).map(checkbox =>
            checkbox.value);
        const selectedTypes = Array.from(document.querySelectorAll('.type-checkbox:checked')).map(checkbox =>
            checkbox.value);
        const selectedSeasons = Array.from(document.querySelectorAll('.season-checkbox:checked')).map(checkbox =>
            checkbox.value);
        const selectedSillages = Array.from(document.querySelectorAll('.sillage-checkbox:checked')).map(checkbox =>
            checkbox.value);
        const selectedLastings = Array.from(document.querySelectorAll('.lasting-checkbox:checked')).map(checkbox =>
            checkbox.value);
        // Update URL with selected filters, removing empty parameters
        const url = new URL(window.location.href);
        url.searchParams.delete('genders');
        url.searchParams.delete('genres');
        url.searchParams.delete('types');
        url.searchParams.delete('seasons');
        url.searchParams.delete('sillages');
        url.searchParams.delete('lastings');
        if (selectedGenders.length) {
            url.searchParams.set('genders', selectedGenders.join(','));
        }
        if (selectedGenres.length) {
            url.searchParams.set('genres', selectedGenres.join(','));
        }
        if (selectedTypes.length) {
            url.searchParams.set('types', selectedTypes.join(','));
        }
        if (selectedSeasons.length) {
            url.searchParams.set('seasons', selectedSeasons.join(','));
        }
        if (selectedSillages.length) {
            url.searchParams.set('sillages', selectedSillages.join(','));
        }
        if (selectedLastings.length) {
            url.searchParams.set('lastings', selectedLastings.join(','));
        }
        window.history.replaceState({}, '', url);
        const products = document.querySelectorAll('.product-card');
        products.forEach(product => {
            const genderId = product.getAttribute('data-gender-id');
            const genreId = product.getAttribute('data-genre-id');
            const typeId = product.getAttribute('data-type-id');
            const seasonId = product.getAttribute('data-season-id');
            const sillageId = product.getAttribute('data-sillage-id');
            const lastingId = product.getAttribute('data-lasting-id');
            const genderMatch = selectedGenders.length === 0 || selectedGenders.includes(genderId);
            const genreMatch = selectedGenres.length === 0 || selectedGenres.includes(genreId);
            const typeMatch = selectedTypes.length === 0 || selectedTypes.includes(typeId);
            const seasonMatch = selectedSeasons.length === 0 || selectedSeasons.includes(seasonId);
            const sillageMatch = selectedSillages.length === 0 || selectedSillages.includes(sillageId);
            const lastingMatch = selectedLastings.length === 0 || selectedLastings.includes(lastingId);
            if (genderMatch && genreMatch && typeMatch && seasonMatch && sillageMatch && lastingMatch) {
                // Instead of 'block', use 'flex' if you're using flexbox for layout
                product.style.display = 'flex'; // or 'grid' if you're using a CSS grid layout
            } else {
                product.style.display = 'none';
            }
        });
        const sortSelect = document.querySelector('select');
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
        });
        document.querySelector(`select option[value="${new URLSearchParams(window.location.search).get('sort')}"]`)
            .selected = true;
    }
    // Function to set checkbox states from URL parameters
    function setCheckboxStates() {
        const urlParams = new URLSearchParams(window.location.search);
        const selectedGenders = urlParams.get('genders') ? urlParams.get('genders').split(',') : [];
        const selectedGenres = urlParams.get('genres') ? urlParams.get('genres').split(',') : [];
        const selectedTypes = urlParams.get('types') ? urlParams.get('types').split(',') : [];
        const selectedSeasons = urlParams.get('seasons') ? urlParams.get('seasons').split(',') : [];
        const selectedSillages = urlParams.get('sillages') ? urlParams.get('sillages').split(',') : [];
        const selectedLastings = urlParams.get('lastings') ? urlParams.get('lastings').split(',') : [];
        document.querySelectorAll('.gender-checkbox').forEach(checkbox => {
            checkbox.checked = selectedGenders.includes(checkbox.value);
        });
        document.querySelectorAll('.genre-checkbox').forEach(checkbox => {
            checkbox.checked = selectedGenres.includes(checkbox.value);
        });
        document.querySelectorAll('.type-checkbox').forEach(checkbox => {
            checkbox.checked = selectedTypes.includes(checkbox.value);
        });
        document.querySelectorAll('.season-checkbox').forEach(checkbox => {
            checkbox.checked = selectedSeasons.includes(checkbox.value);
        });
        document.querySelectorAll('.sillage-checkbox').forEach(checkbox => {
            checkbox.checked = selectedSillages.includes(checkbox.value);
        });
        document.querySelectorAll('.lasting-checkbox').forEach(checkbox => {
            checkbox.checked = selectedLastings.includes(checkbox.value);
        });
        // Call filter function to filter products based on the loaded checkboxes
        filterProducts();
    }
    // Call setCheckboxStates on page load
    document.addEventListener('DOMContentLoaded', setCheckboxStates);

    function addToCartAndCheckout(productId) {
        const selectedFormat = document.querySelector('#format-container .bg-gray-200'); // Get the selected format
        const quantity = document.getElementById('qty').value; // Get the quantity

        if (selectedFormat) {
            const format = selectedFormat.innerText.split(' - ')[0]; // Get the format text (remove price)
            const price = selectedFormat.dataset.price; // Get the price of the selected format

            // Use AJAX to call manage_cart without reloading the page
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'manage_cart.php', true); // Adjust this URL if needed
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Once the item is added to the cart, redirect to checkout.php
                    window.location.href = 'checkout.php';
                }
            };

            // Send the cart data (adjust these parameters as needed)
            xhr.send(`pid=${productId}&type=add&qty=${quantity}&format=${format}&price=${price}`);
        }
    }
</script>

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

        <div id="buyNowBtn" onclick="addToCartAndCheckout()" class="w-full p-3 mt-4 text-center border-2 hover:cursor-pointer bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-xl transition-shadow ease-in-out duration-300 font-semibold rounded-full text-white">Buy It Now</div>

        <div id="closeModalBtn"
            class="absolute -top-2 -right-2 hover:cursor-pointer shadow-md hover:shadow-xl font-bold bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 text-white px-4 py-2 rounded-full hover:bg-red-600 focus:outline-none">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
</div>

<!-- Script for Modal Functionality -->
<script>
    // Script for Modal Functionality
    const openModalBtns = document.querySelectorAll('.openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('modal');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalProductPrice = document.getElementById('modal-product-price');
    let currentProductId = null; // Variable to store the current product ID
    // Function to close the modal
    function closeModal() {
        modal.classList.add('hidden');
        modalOverlay.classList.add('hidden');
    }
    // Event listener to open modal
    openModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const productName = btn.getAttribute('data-product-name');
            const productFormats = JSON.parse(btn.getAttribute('data-product-formats'));
            const productId = btn.getAttribute('data-product-id'); // Get the product ID

            // Populate modal
            document.getElementById('modal-product-name').innerText = productName;

            // Clear previous formats
            const formatContainer = document.getElementById('format-container');
            formatContainer.innerHTML = ''; // Clear previous formats

            productFormats.forEach((formatObj, index) => {
                const formatDiv = document.createElement('div');
                formatDiv.className = 'border-2 border-black p-2 cursor-pointer w-fit my-2';
                formatDiv.innerText = `${formatObj.format}`;
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

            // Set the current product ID and assign it to the "Buy It Now" button
            const buyNowBtn = document.getElementById('buyNowBtn'); // Adjust selector to your Buy It Now button
            buyNowBtn.setAttribute('onclick', `addToCartAndCheckout(${productId})`); // Set the correct product ID

            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // Event listener to close modal on button click
    closeModalBtn.addEventListener('click', closeModal);
    // Event listener to close modal when clicking outside the modal
    modalOverlay.addEventListener('click', closeModal);
    // Event listener to close modal with the 'Esc' key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal();
        }
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
</script>

<?php
include 'footer.php';
?>