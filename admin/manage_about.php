<?php
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$about = '';
$msg = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $_id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "select * from about where id='$_id'");

    $check = mysqli_num_rows($res);

    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $about = $row['image'];
    } else {
        echo "<script>window.location.href='about'</script>";
        die();
    }
}

if (isset($_REQUEST['submit'])) {

    $maxFileSize = 5 * 1024 * 1024; // Maximum file size of 2MB
    $allowedFileTypes = ['image/png', 'image/jpg', 'image/jpeg'];

    // Check if an image is uploaded
    if ($_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Validate file type
        if (!in_array($_FILES['image']['type'], $allowedFileTypes)) {
            $msg = "Please select only PNG, JPG, or JPEG format.";
        }

        // Validate file size
        if ($_FILES['image']['size'] > $maxFileSize) {
            $msg = "File size exceeds 5MB limit.";
        }

        // Validate image dimensions
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageDetails = getimagesize($_FILES['image']['tmp_name']);
            if ($imageDetails === false) {
                $msg = "The file is not a valid image.";
            } else {
                $width = $imageDetails[0];
                $height = $imageDetails[1];
                // Check if dimensions are 1920x600
                if ($width !== 1920 || $height !== 600) {
                    $msg = "Image dimensions must be 1920x600 pixels.";
                }
            }
        }
    }

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            // Update existing about
            if ($_FILES["image"]["name"] != '') {
                $image = $_FILES["image"]["name"];
                $tempname = $_FILES["image"]["tmp_name"];
                $folder = "../image/" . $image;
                move_uploaded_file($tempname, $folder);
            }
            mysqli_query($con, "UPDATE about SET image='$image' WHERE id=$_id");
        }

        echo "<script>window.location.href='about'</script>";
        die();
    }
}

?>

<div class="row">
    <div style="margin: auto;" class="col-10">
        <div class="card">
            <div class="card-header">
                <h4>About</h4><span>Form</span>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="card-body card-block">
                    <div class="form-row">


                        <div class="form-group col-6">
                            <label for="image" class="form-control-label">Image</label>
                            <small class="form-text text-muted">Please upload an image with dimensions 1920x600 pixels.</small>
                            <input type="file" name="image" class="form-control" id="image" onchange="validateImageSize('image', 'imagePreview', 'imagePreviewContainer')" required>
                        </div>
                        <div class="form-group col-6" style="display: flex;justify-content: space-around;">
                            <div id="imagePreviewContainer" class="mb-4" style="display:none;">
                            <p>Selected Image:</p>    
                            <img id="imagePreview" src="#" alt="Selected Image 2" style="max-width: 150px; max-height: 150px;" class="border" />
                            </div>
                            <div style="display: <?= !empty($about) ? 'block' : 'none'; ?>;">
                                <p>Current Image:</p>    
                                <img src="<?= !empty($about) ? '../image/' . $about : '#'; ?>" alt="Current Image 1" style="max-width: 150px; max-height: 150px;" class="border" />
                            </div>
                        </div>

                        <button id="payment-button" name="submit" type="submit"
                            class="btn btn-lg btn-primary btn-block">
                            <span id="payment-button-amount">Upload</span>
                        </button>
                        <div style="color: red; margin-top: 10px;">
                            <?= $msg ?>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <!-- JS For Images  -->
    <script>
        function validateImageSize(inputId, imgId, containerId) {
            const fileInput = document.getElementById(inputId);
            const file = fileInput.files[0];

            if (file) {
                const img = new Image();
                img.onload = function() {
                    // Check if the image dimensions are 800x1200
                    if (img.width !== 1920 || img.height !== 600) {
                        alert('Image must be 800x1200 pixels in size.');
                        document.getElementById(containerId).style.display = 'none'; // Hide preview
                        fileInput.value = '';
                    } else {
                        previewImage(file, imgId, containerId); // Show preview if valid
                    }
                };

                img.src = URL.createObjectURL(file); // Create a URL for the image
            }
        }

        function previewImage(file, imgId, containerId) {
            const reader = new FileReader();

            // Load image preview
            reader.onload = function(e) {
                const img = document.getElementById(imgId);
                img.src = e.target.result;

                // Show the image preview container
                document.getElementById(containerId).style.display = 'block';
            };

            reader.readAsDataURL(file); // Convert file to base64 string
        }
    </script>

    <?php
    include "footer.php"
    ?>