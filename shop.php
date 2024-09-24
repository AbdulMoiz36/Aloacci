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
<section class="container flex">
    <!-- Filters div -->
    <div class="w-5/6 md:w-1/6 fixed md:relative border-r-2 border-slate-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out bg-white h-screen top-0 z-20 p-5" id="filters">
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
    <div class="w-full md:w-5/6 p-3 flex  ">
        <div class="w-full grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            <!-- Product Card Start-->
            <?php
                        foreach ($products as $list) {
                        ?>
            <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                <div class="relative">
                    <!-- Default Image -->
                    <img src="./image/<?= $list['image'] ?>" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <!-- Image to show on hover -->
                    <img src="./image/<?= $list['image'] ?>" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                </div>
                <!-- Add to cart -->
                <a href="#">
                    <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                        <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                    </div>
                </a>
                <div class="p-4">
                    <h2 class="font-bold text-lg"><?= $list['name'] ?></h2>
                    <p class="text-gray-600">Description of Product 1</p>
                    <!-- Price Section -->
                    <div class="flex items-center space-x-2">
                        <span class="text-red-500 font-semibold">Rs.<?= $list['price'] ?></span>
                    </div>
                </div>
            </div>
            <!-- Product Card End-->
            <?php
                        }
                        ?>

            <!-- Repeat for more products... -->
        </div>

    </div>
</section>

<?php
include "footer.php";
?>