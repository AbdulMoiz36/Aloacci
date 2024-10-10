<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$msg = '';

if (isset($_REQUEST['submit'])) {

    // Image validation
    if ($_FILES['image']['type'] != '' && !in_array($_FILES['image']['type'], ['image/png', 'image/jpg', 'image/jpeg'])) {
        $msg = "Please select only png, jpg, or jpeg format";
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

            mysqli_query($con, "update banner set image='$image'");

        }

        echo "<script>window.location.href='banner.php'</script>";
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
                            <input type="file" name="image" class="form-control">
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