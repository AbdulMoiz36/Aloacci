<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$banner = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
   $_id = get_safe_value($con,$_GET['id']);
   $res = mysqli_query($con,"select * from banner where id=$_id");

   $check = mysqli_num_rows($res);

   if($check>0){
      $row = mysqli_fetch_assoc($res);
      $banner = $row['banner'];
   }
   else{
      echo "<script>window.location.href='banner'</script>";
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
            // Update existing banner
            if ($_FILES["image"]["name"] != '') {
                $image = $_FILES["image"]["name"];
                $tempname = $_FILES["image"]["tmp_name"];
                $folder = "../image/" . $image;
                move_uploaded_file($tempname, $folder);

            }
            mysqli_query($con, "UPDATE banner SET image='$image' WHERE id=$_id");
        }else{
            // Insert new banner
            $image = $_FILES["image"]["name"];
            $tempname = $_FILES["image"]["tmp_name"];
            $folder = "../image/" . $image;
            move_uploaded_file($tempname, $folder);

            mysqli_query($con, "INSERT INTO banner (`image`) VALUES ('$image')");
        }

        echo "<script>window.location.href='banner'</script>";
        die();
    }
}

?>

<div class="row">
    <div style="margin: auto;" class="col-6">
        <div class="card">
            <div class="card-header">
                <h4>Banner</h4><span>Form</span>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="card-body card-block">
                    <div class="form-row">


                        <div class="form-group col-12">
                            <label for="image" class="form-control-label">Image</label>
                            <small class="form-text text-muted">Please upload an image with dimensions 1920x600 pixels.</small>
                            <input type="file" name="image" class="form-control" required>
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

    <?php
    include "footer.php"
    ?>