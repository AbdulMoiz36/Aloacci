<?php
include "header.php";
$select = "SELECT * FROM banner LIMIT 1";
$res = mysqli_query($con, $select);

// Hero Section Start
if(mysqli_num_rows($res) > 0){
    $row = mysqli_fetch_assoc($res); // Fetch a single row
    ?>
<div class="Hero bg-slate-400 h-[20vh] md:h-[70vh]">
    <img src="./image/<?= $row['image'] ?>" alt="Banner" class="object-cover w-full h-full">
</div>
<?php
}
?>
<!-- Hero Section End-->

<!-- Products Showcase -->
<section>
    <!-- Heading and View All -->
    <div class="p-5 lg:p-16 flex justify-between">
        <h2 class="font-bold text-3xl">Our Products</h2>
        <a href="#">
            <p class="underline cursor-pointer font-semibold">View all</p>
        </a>
    </div>

    <!-- Products section -->
    <div id="products-container" class="w-full p-3 flex justify-start gap-5 overflow-hidden overflow-x-auto">
       
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        
    </div>
</section>

<!-- Few Categories -->
<section class="my-10">
    <div class="flex justify-evenly gap-4 overflow-x-auto py-2">
        <div class="flex flex-col items-center">
            <div
                class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
        <div class="flex flex-col items-center">
            <div
                class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
        <div class="flex flex-col items-center">
            <div
                class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
        <div class="flex flex-col items-center">
            <div
                class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./img/product-1.jpg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
    </div>
</section>

<!-- Best Sellers -->
<section>
    <!-- Heading and View All -->
    <div class="p-5 lg:p-16 flex justify-between">
        <h2 class="font-bold text-3xl">Best Seller</h2>
        <!-- <a href="#">
            <p class="underline cursor-pointer font-semibold">View all</p>
        </a> -->
    </div>

    <!-- Products section -->
    <div id="products-container" class="w-full p-3 flex justify-start gap-5 overflow-hidden overflow-x-auto">
       
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        
    </div>
</section>

<!-- Few Categories -->
<section class="my-10">
    
</section>

<!-- New Arrival -->
<section>
    <!-- Heading and View All -->
    <div class="p-5 lg:p-16 flex justify-between">
        <h2 class="font-bold text-3xl">New Arrival</h2>
        <!-- <a href="#">
            <p class="underline cursor-pointer font-semibold">View all</p>
        </a> -->
    </div>

    <!-- Products section -->
    <div id="products-container" class="w-full p-3 flex justify-start gap-5 overflow-hidden overflow-x-auto">
       
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow"
           >
            <div class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer"
               >
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/umeed.jpeg" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/umeed_77_11zon.jpeg" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id="
                    class="text-lg font-bold hover:underline">Product Name</a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                  Description  </p>
                <p class="text-lg font-bold text-red-500">Rs. 5500</p>
            </div>
        </div>
        
    </div>
</section>


<!-- Script for Modal Functionality -->
<script>
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

    openModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const productName = btn.getAttribute('data-product-name');
        const productFormats = JSON.parse(btn.getAttribute('data-product-formats'));

        // Populate modal
        document.getElementById('modal-product-name').innerText = productName;

        // Clear previous formats
        const formatContainer = document.getElementById('format-container');
        formatContainer.innerHTML = ''; // Clear previous formats

        let firstAvailableFormatFound = false;

        productFormats.forEach((formatObj, index) => {
            const formatDiv = document.createElement('div');
            formatDiv.className = 'border-2 border-black p-2 cursor-pointer w-fit my-2';
            formatDiv.innerText = `${formatObj.format}`;
            formatDiv.dataset.price = formatObj.price;
            formatDiv.dataset.qty = formatObj.qty; // Include quantity data
            
            // Check if the format is in stock
            if (formatObj.qty > 0) {
                // If it's the first available format, select it by default
                if (!firstAvailableFormatFound) {
                    formatDiv.classList.add('bg-gray-200');
                    modalProductPrice.innerText = `Rs. ${formatObj.price}`;
                    firstAvailableFormatFound = true;
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
            } else {
                // If out of stock, disable this format
                formatDiv.classList.add('opacity-50', 'cursor-not-allowed');
            }

            formatContainer.appendChild(formatDiv);
        });

        // If no available format found, show a warning or disable the "Add to Cart" button
        if (!firstAvailableFormatFound) {
            modalProductPrice.innerText = 'Out of Stock';
            document.getElementById('addToCartBtn').classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            document.getElementById('addToCartBtn').classList.remove('opacity-50', 'cursor-not-allowed');
        }

        // Set the current product ID
        currentProductId = btn.getAttribute('data-product-id');
        
        // Show modal and overlay
        modal.classList.remove('hidden');
        modalOverlay.classList.remove('hidden');
        modal.classList.add('flex');
        modalOverlay.classList.add('flex'); // Show the overlay
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
        if (selectedFormat && !selectedFormat.classList.contains('cursor-not-allowed')) {
            const format = selectedFormat.innerText; // Get the selected format text
            const price = selectedFormat.dataset.price; // Get the selected format price
            // Call manage_cart with the current product ID, selected format, and quantity
            manage_cart(currentProductId, 'add', quantity, format, price); // Pass the quantity and format
        } else {
            alert("Please select an available format.");
        }
    });
</script>



<?php
include "footer.php";
?>