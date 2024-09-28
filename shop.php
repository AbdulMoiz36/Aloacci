<?php
include 'header.php';
// Get the selected sorting option
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';

// Define the sorting query
$sort_query = '';
if ($sort_by == 'name_asc') {
    $sort_query = "ORDER BY Name ASC";
} elseif ($sort_by == 'price_asc') {
    $sort_query = "ORDER BY Price ASC";
} elseif ($sort_by == 'price_desc') {
    $sort_query = "ORDER BY Price DESC";
} elseif ($sort_by == 'newest') {
    $sort_query = "ORDER BY Id DESC";
}

// Fetch categories
$sql = "SELECT * FROM categories";
$res = mysqli_query($con, $sql);
$cat_arr = array();
while ($row = mysqli_fetch_assoc($res)) {
    $cat_arr[] = $row;
}

function fetch_products_with_categories($con, $type = '', $limit = '', $cat_id = '', $sort_query = '')
{
    // Fetch product data
    $sql = "SELECT product.*, categories.Categories AS CategoryName 
            FROM product
            JOIN categories ON product.category_id = categories.Id
            WHERE product.status=1";

    if ($cat_id != '') {
        $sql .= " AND product.categories_id=$cat_id";
    }

    // Append the sorting query
    if ($sort_query != '') {
        $sql .= " " . $sort_query;
    }

    if ($limit != '') {
        $sql .= " LIMIT $limit";
    }

    $res = mysqli_query($con, $sql);
    $data = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    return $data;
}
// Fetch products with categories
$products = fetch_products_with_categories($con, '', '', '', $sort_query);

?>

<div class="w-full p-10 ">

    <h1 class="font-bold text-4xl">Products</h1>
    <p>12 Products</p>
</div>

<!-- Sticky filter and sort section -->
<div class="w-full py-3 flex justify-around md:justify-end px-2 md:px-10 border-b-2 border-slate-200 sticky top-1 z-10 bg-white">
    <p class="md:hidden cursor-pointer" id="filter-btn"><span class="mr-2"><i class="fa-solid fa-sliders"></i></span>Filter</p>
    <div>
        <label for=""><span class="mr-2"><i class="fa-solid fa-arrow-down-wide-short"></i></span>Sort By: </label>
        <Select>
            <option value="">One</option>
            <option value="">Two</option>
            <option value="">Three</option>
        </Select>
    </div>
</div>

<!-- Main section with filter and products -->
<section class="flex">
    <!-- Filters div -->
    <div class="w-3/4 md:w-1/5 fixed md:relative border-r-2 border-slate-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out bg-white h-screen top-0 z-20 p-5" id="filters">
        <button id="close-filter" class="md:hidden  cursor-pointer mb-5 border-b-2 border-slate-400"><span class="mr-2"><i class="fa-solid fa-xmark"></i></span>Close</button>
        <div id="selected-values" class="flex flex-wrap gap-2">
            <!-- Selected values will be added here dynamically -->
        </div>

        <div class="mt-4">
            <div class="relative">
                <!-- Dropdown trigger -->
                <p class="font-semibold cursor-pointer text-xl" id="dropdown-btn">
                    Genders
                    <span class="ml-2"><i class="fa-solid fa-angle-down" id="dropdown-icon"></i></span>
                </p>
                <!-- Dropdown content -->
                <div id="dropdown-content" class="mt-2 text-lg">
                    <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                        <input type="checkbox" value="Men" id="checkbox-men" class="custom-checkbox mr-2" onclick="updateSelectedValues()">
                        Men
                    </label>
                    <label class="flex items-center hover:bg-gray-200 p-2 cursor-pointer">
                        <input type="checkbox" value="Women" id="checkbox-women" class="custom-checkbox mr-2" onclick="updateSelectedValues()">
                        Women
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Products section -->
    <div class="w-full p-3 flex flex-wrap justify-center gap-5 ">
        <?php
        foreach ($products as $list) {
        ?>
                <div class="w-96 md:w-72 h-[40rem] md:h-[30rem] flex gap-2 flex-col relative group shadow">
                    <!-- Plus icon with hover effect -->
                    <div id="openModalBtn" class="z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                        <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                    </div>
                    
                    <!-- Product image wrapper -->
                    <div class="relative h-[70%] w-full">
                        <a href="product_details.php?id=<?= $list['id'] ?>" class="product-link w-full">
                        <!-- Default image -->
                        <img src="./image/<?= $list['image'] ?>" alt="Product 1" class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Second image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 2 Hover" class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                    </a>
                    </div>

                    <!-- Product details -->
                    <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                    <a href="product_details.php?id=<?= $list['id'] ?>" class="product-link w-full">

                        <p class="font-bold text-xl">Product Name</p>
                        <p class="text-gray-600">Description</p>
                        <p class="text-red-600 font-extrabold text-xl">Rs.2267</p>
                        </a>
                    </div>
                </div>
        <?php
        }
        ?>
    </div>
</section>

<!-- Modal Overlay -->

<!-- Modal -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>
<div id="modal" class="fixed inset-0 items-center justify-center hidden z-50">
    <div class="bg-white p-10 rounded-lg shadow-lg w-5/6 md:w-1/3 relative">
        <h2 class="text-2xl font-bold mb-4">Product Name</h2>
        <!-- Options -->
        <div class="mt-2">
                <p class="font-semibold">Format:</p>
                <div class="border-2 border-black p-2 cursor-pointer w-fit my-2">
                    <p>Perfume Spray (50ml)</p>
                </div>
                <div class="border-2 border-black p-2 cursor-pointer w-fit my-2">
                    <p>Perfume Spray (100ml)</p>
                </div>
            </div>
            <!-- Price -->
            <div class="mt-2">
                <p class="font-semibold">Price:</p>
                <p class="text-xl font-semibold text-red-500">Rs.2789</p>
            </div>
            <button
                    class="w-full mt-5 p-3 border-2 border-red-800 text-lg font-semibold rounded-full bg-red-700 text-white">Add to Cart</button>
         <button id="closeModalBtn" class="absolute -top-2 -right-2 font-bold bg-red-700 text-white px-4 py-2 rounded-full hover:bg-red-600 focus:outline-none">
            X
        </button>
    </div>
</div>

<script>
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('modal');
    const modalOverlay = document.getElementById('modalOverlay');

    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modalOverlay.classList.remove('hidden');
    });

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modalOverlay.classList.add('hidden');
    });

    // Close modal if clicked outside
    modalOverlay.addEventListener('click', () => {
        modal.classList.add('hidden');
        modalOverlay.classList.add('hidden');
    });
</script>

<?php
include "footer.php";
?>