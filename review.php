<?php
include 'header.php';

// User must login first to access this page.//
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
} else {
    echo "<script>window.location.href='index.php'</script>";
    die();
}

// Initialize variables for form data
$name = '';
$email = '';
$message = '';
$rating = 0; // Initialize rating variable
$image_path = ''; // Initialize image path variable

// Check if the user is logged in and retrieve user details
if (isset($_SESSION['USER_ID'])) {
    $user_id = $_SESSION['USER_ID'];
    $sql = mysqli_query($con, "SELECT `email` FROM `users` WHERE `id` = '$user_id'");
    $user = mysqli_fetch_array($sql);
    $email = $user['email'];
}

$id = $_GET['id'];

$psql = mysqli_query($con, "SELECT `name` FROM `product` WHERE `id` = '$id'");
$product = mysqli_fetch_array($psql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from POST request
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $rating = $_POST['rating']; // Get the selected rating

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_path = 'uploads/' . basename($image_name); // Set the path to save the image

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            // Insert data into 'contact_us' table
            $sql = "INSERT INTO `contact_us` (`name`, `email`, `message`, `rating`, `image`, `date`) VALUES ('$name', '$email', '$message', '$rating', '$image_path', NOW())"; // Add image path to the query

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
        } else {
            // Error handling for image upload
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "There was an error uploading your image. Please try again later.",
                        confirmButtonText: "OK"
                    });
                  </script>';
        }
    }
}
?>

<section class="py-10 w-full flex justify-center align-middle">
    <div class="w-full md:w-3/6 shadow-lg p-8 flex flex-col justify-center border">
        <h1 class="text-4xl font-bold underline text-center">Review</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="mt-8 w-full flex justify-center">
            <div class="flex flex-col gap-8 py-8 w-full">
                <div class="flex flex-col gap-5">
                    <div>
                        <p class="text-xl text-gray-700">Product Name:</p>
                        <p class="text-lg ml-5">- <?=$product['name']?></p>
                    </div>
                    <div>
                        <p class="text-xl text-gray-700">User Email:</p>
                        <p class="text-lg ml-5">- <?=$email?></p>
                    </div>
                </div>

                <!-- Review Stars -->
                <div class="flex flex-col">
                    <label for="rating" class="text-xl">Rating:</label>
                    <div class="flex gap-1" id="rating-container">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>" class="hidden" />
                            <label for="star<?= $i ?>" class="cursor-pointer text-2xl text-gray-300 hover:text-amber-500 transition-colors duration-300">
                                <i class="fa-solid fa-star"></i>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="flex flex-col">
                    <label for="image" class="text-xl">Upload Image:</label>
                    <input type="file" name="image" id="image" accept="image/*" class="p-1 rounded-lg border" />
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

<!-- JavaScript to handle star rating selection -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#rating-container label');
        const hiddenInputs = document.querySelectorAll('input[name="rating"]');

        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                // Set the value of the corresponding hidden radio input
                hiddenInputs[index].checked = true;

                // Update star colors
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-amber-500');
                    } else {
                        s.classList.remove('text-amber-500');
                        s.classList.add('text-gray-300');
                    }
                });
            });
        });
    });
</script>

<?php
include 'footer.php';
?>
