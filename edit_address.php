<?php
include "header.php";
// User must login first to access this page.//
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!=''){
}
else {
    echo "<script>window.location.href='index'</script>";
   die();
}
$user_id = $_SESSION['USER_ID'];
$sql = mysqli_query($con, "SELECT `address`, `city` FROM `users` WHERE `id` = '$user_id'");
$user = mysqli_fetch_assoc($sql);
?>

<section class="md:px-10 md:py-10 py-10 flex justify-center align-middle">
    <div class="p-5 md:p-10 md:w-4/6 w-full flex justify-center">
        <form method="post" class="flex flex-col justify-center gap-4">
            <h1 class="text-4xl font-bold mb-8 text-center underline">Edit Address</h1>
            
            <label for="" class="flex flex-col text-lg font-semibold">
                Address:
                <input type="text" name="address" class="border border-slate-400 rounded-md w-full p-2 mt-2 font-normal" value="<?= htmlspecialchars($user['address']) ?>" required/>
            </label>

            <label for="" class="flex flex-col text-lg font-semibold">
                City:
                <input type="text" name="city" class="border border-slate-400 rounded-md w-full p-2 mt-2 font-normal" value="<?= htmlspecialchars($user['city']) ?>" required/>
            </label>

            <!-- Change button type to 'submit' to trigger form submission -->
            <button type="submit" name="update" class="w-full p-2 border-2 hover:cursor-pointer bg-gradient-to-bl from-yellow-500 via-yellow-500 to-amber-600 shadow-sm hover:shadow-lg transition-shadow ease-in-out duration-300 font-semibold rounded-full mt-4 text-white">Update Address</button>
        </form>
    </div>
</section>

<?php
if (isset($_POST['update'])) {
    $address = trim(mysqli_real_escape_string($con, $_POST['address']));
    $city = trim(mysqli_real_escape_string($con, $_POST['city']));

    if (!empty($address) && !empty($city)) {
        // Update the user data in the database securely
        $update = mysqli_query($con, "UPDATE `users` SET `city`='$city', `address`='$address' WHERE `id` = '$user_id'");

        if ($update) {
            // Corrected JavaScript for redirection
            echo '<script>window.location.href = "account";</script>';
            exit(); 
        } 
    } 
}

include "footer.php";
?>
