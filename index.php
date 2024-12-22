<?php
include "header.php";

$about_select = "SELECT * FROM about";
$about_res = mysqli_query($con, $about_select);
$about_row = mysqli_fetch_assoc($about_res);
$sel_data = mysqli_query($con, "SELECT * FROM homepage_data");
$data = mysqli_fetch_assoc($sel_data);

$select = "SELECT * FROM banner";
$res = mysqli_query($con, $select);

$imagePath1 = $data['image1_path'];
$imagePath2 = $data['image2_path'];
$imagePath3 = $data['image3_path'];
// Remove the first dot from the path if it exists at the beginning
$imagePath1 = ltrim($imagePath1, '.');
$imagePath2 = ltrim($imagePath2, '.');
$imagePath3 = ltrim($imagePath3, '.');


if (mysqli_num_rows($res) > 0) {
    $images = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $images[] = $row['image']; // Collect all images
    }

    // If there's more than one image, show carousel
    if (count($images) > 1) {
?>
        <div id="heroCarousel" class="relative Hero bg-slate-400 h-[20vh] md:h-[70vh] overflow-hidden">
            <div class="carousel-track relative w-full h-full flex transition-transform duration-700 ease-in-out">
                <!-- Carousel items -->
                <?php foreach ($images as $index => $image) { ?>
                    <div class="carousel-item min-w-full h-full">
                        <img src="./image/<?= $image ?>" alt="Banner" class="object-cover md:object-fit w-full h-full"
                            loading="<?= $index === 0 ? 'eager' : 'lazy' ?>" width="1920" height="600">

                    </div>
                <?php } ?>
            </div>

            <!-- Carousel indicators -->
            <div class="absolute bottom-0 left-0 right-0 z-10 flex justify-center p-4">
                <?php foreach ($images as $index => $image) { ?>
                    <button data-slide="<?= $index ?>" class="indicator w-3 h-3 mx-1 rounded-full bg-gray-400"></button>
                <?php } ?>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let currentSlide = 0;
                const slides = document.querySelectorAll('#heroCarousel .carousel-item');
                const indicators = document.querySelectorAll('#heroCarousel .indicator');
                const track = document.querySelector('#heroCarousel .carousel-track');

                function showSlide(index) {
                    const slideWidth = slides[0].offsetWidth;
                    track.style.transform = `translateX(${-slideWidth * index}px)`;

                    indicators.forEach((indicator, i) => {
                        indicator.classList.toggle('bg-gray-700', i === index);
                        indicator.classList.toggle('bg-gray-400', i !== index);
                    });

                    currentSlide = index;
                }

                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => showSlide(index));
                });

                setInterval(() => showSlide((currentSlide + 1) % slides.length), 5000);

                showSlide(0);
            });
        </script>
        <style>
            .carousel-item {
                transition: transform 0.7s ease;
            }

            /* Active indicator style */
            .indicator.bg-gray-900 {
                background-color: #1a202c;
                /* Darker gray for active */
            }
        </style>
    <?php
    } else {
        // Only one image, no need for carousel
    ?>
        <div class="Hero bg-slate-400 h-[20vh] md:h-[70vh]">
            <img src="./image/<?= $images[0] ?>" alt="Banner" class="object-cover md:object-fit w-full h-full" defer>
        </div>
<?php
    }
}
?>

<!-- Hero Section End-->


