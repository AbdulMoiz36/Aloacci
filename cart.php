<?php
include 'header.php';
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!=''){
}
else {
    echo "<script>window.location.href='index.php'</script>";
   die();
}
?>

<section class="px-2 py-5 md:px-32 md:py-10 w-full">
    <h1 class="text-4xl font-bold text-center">Cart</h1>
    <div class="flex flex-col md:flex-row mt-10">
        <div class="w-full md:w-4/6">
                <?php
						if(isset($_SESSION['cart'])){
							$cart_total=0;
							foreach($_SESSION['cart'] as $key=>$val){
							$productArr=get_product($con,'','',$key);
							$image=$productArr[0]['image'];
                            $pname=$productArr[0]['name'];
							$price=$productArr[0]['price'];
							$qty=$val['qty'];
                            $cart_total=$cart_total+($price*$qty);
						?>
            <div class="flex gap-5 border-b border-slate-200 pb-3 p-10">
                <div class="w-1/6"><img src="./image/<?= $image ?>" class="rounded-md" alt=""></div>
                <div class="w-5/6 flex flex-col justify-evenly">
                    <p class="font-bold text-lg"><?= $pname?></p>
                    <p><span class="font-semibold">Format:</span>Perfume Spray (50ml)</p>
                    <!-- Quantity Selector -->
                    <div class="flex items-center">
                        <!-- Decrement Button -->
                        <button onclick="decrement('<?= $key ?>')" class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300">-</button>

                        <!-- Quantity Input -->
                        <input id="quantity_<?= $key ?>" type="number" min="1" value="<?= $qty ?>" class="w-16 text-center border border-gray-300 rounded-md py-1" />

                        <!-- Increment Button -->
                        <button onclick="increment('<?= $key ?>')" class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300">+</button>
                        </div>
                    <div class="flex justify-between">
                        <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','remove')" class="font-semibold underline cursor-pointer">Remove</a>
                        <p class="font-semibold text-lg">Rs.<?= $price?></p>
                    </div>
                </div>
            </div>
                <?php
                            }
                        }
                        ?>
        </div>
        <div class=" w-full md:w-2/6">
            <div class="bg-gray-100 p-10">
                <div class="flex justify-around text-wrap">
                    <p class="font-semibold text-xl">Subtotal:</p>
                    <p class="font-semibold text-xl">Rs.<?= $cart_total ?></p>
                </div>
                <div class="mt-7">
                    <button class="w-full p-2 border-2 border-red-800 font-semibold rounded-full  bg-red-700 text-white">Checkout</button>
                </div>
                <div class="mt-7">
                    <p class="text-center text-sm">Taxes and Shipping calculated at checkout.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>