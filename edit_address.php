<?php
include "header.php";
$user_id = $_SESSION['USER_ID'];
$sql = mysqli_query($con, "SELECT `address`, `city` FROM `users` WHERE `id` = '$user_id'");
$user = mysqli_fetch_assoc($sql);
?>

<section class="md:p-10 flex justify-center align-middle">
    <div class="shadow-xl p-5 md:p-10 md:w-4/6 w-full flex justify-center">
        <form method="post" class="flex flex-col justify-center gap-4">
            <h1 class="text-4xl font-bold mb-8 text-center underline">Edit Address</h1>
            
            <label for="" class="flex flex-col text-lg font-semibold">
                Address:
                <input type="text" name="address" class="border border-slate-400 rounded-md w-96 p-2 mt-2 font-normal" value="<?= htmlspecialchars($user['address']) ?>" />
            </label>

            <label for="" class="flex flex-col text-lg font-semibold">
                City:
                <input type="text" name="city" class="border border-slate-400 rounded-md w-96 p-2 mt-2 font-normal" value="<?= htmlspecialchars($user['city']) ?>" />
            </label>

            <!-- Change button type to 'submit' to trigger form submission -->
            <button type="submit" name="update" class="w-full p-2 border-2 hover:cursor-pointer border-red-800 hover:bg-red-900 font-semibold rounded-full mt-4 bg-red-700 text-white">Update Address</button>
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
            echo '<script>window.location.href = "account.php";</script>';
            exit(); 
        } 
    } 
}

include "footer.php";
?>