<!-- New Arrival -->
<section class="p-1 lg:px-5">
    <!-- Heading and View All -->
    <div class="py-5 px-2 lg:px-8 lg:py-16 flex justify-between">
        <h2 class="font-bold text-2xl md:text-3xl underline">New Arrival:</h2>
    </div>

    <!-- Products section -->
    <div id="products-container"
        class="w-full p-0 lg:p-3 flex justify-start gap-2 md:gap-5 overflow-hidden overflow-x-auto">
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
            $hover_image = '';
            $p_id = $list['id'];
            // Determine which images to display based on availability
            $main_image = $list['image'];
            $fetch_hover = mysqli_query($con, "SELECT image_path FROM product_images WHERE product_id = '$p_id' LIMIT 1 ");
            if ($res = mysqli_fetch_assoc($fetch_hover)) {
                $hover_image = $res['image_path'];
            } else {
                $hover_image = $main_image;
            }
            // $hover_image = ($main_image === $list['image']);
            // if (!$hover_image) {
            //     $hover_image = $main_image; // Default to main image if no hover image is found
            // }
        ?>

            <div
                class="product-card min-w-28 lg:w-full md:w-72 h-[20rem] lg:h-[40rem] flex gap-2 flex-col relative group shadow">
                <?php
                $final_price = $list['price'];
                $non_sale_price = $list['price'];

                if (!empty($list['sale_price']) && $list['sale_price'] > 0) {
                    if ($list['unit_of_sale'] === 'Price') {
                        $final_price = $list['price'] - $list['sale_price'];
                    } elseif ($list['unit_of_sale'] === 'Percentage') {
                        $final_price = $list['price'] - floor($list['price'] * ($list['sale_price'] / 100));
                    }
                    $final_price = max(0, $final_price);
                }
                if ($list['sale_price'] > 0) { 
                ?>
                    <div class="bg-red-600 absolute z-10 top-0 left-0 px-3 rounded-tl-md">
                        <p class="text-white">Sale</p>
                    </div>
                <?php
                }
                ?>

                <!-- Product image wrapper -->
                <div class="relative h-[65%] w-full">
                    <a href="product_details?id=<?= $list['id'] ?>" class="product-link w-full">
                        <img src="./image/products/<?= $main_image ?>" alt="<?= $list['name'] ?>"
                            class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                        <img src="./image/products/<?= $hover_image ?>" alt="<?= $list['name'] ?> Hover"
                            class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                    </a>
                </div>

                <!-- Product details -->
                <div class="px-4 py-2 h-[35%] flex flex-col justify-evenly">
                    <a href="product_details?id=<?= $list['id'] ?>"
                        class="text-sm md:text-lg font-bold hover:underline"><?= $list['name'] ?></a>
                    <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2 text-xs md:text-base">
                        <?= $list['description'] ?> </p>
                        <p class="text-sm md:text-lg font-bold text-red-500">
                            Rs. <?= htmlspecialchars($final_price) ?>
                            <?php if ($final_price < $non_sale_price): ?>
                                <span class="text-gray-500 line-through text-xs md:text-sm ml-2">Rs. <?= htmlspecialchars($non_sale_price) ?></span>
                            <?php endif; ?>
                        </p>
                </div>
            </div>

        <?php

            // Increment the displayed products counter
            $displayed_products++;

            // Stop displaying more products if the limit of 5 is reached
            if ($displayed_products >= 5) {
                break;
            }
        }
        ?>
    </div>
</section>


