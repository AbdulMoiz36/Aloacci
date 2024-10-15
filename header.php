<?php
require "config.php";
require "functions.php";
require "add_cart_func.php";

$obj = new add_to_cart();
$totalProduct = $obj->totalProduct();

$all_products = get_product($con);
$unique_products = [];

foreach ($all_products as $list) {
    // Use the ID as the key to ensure uniqueness
    if (!isset($unique_products[$list['id']])) {
        $unique_products[$list['id']] = $list; // Store the entire product
    }
}

// Reindex the unique products array
$unique_products = array_values($unique_products);

// Convert the unique products array to JSON
$unique_products_json = json_encode($unique_products);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aloacci</title>
  <link rel='shortcut icon' type='image/x-icon' href='./img/logo-cropped-bottom.png' />
  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Custom Styling -->
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/checkbox.css" />
  <!-- Font Awesome 6.0.0 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
  <!-- Toaster -->
  <link rel="stylesheet" href="./admin/assets/bundles/izitoast/css/iziToast.min.css">
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <button hidden id="registration_success"></button>
  <button hidden id="message_send"></button>


  <!-- Header Start -->
  <header
    class="bg-black h-auto flex-wrap-reverse justify-center items-center sm:flex sm:justify-between sm:px-10 px-5 py-3">
    <!-- Search Box Start -->
    <div class="flex gap-4">
      <i id="menu-icon" class="fa-solid fa-bars sm:hidden block text-lg text-white cursor-pointer"
        onclick="toggleNavbar()"></i>
      <div class="relative w-full">
        <form method="GET" action="shop" onsubmit="return validateSearch()">
          <input type="search" placeholder="Search" name="search" id="search"
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
            class="py-2 px-4 rounded-full w-full outline-none" autocomplete="off" onkeyup="showDropdown(this.value)" />
          <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-black text-lg sm:text-xl"></i>
        </form>

        <!-- Dropdown container -->
        <div id="dropdown" class="absolute bg-white border rounded-lg sm:w-full md:w-[150%] max-h-80 overflow-y-auto hidden z-10 shadow-lg"></div>

        <script>
          // Function to show the dropdown with products
          function showDropdown(query) {
            var dropdown = document.getElementById('dropdown');

            // If query is empty, hide the dropdown
            if (query.trim() === '') {
              dropdown.innerHTML = '';
              dropdown.classList.add('hidden');
              return;
            }
            
            // Simulate fetching product data from backend (you can replace this with an actual fetch call)
            var products = <?= $unique_products_json ?>;

            // Filter products based on search query
            var filteredProducts = products.filter(function(product) {
              return product.name.toLowerCase().includes(query.toLowerCase());
            });

            // If no products match, hide the dropdown
            if (filteredProducts.length === 0) {
              dropdown.innerHTML = '<p class="px-4 py-2 text-gray-500">No results found</p>';
              dropdown.classList.remove('hidden');
              return;
            }

            // Build the dropdown content
            var content = '';
            filteredProducts.forEach(function(product) {
              content += `
          <a href="product_details?id=${product.id}" class="flex items-center px-4 py-2 hover:bg-gray-100">
            <img src="./image/${product.image}" alt="${product.name}" class="w-12 h-12 rounded-full object-cover mr-4" />
            <div>
              <p class="font-semibold text-gray-800">${product.name}</p>
              <p class="text-sm text-gray-500">${product.description}</p>
              <p class="text-sm font-bold text-red-600">Rs.${product.price}</p>
            </div>
          </a>
        `;
            });

            dropdown.innerHTML = content;
            dropdown.classList.remove('hidden');
          }

          // Function to validate search input before form submission
          function validateSearch() {
            var searchInput = document.getElementById('search').value.trim();
            if (searchInput === '') {
              return false;
            }
            return true;
          }

          // Hide dropdown when clicking outside
          document.addEventListener('click', function(event) {
            var dropdown = document.getElementById('dropdown');
            var searchBox = document.getElementById('search');
            if (!searchBox.contains(event.target) && !dropdown.contains(event.target)) {
              dropdown.classList.add('hidden');
            }
          });
        </script>
      </div>

    </div>
    </div>
    <!-- Logo Start -->
    <div class="flex justify-center">
      <a href="index"><img src="./img/logo-cropped-bottom.png" alt="Logo" width="100px" /></a>
    </div>
    <!-- Acccount And Cart Start -->
    <div class="flex justify-center space-x-10 text-white items-center">
      <!-- Account -->
      <div class="flex items-center space-x-3 text-lg sm:text-xl">
        <?php
        if (isset($_SESSION['USER_LOGIN'])) {
        ?>
          <a href="account"><i class="fas fa-user"></i> Account</a>
        <?php
        } else {
        ?>
          <a href="login"><i class="fas fa-user"></i> Login</a>
        <?php
        }
        ?>
      </div>
      <!-- Cart -->
      <div class="flex items-center space-x-3 text-lg sm:text-xl">
        <?php
        if (!isset($_SESSION['USER_LOGIN'])) {
        ?>
          <a href="login">
            <i class="fa-sharp fa-solid fa-bag-shopping"></i>
            <span>Cart</span>
          </a>
        <?php
        } else {
        ?>
          <a href="cart" class="flex items-center cart-link">
            <!-- Cart Icon -->
            <div class="relative">
              <i class="fa-sharp fa-solid fa-bag-shopping text-xl"></i>
              <!-- Badge showing total products -->
              <span
                class="cart-quantity absolute top-0 -right-2 transform translate-x-2 -translate-y-2 bg-amber-600 text-white rounded-full px-2 py-0.5 text-xs font-bold">
                <?php echo $totalProduct ?>
              </span>
            </div>

            <!-- Cart Text -->
            <span class="ml-2">Cart</span>
          </a>

        <?php
        }
        ?>
      </div>
    </div>
  </header>
  <!-- Header End -->

  <!-- Navbar Start -->
  <nav id="navbar"
    class="bg-black border-t-2 relative border-slate-900 h-auto hidden sm:flex justify-center items-center px-14">
    <!-- List Of All Main Pags -->
    <ul class="flex flex-col sm:flex-row gap-4 sm:gap-10 text-white text-center py-3">
      <a href="index">Home</a>
      <a href="shop">Shop</a>
      <li class="hover:cursor-pointer" id="shop" onclick="toggleShop()">
        Categories
        <i class="fa-solid fa-angle-down ml-1 align-middle text-sm"></i>
        <!-- Menu For Shop -->
        <ul
          class="hidden w-full absolute bg-white text-black shadow-xl grid-cols-2 sm:grid-cols-4 gap-10 z-50 top-12 left-0 p-10"
          id="menu">
          <div class="w-full hover:underline absolute top-0 flex justify-center align-middle left-0 font-bold border-b p-1 md:hidden" onclick="toggleShop()">
            <i class="fa-solid fa-xmark text-base cursor-pointer pr-2" onclick="toggleShop()"></i>
            <p onclick="toggleShop()">Close</p>
          </div>
          <?php
          // Fetch categories
          $categoriesQuery = mysqli_query($con, "SELECT * FROM categories");
          while ($category = mysqli_fetch_assoc($categoriesQuery)) {
            echo '<li class="text-start font-semibold"> 
                        <a href="shop?category_id=' . $category['id'] . '" class="font-semibold">';
            echo htmlspecialchars($category['categories']);
            echo '</a><ul class="mt-2 font-thin flex flex-col gap-1">';

            // Fetch sub-categories for this category
            $subCategoriesQuery = mysqli_query($con, "SELECT * FROM sub_categories WHERE category_id = '" . $category['id'] . "' AND `status` = 1");
            while ($subCategory = mysqli_fetch_assoc($subCategoriesQuery)) {
              echo '<a href="shop?sub_category_id=' . $subCategory['id'] . '"><li class="hover:underline hover:cursor-pointer">';
              echo htmlspecialchars($subCategory['sub_categories']);
              echo '</li></a>';
            }

            echo '</ul>';
            echo '</li>';
          }
          ?>

        </ul>
      </li>
      <a href="shop?price_filter=less_1500">Less than 1500</a>
      <a href="about">
        <li class="hover:underline hover:cursor-pointer">About</li>
      </a>
      <a href="contact">
        <li class="hover:underline hover:cursor-pointer">Contact</li>
      </a>
    </ul>
  </nav>
  <!-- Navbar End -->