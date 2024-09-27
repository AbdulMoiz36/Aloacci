<?php
include "header.php";

// have to login first//
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!=''){
}
else {
    echo "<script>window.location.href='index.php'</script>";
   die();
}
?>

<section class="container md:p-10 flex justify-center align-middle">
    <div class="shadow-xl p-5 md:p-10 md:w-11/12 w-full flex flex-col">
        <div class="flex justify-between w-full md:mb-3">
            <h2 class="text-3xl font-bold">My Account</h2>
            <a href="./logout.php"><p class="underline cursor-pointer font-semibold">Log out</p></a>
        </div>
        <div class="flex flex-col-reverse md:flex-row">
            <div class="w-8/12 pt-5 md:pt-0 md:p-5">
                <h1 class="text-2xl font-bold mb-5">Order History</h1>
                <p>You haven't placed orders yet.</p>
            </div>
            <div class="w-4/12 pt-5 md:pt-0 md:p-5 border-l-2 border-slate-200">
                <h1 class="text-2xl font-bold">Account Details</h1>
                <p class="font-semibold mb-2">Name</p>
                <p>Address</p>
                <button class="p-2 rounded-md text-white font-semibold bg-amber-500 mt-4">Edit Address</button>
            </div>
        </div>
    </div>
    </section>


<?php
include "footer.php";
?>