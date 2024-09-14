<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aloacci</title>
  
        <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Custom Styling -->
  <link rel="stylesheet" href="./css/style.css" />
  <!-- Font Awesome 6.6.0 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
</head>

<body>
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
      <img src="./img/logo-cropped-bottom.png" alt="Logo" width="100px" />
    </div>
    <!-- Acccount And Cart Start -->
    <div class="flex justify-center space-x-10 text-white items-center">
      <!-- Account -->
      <div class="flex items-center space-x-3 text-lg sm:text-xl">
        <i class="fas fa-user "></i>
        <?php
          if(isset($_SESSION['USER_LOGIN'])){
        ?>
        <span>Account</span>
        <?php
          }else{
        ?>
        <a href="" data-toggle="modal">Login</a>  
        <?php
        }
        ?>
      </div>
      <!-- Cart -->
      <div class="flex items-center space-x-3 text-lg sm:text-xl">
        <i class="fa-sharp fa-solid fa-bag-shopping "></i>
        <span>Cart</span>
      </div>
    </div>
  </header>
  <!-- Header End -->

  <!-- Navbar Start -->
  <nav id="navbar"
    class="bg-black border-t-2 relative border-slate-900 h-auto hidden sm:flex justify-center items-center px-14">
    <ul class="flex  flex-col sm:flex-row gap-4 sm:gap-10 text-white text-center py-3 ">
      <li class="hover:cursor-pointer" id="shop" onclick="toggleShop()">Shop
        <i class="fa-solid fa-angle-down ml-1 align-middle text-sm"></i>
        <ul
          class="hidden w-full absolute bg-white text-black shadow-xl grid-cols-2 sm:grid-cols-4 gap-10 z-10 top-12 left-0 p-10 "
          id="menu">
          <li class="text-start font-semibold">
            SubLink
            <ul class="mt-2 font-thin flex flex-col gap-1">
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
            </ul>
          </li>
          <li class="text-start font-semibold">
            SubLink
            <ul class="mt-2 font-thin flex flex-col gap-1">
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
            </ul>
          </li>
          <li class="text-start font-semibold">
            SubLink
            <ul class="mt-2 font-thin flex flex-col gap-1">
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
            </ul>
          </li>
          <li class="text-start font-semibold">
            SubLink
            <ul class="mt-2 font-thin flex flex-col gap-1">
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
              <a href="#">
                <li class="hover:underline hover:cursor-pointer">Sub-Sub Link</li>
              </a>
            </ul>
          </li>
        </ul>

      </li>
      <li>Link 2</li>
      <li>Link 3</li>
      <li>Link 4</li>
      <li>Link 5</li>
      <a href="#">
        <li class="hover:underline hover:cursor-pointer">About</li>
      </a>
      <a href="#">
        <li class="hover:underline hover:cursor-pointer">Contact</li>
      </a>
    </ul>
  </nav>
  <!-- Navbar End -->

</body>
<!-- scripts -->
<script src="./js/script.js"></script>
<!-- Custom -->
<script src="./js/custom.js"></script>

</html>