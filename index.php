<?php
include "header.php";
?>
<!-- Hero Section Start-->
<div class="Hero bg-slate-400 h-[20vh] md:h-[70vh]">
    <img src="./img//DemoBanner.jpg" alt="Banner" class="object-cover w-full h-full">
</div>
<!-- Hero Section End-->

<!-- Products Showcase -->
<section>
    <!-- Heading and View All -->
    <div class="p-5 lg:p-16  flex justify-between">
        <h2 class="font-bold text-3xl">Our Products</h2>
        <a href="#">
            <p class="underline cursor-pointer font-semibold">View all</p>
        </a>
    </div>

    <!-- Product Cards Container -->
    <div class=" mx-auto px-6 lg:px-10 ">
        <div class="space-x-3">
            <!-- Product Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4  ">
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                
            </div>
            <!-- Prouct Cards Grid End -->
        </div>
    </div>
</section>

<!-- Few Categories -->
<section class="my-10">
    <div class="flex justify-evenly gap-4 overflow-x-auto py-2">
    <div class="flex flex-col items-center">
            <div class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div> <div class="flex flex-col items-center">
            <div class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div> <div class="flex flex-col items-center">
            <div class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div> <div class="flex flex-col items-center">
            <div class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
    </div>
</section>




<!-- Best Sellers -->
<section>
    <!-- Heading and View All -->
    <div class="p-5 lg:p-16  flex justify-between">
        <h2 class="font-bold text-3xl">Our Best Sellers</h2>
        <a href="#">
            <p class="underline cursor-pointer font-semibold">View all</p>
        </a>
    </div>

    <!-- Product Cards Container -->
    <div class=" mx-auto px-6 lg:px-10 ">
        <div class="space-x-3">
            <!-- Product Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4  ">
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                
            </div>
            <!-- Prouct Cards Grid End -->
        </div>
    </div>
</section>


<!-- Few Categories -->
<section class="my-10">
    <div class="flex justify-evenly gap-4 overflow-x-auto py-2">
    <div class="flex flex-col items-center">
            <div class="relative rounded-full  cursor-pointer overflow-hidden w-40 h-40 md:w-80 md:h-80 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div> <div class="flex flex-col items-center">
            <div class="relative rounded-full  cursor-pointer overflow-hidden w-40 h-40 md:w-80 md:h-80 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div> <div class="flex flex-col items-center">
            <div class="relative rounded-full  cursor-pointer overflow-hidden w-40 h-40 md:w-80 md:h-80 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div> <div class="flex flex-col items-center">
            <div class="relative rounded-full  cursor-pointer overflow-hidden w-40 h-40 md:w-80 md:h-80 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
    </div>
</section>




<!-- New Arrival -->
<section>
    <!-- Heading and View All -->
    <div class="p-5 lg:p-16  flex justify-between">
        <h2 class="font-bold text-3xl">New Arrival</h2>
        <a href="#">
            <p class="underline cursor-pointer font-semibold">View all</p>
        </a>
    </div>

    <!-- New Arrival Cards Container -->
    <div class=" mx-auto px-6 lg:px-10 ">
        <div class="space-x-3">
            <!-- Product Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4  ">
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                <!-- Product Caard Start-->
                <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                    <div class="relative">
                        <!-- Default Image -->
                        <img src="./img/product-1.jpg" alt="Product 1" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <!-- Image to show on hover -->
                        <img src="./img/product-1-2.jpg" alt="Product 1 Hover" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                    </div>
                    <!-- Add to cart -->
                    <a href="#">
                        <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                            <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                        </div>
                    </a>
                    <div class="p-4">
                        <h2 class="font-bold text-lg">Product 1</h2>
                        <p class="text-gray-600">Description of Product 1</p>
                        <!-- Price Section -->
                        <div class="flex items-center space-x-2">
                            <span class="text-red-500 font-semibold">Rs.2,140</span>
                        </div>
                    </div>
                </div>
                <!-- Product Card End-->
                
            </div>
            <!-- Prouct Cards Grid End -->
        </div>
    </div>
</section>



<?php
include "footer.php";
?>