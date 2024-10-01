<?php
require "config.php";
require "functions.php";
require "add_cart_func.php";

$obj = new add_to_cart();
$totalProduct = $obj->totalProduct();

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
  <button hidden id="cart_add"></button>

  <!-- Header Start -->
  <header
    class="bg-black h-auto flex-wrap-reverse justify-center items-center sm:flex sm:justify-between sm:px-10 px-5 py-3">
    <!-- Search Box Start -->
    <div class="flex gap-4">
      <i id="menu-icon" class="fa-solid fa-bars sm:hidden block text-lg text-white cursor-pointer"
        onclick="toggleNavbar()"></i>
      <div class="relative w-full">
        <input type="search" placeholder="Search" name="head-search" id="head-search"
          class="py-2 px-4 rounded-full w-full outline-none" />
        <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-black text-lg sm:text-xl"></i>
      </div>
    </div>
    <!-- Logo Start -->
    <div class="flex justify-center">
      <a href="index.php"><img src="./img/logo-cropped-bottom.png" alt="Logo" width="100px" /></a>
    </div>
    <!-- Acccount And Cart Start -->
    <div class="flex justify-center space-x-10 text-white items-center">
      <!-- Account -->
      <div class="flex items-center space-x-3 text-lg sm:text-xl">
        <?php
        if (isset($_SESSION['USER_LOGIN'])) {
        ?>
          <i class="fas fa-user"></i>
          <a href="account.php">Account</a>
        <?php
        } else {
        ?>
          <i class="fas fa-user"></i>
          <a href="login.php">Login</a>
        <?php
        }
        ?>
      </div>
      <!-- Cart -->
      <div class="flex items-center space-x-3 text-lg sm:text-xl">
        <?php
        if (!isset($_SESSION['USER_LOGIN'])) {
        ?>
          <a href="login.php">
            <i class="fa-sharp fa-solid fa-bag-shopping"></i>
            <span>Cart</span>
          </a>
        <?php
        } else {
        ?>
          <a href="cart.php" class=" flex items-center">
            <!-- Cart Icon -->
            <div class=" relative">
              <i class="fa-sharp fa-solid fa-bag-shopping text-xl"></i>
              <!-- Badge showing total products -->
              <span class="cart-quantity absolute top-0 -right-2 transform translate-x-2 -translate-y-2 bg-red-600 text-white rounded-full px-2 py-0.5 text-xs font-bold">
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
      <!-- Shop -->
      <li class="hover:cursor-pointer" id="shop" onclick="toggleShop()">
        Shop
        <i class="fa-solid fa-angle-down ml-1 align-middle text-sm"></i>
        <!-- Menu For Shop -->
        <ul
          class="hidden w-full absolute bg-white text-black shadow-xl grid-cols-2 sm:grid-cols-4 gap-10 z-50 top-12 left-0 p-10"
          id="menu">
          <?php

          // Fetch categories
          $categoriesQuery = mysqli_query($con, "SELECT * FROM categories");
          while ($category = mysqli_fetch_assoc($categoriesQuery)) {
            echo '<li class="text-start font-semibold"> <a href="#" class="font-semibold">';
            echo htmlspecialchars($category['categories']);
            echo '</a><ul class="mt-2 font-thin flex flex-col gap-1">';

            // Fetch sub-categories for this category
            $subCategoriesQuery = mysqli_query($con, "SELECT * FROM sub_categories WHERE category_id = '" . $category['id'] . "' AND `status` = 1");
            while ($subCategory = mysqli_fetch_assoc($subCategoriesQuery)) {
              echo '<a href="#"><li class="hover:underline hover:cursor-pointer">';
              echo htmlspecialchars($subCategory['sub_categories']);
              echo '</li></a>';
            }

            echo '</ul>';
            echo '</li>';
          }
          ?>
        </ul>
      </li>
      <a href="shop.php">Aloacci Steals</a>
      <a href="shop.php">Less than 1500</a>
      <a href="shop.php">Attars</a>
      <a href="shop.php">Bundles</a>
      <a href="#">
        <li class="hover:underline hover:cursor-pointer">About</li>
      </a>
      <a href="contact.php">
        <li class="hover:underline hover:cursor-pointer">Contact</li>
      </a>
    </ul>
  </nav>
  <!-- Navbar End -->