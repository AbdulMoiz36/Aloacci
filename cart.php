<?php
include 'header.php';
?>

<section class="px-2 py-5 md:px-32 md:py-10 w-full">
    <h1 class="text-4xl font-bold text-center">Cart</h1>
    <div class="flex flex-col md:flex-row mt-10">
        <div class="w-full md:w-4/6">
            <div class="flex gap-5 border-b border-slate-200 pb-3 p-10">
                <div class="w-1/6"><img src="./img/product-1.jpg" class="rounded-md" alt=""></div>
                <div class="w-5/6 flex flex-col justify-evenly">
                    <p class="font-bold text-lg">Product Name</p>
                    <p><span class="font-semibold">Format:</span>Perfume Spray (50ml)</p>
                    <!-- Quantity Selector -->
                    <div class="flex items-center">
                        <!-- Decrement Button -->
                        <button onclick="decrement()" class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300">-</button>
                        <!-- Quantity Input -->
                        <input id="quantity" type="number" min="1" value="1" class="w-16 text-center border border-gray-300 rounded-md py-1" />
                        <!-- Increment Button -->
                        <button onclick="increment()" class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300">+</button>
                    </div>
                    <div class="flex justify-between">
                        <p class="font-semibold underline cursor-pointer">Remove</p>
                        <p class="font-semibold text-lg">Rs.1,720</p>
                    </div>
                </div>
            </div>
        </div>
        <div class=" w-full md:w-2/6">
            <div class="bg-gray-100 p-10">
                <div class="flex justify-around text-wrap">
                    <p class="font-semibold text-xl">Subtotal:</p>
                    <p class="font-semibold text-xl">Rs.5,120</p>
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