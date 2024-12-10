<?php
include "header.php";
$query = "SELECT * FROM bundles ORDER BY id DESC";

$sql = mysqli_query($con, $query);
?>

<section class="w-full flex flex-col items-center justify-center py-10">
    <div>
        <h1 class="text-3xl lg:text-5xl font-bold text-center">Bundles</h1>
    </div>
    <?php
    while ($bundle = mysqli_fetch_array($sql)) {
        $id = $bundle['id'];
        $query2 = "SELECT bd.bundle_id,bd.qty,p.name,p.image,pf.format,pf.unit_of_measure,bd.format_id,bd.product_id,pf.price
FROM bundle_details as bd
JOIN product as p ON bd.product_id = p.id
JOIN product_format pf ON bd.format_id = pf.id
WHERE bd.bundle_id = '$id'";
        $data = mysqli_query($con, $query2);
        
    ?>

        <!-- Single Bundle Start -->
        <div class="flex flex-col w-3/4 lg:w-2/4 mx-auto my-14" id="bundle-<?= $id ?>">
            <h1 class="text-lg md:text-xl lg:text-2xl font-extrabold text-center my-2">
                Add To Cart And Get <?= $bundle['discount_value'] ?>
                <?php echo ($bundle['discount_type'] === 'price') ? 'Rs' : '%'; ?>
                Off!
            </h1>

            <!-- Products -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 justify-items-center overflow-x-auto">
                <div class="col-span-4 flex justify-center">
                    <?php
                        $totalRows = mysqli_num_rows($data);
                    while ($row = mysqli_fetch_array($data)) {
                        $product_id = $row['product_id'];
                    ?>
                        <div class="w-full border-2" id="product-<?= $id ?>-<?= $product_id ?>">
                            <img src="./image/products/<?= $row['image'] ?>" alt="" width="190px" class="mx-auto">
                            <div class="py-5 pl-3">
                                <a href="product_details.php?id=<?= $product_id ?>" id="product-link-<?= $id ?>-<?= $product_id ?>">
                                    <p class="font-bold underline md:text-lg" id="product-name-<?= $id ?>-<?= $product_id ?>"><?= $row['name'] ?></p>
                                </a>
                                <p data-format="<?=$row['format']?>" data-unit="<?=$row['unit_of_measure']?>" id="product-format-<?= $id ?>-<?= $product_id ?>"><?= $row['format'] . " (" . $row['unit_of_measure'] . ")" ?></p>
                                <p id="product-qty-<?= $id ?>-<?= $product_id ?>">Qty: <?= $row['qty'] ?></p>
                                <p class="font-bold">
                                    <?php
                                    $price = $row['price'];
                                    $discount = $bundle['discount_value'];
                                    $discountType = $bundle['discount_type'];

                                    if ($discountType === 'price') {
                                        $discount = $discount/$totalRows;
                                        $final_price = $price - $discount;
                                    } elseif ($discountType === 'percentage') {
                                        $final_price = $price - ($price * ($discount / 100));
                                    } else {
                                        $final_price = $price;
                                    }
                                    ?>
                                    <span id="product-price-<?= $id ?>-<?= $product_id ?>">Rs.<?= $final_price ?></span>
                                    <span class="line-through text-gray-500 text-sm" id="product-original-price-<?= $id ?>-<?= $product_id ?>"><?= $price ?></span>
                                </p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <!-- Price And Details -->
            <div class="flex flex-col justify-center mt-5 gap-4">
                <p class="text-center font-bold text-lg" id="bundle-price-<?= $id ?>">
                    Total Price: Rs.<?= $bundle['discount_amount'] ?>
                    <span class="line-through text-gray-500 text-sm">Rs.<?= $bundle['total_amount'] ?></span>
                    <span class="font-bold text-red-500 text-balance">
                        Save Rs.<?= number_format($bundle['total_amount'] - $bundle['discount_amount'], 2) ?>
                    </span>
                </p>

                <div class="w-full p-3 text-center border-2 hover:cursor-pointer bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-xl transition-shadow ease-in-out duration-300 font-semibold rounded-full text-white" id="buynow-<?= $id ?>" data-bundle-id="<?= $id ?>">Buy It Now</div>
            </div>
        </div>
        <!-- Single Bundle End -->
    <?php
    }
    ?>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '[id^="buynow-"]', function() {
        const bundleId = $(this).data('bundle-id');
        const products = [];

        // Collect all products within the bundle
        $(`#bundle-${bundleId} .w-full.border-2`).each(function() {
            const productId = $(this).attr('id').split('-')[2];
            const format = $(`#product-format-${bundleId}-${productId}`).data('format');
            const unit = $(`#product-format-${bundleId}-${productId}`).data('unit');
            const quantity = $(`#product-qty-${bundleId}-${productId}`).text().split(': ')[1];
            const price = $(`#product-price-${bundleId}-${productId}`).text().replace('Rs.', '').trim();

            products.push({
                productId,
                format,
                unit,
                quantity,
                price,
            });
        });
        console.log(products);

        // Send AJAX requests for each product in the bundle
        products.forEach((product) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'manage_cart', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(`Product ${product.productId} added successfully`);
                }
            };

            xhr.send(
                `pid=${product.productId}&type=add&qty=${product.quantity}&format=${product.format}&price=${product.price}&unitOfMeasure=${product.unit}`
            );
        });

        // Redirect to checkout after all requests
        setTimeout(() => {
            window.location.href = 'checkout';
        }, 500);
    });
</script>



<?php
include "footer.php";
?>