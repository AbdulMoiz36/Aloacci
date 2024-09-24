<?php
include 'header.php';
$product_id = mysqli_real_escape_string($con,$_GET['id']);

if($product_id>0){
    $get_product = get_product($con,'','',$product_id);
}
else{
    echo "<script>window.location.href='index.php'</script>";
}
// Check if the content is favorited by the user
$is_favorited = false;
if (isset($_SESSION['USER_LOGIN'])) {
    $user_id = $_SESSION['USER_ID'];
    $sql_check_favorite = mysqli_query($con, "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    if (mysqli_num_rows($sql_check_favorite) > 0) {
        $is_favorited = true;
    }
}
?>

<section class="container">
    <div class="flex flex-wrap p-2 md:p-10">
        <!-- Images Section -->
        <div class="w-100 md:w-1/2 flex gap-2">
            <!-- Thumbnail Images -->
            <div class="w-1/6 space-y-2">
                <img src="./image/<?= $get_product['0']['image'] ?>" alt="Thumbnail 1"
                    class="cursor-pointer border-2 border-slate-200" onclick="changeImage(this.src)">
                <img src="./image/<?= $get_product['0']['image'] ?>" alt="Thumbnail 2"
                    class="cursor-pointer border-2 border-slate-200" onclick="changeImage(this.src)">
            </div>
            <!-- Larger Image -->
            <div class="w-5/6">
                <img id="mainImage" src="./image/<?= $get_product['0']['image'] ?>" alt="Selected Product Image"
                    class="border-2 border-slate-200 max-h-[850px]">
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="w-full md:w-1/2 flex flex-col justify-center md:justify-start p-10 gap-6">
            <!-- Product Name And Total Reviews -->
            <div>
                <h1 class="font-bold text-3xl"><?= $get_product['0']['name'] ?></h1>
                <p class="">12 Reviews</p>
            </div>
            <!-- Options -->
            <div>
                <p class="font-semibold">Format:</p>
                <div class="border-2 border-black p-2 cursor-pointer w-fit my-2">
                    <p>Perfume Spray (50ml)</p>
                </div>
                <div class="border-2 border-black p-2 cursor-pointer w-fit my-2">
                    <p>Perfume Spray (100ml)</p>
                </div>
            </div>
            <!-- Price -->
            <div>
                <p class="font-semibold">Price:</p>
                <p class="text-xl font-semibold text-red-500">Rs.<?= $get_product['0']['price'] ?></p>
            </div>
            <!-- Stock -->
            <?php
                $productSoldQtyByProductId=productSoldQtyByProductId($con,$get_product['0']['id']);
                $cart_show='yes';
                if($get_product['0']['qty']>$productSoldQtyByProductId){
                    $stock='In Stock';
                }else{
                    $stock='Not in Stock';
                    $cart_show='';
                }
                ?>

            <div class="products--meta">
                <p>
                    <span>Availability:</span>
                    <?php
                if($cart_show!=''){
                ?>
                    <span class="mb-4"><?= $stock ?></span>
                    <?php
                }else{
                ?>
                    <span style="color:red;" class="mb-4"><?= $stock ?></span>
                    <?php
                }
                ?>
                </p>
            </div>
            <div>
                <p class="font-semibold">Quantity:</p>

                <form method="post">
                    <!-- Quantity Selector -->
                    <div class="flex items-center space-x-2">
                        <!-- Decrement Button -->
                        <span class="qty-minus"
                            onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) && qty > 1 ) effect.value--;return false;"><i
                                class="fa fa-minus" aria-hidden="true"></i></span>
                        <!-- Quantity Input -->
                        <input id="qty" style="border: none;" name="quantity" type="number" min="1" value="1"
                            class="w-16 text-center border border-gray-300 rounded-md py-1" />
                        <!-- Increment Button -->
                        <span class="qty-plus"
                            onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i
                                class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
            </div>
            <?php
                        if(!isset($_SESSION['USER_LOGIN'])){
                            ?>
            <div>
                <a href="login.php" style="padding:15px 250px 15px 255px;"
                    class="border-2 border-black text-lg font-semibold rounded-full mb-2">Add To Cart</a>
            </div>
            <?php
                        }
                        else{
                            ?>
            <a href="javascript:void(0)" onclick="manage_cart('<?= $get_product['0']['id']?>','add'); "
                style="padding:15px 250px 15px 255px;"
                class="border-2 border-black text-lg font-semibold rounded-full mb-2">Add To Cart</a>

            <?php
                        }
                        ?>
            </form>

            <div>
                <button
                    class="w-full p-3 border-2 border-red-800 text-lg font-semibold rounded-full bg-red-700 text-white">Buy
                    It Now</button>
            </div>
            <!-- Tabs -->
            <div>
                <div class="flex justify-evenly flex-wrap lg:flex-nowrap align-middle">
                    <button
                        class="tab-button font-semibold rounded-tl-lg text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black"
                        onclick="showTab('tab1')">Breif</button>
                    <button
                        class="tab-button font-semibold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black"
                        onclick="showTab('tab2')">Description</button>
                    <button
                        class="tab-button font-semibold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black"
                        onclick="showTab('tab3')">Performance</button>
                    <button
                        class="tab-button font-semibold text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black"
                        onclick="showTab('tab4')">Shipping</button>
                    <button
                        class="tab-button font-semibold rounded-tr-lg text-white bg-slate-900 p-3 w-full hover:bg-slate-200 hover:text-black"
                        onclick="showTab('tab5')">Unboxing Video</button>
                </div>

                <!-- Tab Content -->
                <div class="bg-white p-6 rounded-b-lg shadow-lg">
                    <div id="tab1" class="tab-content active">
                        <h2 class="text-xl font-semibold">Tab 1 Content</h2>
                        <p>This is the content for Tab 1.</p>
                    </div>

                    <div id="tab2" class="tab-content">
                        <h2 class="text-xl font-semibold">Tab 2 Content</h2>
                        <p>This is the content for Tab 2.</p>
                    </div>

                    <div id="tab3" class="tab-content">
                        <h2 class="text-xl font-semibold">Tab 3 Content</h2>
                        <p>This is the content for Tab 3.</p>
                    </div>

                    <div id="tab4" class="tab-content">
                        <h2 class="text-xl font-semibold">Tab 4 Content</h2>
                        <p>This is the content for Tab 4.</p>
                    </div>

                    <div id="tab5" class="tab-content">
                        <h2 class="text-xl font-semibold">Tab 5 Content</h2>
                        <p>This is the content for Tab 5.</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- Reviews -->
        <div class="w-full mt-20">
            <h2 class="text-center text-4xl mb-4 font-bold">Reviews</h2>
            <div class="flex flex-col">
                <div class="border-y border-slate-300 py-5">
                    <div class="flex flex-col gap-4">
                        <div class="flex gap-2">
                            <p class="font-semibold text-xl">User Name</p>
                            <p class="text-gray-500">1 Year Ago</p>
                        </div>
                        <div><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consequuntur facilis
                                nemo? Iure, dolorum molestias. Aperiam iusto nam necessitatibus, dolorum voluptas sed
                                vel consectetur possimus nulla! Unde odit nobis omnis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>