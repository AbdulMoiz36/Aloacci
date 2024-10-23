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
      <a href="index" class="md:hidden"><img src="./img/logo-cropped-bottom.png" alt="Logo" width="50px"  /></a>
      <div class="relative w-full">
        <form method="GET" action="shop" onsubmit="return validateSearch()">
          <input type="search" placeholder="Search" name="search" id="search"
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
            class="py-2 px-4 rounded-full w-full outline-none" autocomplete="off" onkeyup="showDropdown(this.value)" />
          <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-black text-lg sm:text-xl"></i>
        </form>

        <!-- Dropdown container -->
        <div id="dropdown" class="absolute bg-white border rounded-lg sm:w-full md:w-[150%] max-h-80 overflow-y-auto hidden z-40 shadow-lg"></div>

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
      <a href="index"><img src="./img/logo-cropped-bottom.png" alt="Logo" width="100px" class="hidden md:block" /></a>
    </div>
    <!-- Acccount And Cart Start -->
    <div class="flex justify-center space-x-10 text-white items-center mt-7 md:mt-0">
    <i id="menu-icon" class="fa-solid fa-bars sm:hidden block text-lg text-white cursor-pointer md:hidden"
    onclick="toggleNavbar()"></i>
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
      <li class="hover:cursor-pointer" id="shop" onclick="toggleShop()">
        Shop
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
            $subCategoriesQuery = mysqli_query($con, "SELECT * FROM sub_categories WHERE category_id = '" . $category['id'] . "'");
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
      <!-- Contact Button with Dropdown (without anchor) -->
      <div class="relative flex justify-center">
        <div class="hover:cursor-pointer flex items-center" id="contactDropdownToggle" onclick="toggleDropdown()">
          <li class="hover:underline hover:cursor-pointer">Contact</li>
          <i class="fa-solid fa-angle-down ml-1.5 mt-1 align-middle text-sm"></i>
        </div>

        <!-- Dropdown Menu -->
        <div id="contactDropdownMenu" class="hidden absolute rght-0 top-6 md:left-0  w-48 border-2 bg-white rounded-md shadow-lg z-50">
          <ul class="py-1">
            <li>
              <a href="contact" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 border-b-slate-400 border-b">
                Contact Us
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900" onclick="openTrackModal()">
                Track Your Order
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Modal -->
      <div id="orderModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8">
          <h2 class="text-2xl font-bold mb-4 text-black">Track Your Order</h2>

          <!-- Error message -->
          <p id="errorMessage" class="text-red-500 text-sm mb-4 hidden">No orders found for this ID and phone number.</p>

          <!-- Input fields -->
          <div class="mb-4">
            <label for="orderId" class="block text-sm font-bold text-gray-700 text-left">Order ID:</label>
            <input type="text" id="orderId" class="block text-black border w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm" placeholder="Enter your order ID">
          </div>

          <div class="mb-4">
            <label for="phoneNumber" class="block text-sm font-bold text-gray-700 text-left">Phone Number</label>
            <input type="text" id="phoneNumber" class="block text-black w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm" maxlength="11" placeholder="Enter your 11-digit phone number">
          </div>

          <!-- Modal actions -->
          <div class="flex justify-end">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2" onclick="closeTrackModal()">Cancel</button>
            <button type="button" class="bg-amber-600 text-white px-4 py-2 rounded-md" onclick="submitOrder()">Track</button>
          </div>
        </div>
      </div>

      <script>
        // Function to open the modal
        function openTrackModal() {
          document.getElementById('orderModal').classList.remove('hidden');
          document.getElementById('orderModal').classList.add('flex');
        }

        // Function to close the modal
        function closeTrackModal() {
          document.getElementById('orderModal').classList.add('hidden');
        }

        function submitOrder() {
          const orderId = document.getElementById('orderId').value;
          const phoneNumber = document.getElementById('phoneNumber').value;
          const errorMessage = document.getElementById('errorMessage');

          // Clear any previous errors
          errorMessage.classList.add('hidden');

          // Validate inputs
          if (orderId.trim() === '' || phoneNumber.trim() === '') {
            errorMessage.textContent = 'Both fields are required.';
            errorMessage.classList.remove('hidden');
            return;
          }

          // Send AJAX request to PHP script
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'track_order.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              const response = JSON.parse(xhr.responseText);
              if (response.success) {
                // Redirect to order details page
                window.location.href = `order_details.php?id=${response.order_id}`;
              } else {
                // Show error message
                errorMessage.textContent = 'No orders found for this ID and phone number.';
                errorMessage.classList.remove('hidden');
              }
            }
          };
          xhr.send(`orderId=${orderId}&phoneNumber=${phoneNumber}`);
        }

        // Toggle dropdown on click
        function toggleDropdown() {
          const dropdownMenu = document.getElementById('contactDropdownMenu');
          dropdownMenu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
          const dropdownMenu = document.getElementById('contactDropdownMenu');
          const toggleButton = document.getElementById('contactDropdownToggle');
          if (!toggleButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
          }
        });
      </script>



    </ul>
  </nav>
  <!-- Navbar End -->