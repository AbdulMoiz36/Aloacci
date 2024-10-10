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

<!-- Best Sellers -->
<section>
    <!-- Heading and View All -->
    <div class="p-5 lg:p-16  flex justify-between">
        <h2 class="font-bold text-3xl">Our Best Sellers</h2>
    </div>

    <!-- Product Cards Container -->
    <div class=" mx-auto px-6 lg:px-10 ">
        <div class="space-x-3">
            <!-- Product Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
            <?php
                // Fetch all products
                $get_product = get_product($con);

                $unique_products = []; // Array to track unique products
                $displayed_products = 0; // Counter for displayed products

                foreach ($get_product as $list) {
                    // Check if the product belongs to the "Best Sellers" category
                    if ($list['categories'] !== 'Best Sellers') {
                        continue; // Skip products that are not in the "Best Sellers" category
                    }

                    // Skip the product if it's already been displayed
                    if (in_array($list['id'], $unique_products)) {
                        continue;
                    }

                    // Add the product ID to the unique products array
                    $unique_products[] = $list['id'];

                    // Display the product card
                    ?>
                    <!-- Product Card Start-->
                    <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                        <div class="relative">
                            <!-- Default Image -->
                            <img src="./image/<?= $list['image'] ?>" alt="<?= $list['name'] ?>" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                            <!-- Image to show on hover -->
                            <img src="./image/<?= $list['image2'] ?>" alt="<?= $list['name'] ?>" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                        </div>
                        <!-- Add to cart -->
                        <a href="#">
                            <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                            </div>
                        </a>
                        <div class="p-4">
                            <h2 class="font-bold text-lg"><?php echo $list['name']; ?></h2>
                            <p class="text-gray-600"><?php echo $list['description']; ?></p>
                            <!-- Price Section -->
                            <div class="flex items-center space-x-2">
                                <span class="text-red-500 font-semibold">Rs.<?php echo $list['price']; ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- Product Card End-->
                    <?php

                    // Increment the displayed products counter
                    $displayed_products++;

                    // Stop displaying more products if the limit of 4 is reached
                    if ($displayed_products >= 4) {
                        break;
                    }
                }
                ?>
            </div>
            <!-- Prouct Cards Grid End -->
        </div>
    </div>
</section>

<!-- Few Categories -->
<section class="my-10">
    <div class="flex justify-evenly gap-4 overflow-x-auto py-2">
        <div class="flex flex-col items-center">
            <div
                class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="../image/Florse.jpeg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
        <div class="flex flex-col items-center">
            <div
                class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./image/Florse.jpeg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
        <div class="flex flex-col items-center">
            <div
                class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./image/Florse.jpeg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
        <div class="flex flex-col items-center">
            <div
                class="relative rounded-full  cursor-pointer overflow-hidden w-36 h-36 md:w-60 md:h-60 mb-4 transition-transform duration-300 ease-in-out hover:translate-y-[-10px]">
                <img src="./image/Florse.jpeg" alt="" class="object-cover w-full h-full">
            </div>
            <p class="text-black font-semibold text-center hover:underline cursor-pointer">Men</p>
        </div>
    </div>
</section>

<!-- Products Showcase -->
<section>
    <!-- Heading and View All -->
    <div class="p-5 lg:p-16 flex justify-between">
        <h2 class="font-bold text-3xl">New Arrival</h2>
    </div>

    <!-- Product Cards Container -->
    <div class="mx-auto px-6 lg:px-10">
        <div class="space-x-3">
            <!-- Product Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
                <?php
                // Fetch all products
                $get_product = get_product($con);

                $unique_products = []; // Array to track unique products
                $displayed_products = 0; // Counter for displayed products

                foreach ($get_product as $list) {
                    // Skip the product if it's already been displayed
                    if (in_array($list['id'], $unique_products)) {
                        continue;
                    }

                    // Add the product ID to the unique products array
                    $unique_products[] = $list['id'];

                    // Display the product card
                    ?>
                    <!-- Product Card Start-->
                    <div class="relative bg-white shadow-md rounded-lg overflow-visible group">
                        <div class="relative">
                            <!-- Default Image -->
                            <img src="./image/<?= $list['image'] ?>" alt="<?= $list['name'] ?>" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                            <!-- Image to show on hover -->
                            <img src="./image/<?= $list['image2'] ?>" alt="<?= $list['name'] ?>" class="w-full h-3/4 object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0">
                        </div>
                        <!-- Add to cart -->
                        <a href="#">
                            <div class="absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
                            </div>
                        </a>
                        <div class="p-4">
                            <h2 class="font-bold text-lg"><?php echo $list['name']; ?></h2>
                            <p class="text-gray-600"><?php echo $list['description']; ?></p>
                            <!-- Price Section -->
                            <div class="flex items-center space-x-2">
                                <span class="text-red-500 font-semibold">Rs.<?php echo $list['price']; ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- Product Card End-->
                    <?php

                    // Increment the displayed products counter
                    $displayed_products++;

                    // Stop displaying more products if the limit of 4 is reached
                    if ($displayed_products >= 4) {
                        break;
                    }
                }
                ?>
            </div>
            <!-- Product Cards Grid End -->
        </div>
    </div>
</section>

<?php
include "footer.php";
?>