<?php
include 'header.php';

// User must login first to access this page.
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
} else {
    echo "<script>window.location.href='index'</script>";
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

$pid = $_GET['pid'];
$oid = $_GET['oid'];
$format = $_GET['format']; // Capture the format from the URL

$psql = mysqli_query($con, "SELECT `name` FROM `product` WHERE `id` = '$pid'");
$product = mysqli_fetch_array($psql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $rating = $_POST['rating']; 

    // Handle multiple image uploads
    $image_filenames = []; // Array to store filenames of uploaded images
    $max_images = 5; // Limit the number of images to 5

    if (isset($_FILES['images'])) {
        $total_images = count($_FILES['images']['name']);

        if ($total_images > $max_images) {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Too many files!",
                        text: "You can upload a maximum of 5 images.",
                        confirmButtonText: "OK"
                    });
                  </script>';
        } else {
            for ($i = 0; $i < $total_images; $i++) {
                if ($_FILES['images']['error'][$i] == UPLOAD_ERR_OK) {
                    $image_tmp_name = $_FILES['images']['tmp_name'][$i];
                    $image_name = $_FILES['images']['name'][$i];
                    $image_path = './image/' . basename($image_name);

                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($image_tmp_name, $image_path)) {
                        $image_filenames[] = $image_name; // Store only the image filename
                    } else {
                        echo '<script>
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "There was an error uploading one or more images.",
                                    confirmButtonText: "OK"
                                });
                              </script>';
                    }
                }
            }

            // Insert review data into the database with image filenames and format
            if (!empty($image_filenames)) {
                $image_filenames_str = implode(',', $image_filenames); // Convert array to a string
                $sql = "INSERT INTO `reviews` (`order_id`, `product_id`, `format`, `comment`, `rating`, `image`, `date`) 
                        VALUES ('$oid', '$pid', '$format', '$message', '$rating', '$image_filenames_str', NOW())";

                if (mysqli_query($con, $sql)) {
                    echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Message Sent!",
                                text: "Your message has been sent successfully!",
                                confirmButtonText: "OK"
                            });
                          </script>';
                } else {
                    echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: "There was an error saving your review. Please try again later.",
                                confirmButtonText: "OK"
                            });
                          </script>';
                }
            }
        }
    }
}
?>

<section class="py-12 w-full flex justify-center items-center bg-gray-100">
    <div class="w-full md:w-2/5 lg:w-2/4 bg-white rounded-lg shadow-xl p-8 border border-gray-200">
        <h1 class="text-3xl font-semibold text-gray-800 text-center mb-6">Leave a Review</h1>
        <form action="" method="POST" enctype="multipart/form-data" class="w-full">
            <div class="flex flex-col gap-6">
                <!-- Product and User Info -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-lg text-gray-700 font-medium">Product Name: <span class="font-semibold"><?=$product['name']?></span></p>
                    <p class="text-lg text-gray-700 font-medium mt-2">User Email: <span class="font-semibold"><?=$email?></span></p>
                </div>

                <!-- Rating Section -->
                <div class="flex flex-col">
                    <label for="rating" class="text-lg font-medium text-gray-800 mb-2">Rating:</label>
                    <div class="flex gap-2" id="rating-container">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>" class="hidden" required>
                            <label for="star<?= $i ?>" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400 transition-colors duration-200">
                                <i class="fa-solid fa-star"></i>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Image Upload Section -->
                <div class="flex flex-col">
                    <label for="image" class="text-lg font-medium text-gray-800 mb-2">Upload Image:</label>
                    <p class="text-sm text-gray-500 mb-2">(You can upload up to 5 images)</p>
                    <input type="file" name="images[]" id="image" accept="image/*" class="border border-gray-300 p-2 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-400" multiple>
                </div>

                <!-- Message Section -->
                <div class="flex flex-col">
                    <label for="message" class="text-lg font-medium text-gray-800 mb-2">Message:</label>
                    <textarea name="message" id="message" class="border border-gray-300 p-3 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-400" rows="6" placeholder="Share your experience..." required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 bg-yellow-500 text-white font-semibold rounded-lg shadow-lg hover:bg-yellow-600 transition-all duration-300 ease-in-out focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2">
                    Submit Review
                </button>
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
