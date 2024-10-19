<?php
include 'header.php';
$select = "SELECT * FROM about";
$res = mysqli_query($con, $select);
$row = mysqli_fetch_assoc($res);
?>

<section>

<div id="about" class="relative bg-white overflow-hidden p-5 md:p-0 ">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100"></polygon>
            </svg>

            <div class="pt-1"></div>

            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h2 class="my-6 text-2xl tracking-tight font-extrabold text-gray-900 sm:text-3xl md:text-4xl">
                        About Us
                    </h2>

                    <p class="mr-5">
                    <?= $row['about'] ?>
                    </p>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover object-center sm:h-72 md:h-96 lg:w-full lg:h-full" src="./image/<?= $row['image'] ?>" height="50" width="50" alt="">
    </div>
</div>

</section>

<?php
include 'footer.php'
?>