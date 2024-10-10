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
        <h2 class="font-bold text-3xl">Best Sellers</h2>
    </div>

    <!-- Products section -->
    <div id="products-container" class="w-full p-3 flex justify-start gap-5 overflow-hidden overflow-x-auto">
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

        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow">
            <div
                class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/<?= $list['image'] ?>" alt="<?= $list['name'] ?>" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/<?= $list['image2'] ?>" alt="<?= $list['name'] ?>" alt=" Hover"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id=" class="text-lg font-bold hover:underline"><?= $list['name'] ?></a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                    <?= $list['description'] ?> </p>
                <p class="text-lg font-bold text-red-500">Rs. <?= $list['price'] ?></p>
            </div>
        </div>

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

        <div class="product-card w-96 md:w-72 h-[25rem] lg:h-[30rem] flex gap-2 flex-col relative group shadow">
            <div
                class="openModalBtn z-10 absolute -top-2 -right-2 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full p-3 flex items-center justify-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out cursor-pointer">
                <i class="fas fa-plus text-white pl-0.5 font-semibold"></i>
            </div>

            <!-- Product image wrapper -->
            <div class="relative h-[70%] w-full">
                <a href="product_details.php?id=" class="product-link w-full">
                    <img src="./image/<?= $list['image'] ?>" alt="<?= $list['name'] ?>" alt=""
                        class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                    <img src="./image/<?= $list['image2'] ?>" alt="<?= $list['name'] ?>"
                        class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                </a>
            </div>

            <!-- Product details -->
            <div class="px-4 py-2 h-full flex flex-col justify-evenly">
                <a href="product_details.php?id=" class="text-lg font-bold hover:underline"><?= $list['name'] ?></a>
                <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2">
                    <?= $list['description'] ?> </p>
                <p class="text-lg font-bold text-red-500">Rs. <?= $list['price'] ?></p>
            </div>
        </div>

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
</section>

<!-- Few Categories -->
<section class="my-10">

</section>

<?php
include "footer.php";
?>