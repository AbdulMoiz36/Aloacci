<?php
include 'header.php';

// Initialize variables for form data
$name = '';
$email = '';
$message = '';

// Check if the user is logged in and retrieve user details
if (isset($_SESSION['USER_ID'])) {
    $user_id = $_SESSION['USER_ID'];
    $sql = mysqli_query($con, "SELECT `name`,`email` FROM `users` WHERE `id` = '$user_id'");
    $user = mysqli_fetch_array($sql);
    $name = $user['name'];
    $email = $user['email'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from POST request
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    
    // Insert data into 'contact_us' table
    $sql = "INSERT INTO `contact_us` (`name`, `email`, `message`, `date`) VALUES ('$name', '$email', '$message', NOW())";
    
    if (mysqli_query($con, $sql)) {
        // Success message using SweetAlert
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Message Sent!",
                    text: "Your message has been sent successfully!",
                    confirmButtonText: "OK"
                });
              </script>';
    } else {
        // Error handling using SweetAlert
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "There was an error sending your message. Please try again later.",
                    confirmButtonText: "OK"
                });
              </script>';
    }
}
?>

<section class="py-10 w-full flex justify-center align-middle">
    <div class="w-full md:w-4/6 shadow-lg p-8 flex flex-col justify-center border">
        <h1 class="text-4xl font-bold underline text-center">Contact Us</h1>
        <form action="" method="POST" class="mt-8 w-full flex justify-center">
            <div class="flex flex-col gap-8 py-8">
                <div class="flex gap-4">
                    <div class="flex flex-col">
                        <label for="name" class="text-xl">Name:</label>
                        <input type="text" name="name" value="<?=$name?>" class="p-1 rounded-lg border" required>
                    </div>
                    <div class="flex flex-col">
                        <label for="email" class="text-xl">Email:</label>
                        <input type="email" name="email" value="<?=$email?>" class="p-1 rounded-lg border" required>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label for="message" class="text-xl">Message:</label>
                    <textarea name="message" id="message" class="p-1 rounded-lg border" rows="8" required></textarea>
                </div>
                <button class="w-full p-3 border border-amber-500 text-lg font-semibold shadow-sm hover:shadow-lg transition-shadow ease-in-out duration-300 rounded-full bg-yellow-500 text-white">Submit</button>
            </div>
        </form>
    </div>
</section>

<?php
include 'footer.php';
?>
