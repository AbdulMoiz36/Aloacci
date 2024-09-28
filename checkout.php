<?php
include 'header.php';
// User must login first to access this page.//
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!=''){
}
else {
    echo "<script>window.location.href='index.php'</script>";
   die();
}
$user_id = $_SESSION['USER_ID'];
$sql = mysqli_query($con,"SELECT `name`,`email`,`mobile`,`address`,`city` FROM `users` WHERE `id` = '$user_id'");
$data = mysqli_fetch_assoc($sql);
?>
<section class="flex justify-center py-10">
    <div class="w-full md:w-11/12 p-5 shadow-lg flex flex-col md:flex-row">
        <div class="w-full md:w-7/12 py-10 px-40">
            <h2 class="text-3xl font-bold">Delivery:</h2>
            <form action="" class="mt-5 flex flex-col gap-8">
                <div class="flex flex-col">
                    <label for="">Name:</label>
                    <input type="text" placeholder="Username" value="<?=$data['name']?>" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <div class="flex flex-col">
                    <label for="">Email:</label>
                    <input type="text" placeholder="Email" value="<?=$data['email']?>" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <div class="flex flex-col">
                    <label for="">City:</label>
                    <input type="text" placeholder="City" value="<?=$data['city']?>" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <div class="flex flex-col">
                    <label for="">Address:</label>
                    <input type="text" value="<?=$data['address']?>" placeholder="Address (Appartment Name/No., Street name, Area, Famous place)" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <div class="flex flex-col">
                    <label for="">Phone Number:</label>
                    <input type="text" placeholder="Phonenumber" value="<?=$data['mobile']?>" class="border placeholder:text-sm border-gray-300 rounded-md outline-none p-2">
                </div>
                <button class="bg-black hover:bg-slate-900 text-white p-5 rounded-md font-bold">Complete Order</button>
            </form>
        </div>
        <div class="w-full md:w-5/12 px-5 md:px-10 md:border-l border-slate-400 ">
            <!-- Products -->
            <div class="w-full">
                <!-- Card -->
                <div class="flex justify-between p-2 w-full border-b">
                    <div class="flex">
                        <div class="relative px-2 w-[70px] h-[70px]">
                            <!-- Fixed width and height for the image -->
                            <img src="./img/product-1.jpg" class="w-[70px] h-[70px]" alt="Product Image">
                            <p class="rounded-full bg-red-700 absolute -top-2 -right-2 text-sm px-2 py-1 text-white font-bold">4</p>
                        </div>
                        <div class="self-center ml-2">
                            <p class="self-center text-wrap">Product Name</p>
                            <p class="self-center text-sm text-slate-600">Format</p>
                        </div>
                    </div>
                    <div class="self-center text-wrap">
                        <p>Rs.5,670</p>
                    </div>
                </div>
                <!-- Card End -->
            </div>


            <!-- Total Area -->
            <div class="w-full mt-5">
                <div class="flex justify-between text-sm">
                    <p>Subtotal:</p>
                    <p>Rs.7890</p>
                </div>
                <div class="flex justify-between mt-2 text-sm">
                    <p>Shipping:</p>
                    <p>FREE</p>
                </div>
                <div class="flex justify-between mt-4 border-t p-5 text-lg ">
                    <p class="font-bold">Total:</p>
                    <p class="font-bold">Rs.7890</p>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
include 'footer.php'
?>