<section class="py-24 relative">
    <div class="w-full max-w-7xl px-4 md:px-5 lg:px-5 mx-auto">
        <div class="w-full justify-start items-center gap-12 grid lg:grid-cols-2 grid-cols-1">
            <div
                class="w-full justify-center items-start gap-6 grid grid-cols-2  lg:order-first order-last">
                <div class="pt-24 lg:justify-center sm:justify-end justify-start items-start gap-2.5 flex">
                    <img class=" rounded-xl object-cover" src=".<?= $imagePath1 ?>"
                        alt="about Us image" />
                </div>
                <img class="sm:ml-0 ml-auto rounded-xl object-cover" src=".<?= $imagePath2 ?>"
                    alt="about Us image" />
            </div>
            <div class="w-full flex-col justify-center lg:items-start items-center gap-10 inline-flex">
                <div class="w-full flex-col justify-center items-start gap-8 flex">
                    <div class="w-full flex-col justify-start lg:items-start items-center gap-3 flex">
                        <h2
                            class="text-gray-900 text-4xl font-bold font-manrope leading-normal lg:text-start text-center">
                            <?= $data['text_input1'] ?></h2>
                        <p
                            class="text-gray-500 text-base font-normal leading-relaxed lg:text-start text-center">
                            <?= $data['editable_input1'] ?>
                        </p>
                    </div>
                    <div
                        class="w-full lg:justify-start justify-center items-center sm:gap-10 gap-5 inline-flex">
                        <div class="flex-col justify-start items-start inline-flex">
                            <h3 class="text-gray-900 text-4xl font-bold font-manrope leading-normal">33+</h3>
                            <h6 class="text-gray-500 text-base font-normal leading-relaxed">Years of Experience
                            </h6>
                        </div>
                        <div class="flex-col justify-start items-start inline-flex">
                            <h4 class="text-gray-900 text-4xl font-bold font-manrope leading-normal">125+</h4>
                            <h6 class="text-gray-500 text-base font-normal leading-relaxed">Successful Products
                            </h6>
                        </div>
                        <div class="flex-col justify-start items-start inline-flex">
                            <h4 class="text-gray-900 text-4xl font-bold font-manrope leading-normal">52+</h4>
                            <h6 class="text-gray-500 text-base font-normal leading-relaxed">Happy Clients</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="p-1 lg:px-5">
    <!-- Heading and View All -->
    <div class="py-5 p-2 lg:px-8 lg:py-16 flex justify-between">
        <h2 class="font-bold text-2xl md:text-3xl underline">On Sale:</h2>
    </div>

    <!-- Products section -->
    <div id="products-container"
        class="w-full p-3 flex justify-start gap-2 md:gap-5 overflow-hidden overflow-x-auto">
        <?php
        // Fetch all products
        $get_product = get_product($con);

        $unique_products = []; // Array to track unique products
        $displayed_products = 0; // Counter for displayed products
        $products_on_sale = array_filter($get_product, function ($product) {
            // Filter products with sale_price > 0 or not empty
            return !empty($product['sale_price']) && $product['sale_price'] > 0;
        });

        if (empty($products_on_sale)) {
            echo '<p class="text-gray-500 text-center w-full">No products on sale.</p>';
        } else {
            foreach ($products_on_sale as $list) {
                // Skip the product if it's already been displayed
                if (in_array($list['id'], $unique_products)) {
                    continue;
                }

                // Add the product ID to the unique products array
                $unique_products[] = $list['id'];
                $hover_image = '';
                $p_id = $list['id'];
                // Determine which images to display based on availability
                $main_image = $list['image'];
                $fetch_hover = mysqli_query($con, "SELECT image_path FROM product_images WHERE product_id = '$p_id' LIMIT 1 ");
                if ($res = mysqli_fetch_assoc($fetch_hover)) {
                    $hover_image = $res['image_path'];
                } else {
                    $hover_image = $main_image;
                }
                $final_price = $list['price'];
                $non_sale_price = $list['price'];

                if (!empty($list['sale_price']) && $list['sale_price'] > 0) {
                    if ($list['unit_of_sale'] === 'Price') {
                        $final_price = $list['price'] - $list['sale_price'];
                    } elseif ($list['unit_of_sale'] === 'Percentage') {
                        $final_price = $list['price'] - floor($list['price'] * ($list['sale_price'] / 100));
                    }
                    $final_price = max(0, $final_price);
                }
        ?>

                <div
                    class="product-card min-w-28  md:w-72 h-[20rem] lg:h-[40rem] flex gap-2 flex-col relative group shadow">
                    <div class="bg-red-600 absolute z-10 top-0 left-0 px-3 rounded-tl-md">
                        <p class="text-white">Sale</p>
                    </div>
                    <!-- Product image wrapper -->
                    <div class="relative h-[65%] w-full">
                        <a href="product_details?id=<?= $list['id'] ?>" class="product-link w-full">
                            <img src="./image/products/<?= $main_image ?>" alt="<?= $list['name'] ?>"
                                class="h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                            <img src="./image/products/<?= $hover_image ?>" alt="<?= $list['name'] ?> Hover"
                                class="absolute top-0 left-0 h-full w-full object-cover rounded-t-lg transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100">
                        </a>
                    </div>

                    <!-- Product details -->
                    <div class="px-4 py-2 h-[35%] flex flex-col justify-evenly">
                        <a href="product_details?id=<?= $list['id'] ?>"
                            class="text-sm md:text-lg font-bold hover:underline"><?= $list['name'] ?>
                            <span class="text-gray-600 text-xs">(<?= $list['format'] ?> <?= $list['unit_of_measure'] ?>)</span>
                        </a>
                        <p class="text-gray-600 overflow-hidden text-ellipsis line-clamp-2 text-xs md:text-base">
                            <?= $list['description'] ?> </p>
                            <p class="text-sm md:text-lg font-bold text-red-500">
                                Rs. <?= htmlspecialchars($final_price) ?>
                                <?php if ($final_price < $non_sale_price): ?>
                                    <span class="text-gray-500 line-through text-xs md:text-sm ml-2">Rs. <?= htmlspecialchars($non_sale_price) ?></span>
                                    <?php endif; ?>
                        </p>
                    </div>
                </div>

        <?php

                // Increment the displayed products counter
                $displayed_products++;

                // Stop displaying more products if the limit of 5 is reached
                if ($displayed_products >= 5) {
                    break;
                }
            }
        }
        ?>
    </div>
</section>



<div id="about" class="relative bg-white overflow-hidden p-5 md:p-0  mt-20">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100"></polygon>
            </svg>

            <div class="pt-1"></div>

            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">

                    <p>
                        <?= $data['editable_input2'] ?>
                    </p>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover object-center sm:h-72 md:h-96 lg:w-full lg:h-full" src=".<?= $imagePath3 ?>" alt="">
    </div>
</div>
<?php
include "footer.php";
?>