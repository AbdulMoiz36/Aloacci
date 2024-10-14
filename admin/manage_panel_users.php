<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$msg = '';
$name = '';
$image = '';
$password = '';
$email = '';
$mobile = '';
$role_id = '';
$image_required = 'required';

if ($_SESSION['ADMIN_ROLE'] == "1") {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $image_required = '';
        $_id = get_safe_value($con, $_GET['id']);
        $res = mysqli_query($con, "SELECT * FROM admin_user WHERE id=$_id");
        $check = mysqli_num_rows($res);

        if ($check > 0) {
            $row = mysqli_fetch_array($res);
            $name = $row['name'];
            $password = $row['password'];
            $email = $row['email'];
            $mobile = $row['mobile'];
            $role_id = $row['role_id'];
        } else {
            header('Location: panel_users');
            die();
        }
    }

    if (isset($_REQUEST['submit'])) {
        $name = get_safe_value($con, $_REQUEST['name']);
        $password = get_safe_value($con, $_REQUEST['password']);
        $email = get_safe_value($con, $_REQUEST['email']);
        $mobile = get_safe_value($con, $_REQUEST['mobile']);
        $role_id = get_safe_value($con, $_REQUEST['role_id']);

        // Check for existing user by email or mobile
        $res = mysqli_query($con, "SELECT * FROM admin_user WHERE email='$email' OR mobile='$mobile'");
        $check = mysqli_num_rows($res);

        if ($check > 0) {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $getData = mysqli_fetch_assoc($res);
                if ($_id == $getData['id']) {
                    // Do nothing, same user
                } else {
                    $msg = "User Already Exists";
                }
            } else {
                $msg = "User Already Exists";
            }
        }

        if ($_FILES['image']['type'] != '' && ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/gif' && $_FILES['image']['type'] != 'image/bmp')) {
            $msg = "Please select only png, jpg or jpeg format";
        }

        if ($msg == '') {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                // Update existing user
                if ($_FILES["image"]["name"] != '') {
                    $image = $_FILES["image"]["name"];
                    $tempname = $_FILES["image"]["tmp_name"];
                    $folder = "./admin_users_images/" . $image;
                    if (move_uploaded_file($tempname, $folder)) {
                        echo "";
                    } else {
                        echo "<h3> Failed to upload image!</h3>";
                    }
                    $p_update = "UPDATE admin_user SET name='$name', password='" . md5($password) . "', email='$email', mobile='$mobile', role_id='$role_id', image='$image' WHERE id='$_id'";
                } else {
                    $p_update = "UPDATE admin_user SET name='$name', password='" . md5($password) . "', email='$email', mobile='$mobile', role_id='$role_id' WHERE id='$_id'";
                }
                mysqli_query($con, $p_update);
            } else {
                // Add new user
                $image = $_FILES["image"]["name"];
                $tempname = $_FILES["image"]["tmp_name"];
                $folder = "./admin_users_images/" . $image;
                if (move_uploaded_file($tempname, $folder)) {
                    echo "";
                } else {
                    echo "<h3> Failed to upload image!</h3>";
                }
                mysqli_query($con, "INSERT INTO admin_user (name, password, email, mobile, status, role_id, image) VALUES ('$name', '" . md5($password) . "', '$email', '$mobile', '1', '$role_id', '$image')");
            }

            echo "<script>window.location.href='panel_users'</script>";
            die();
        }
    }
} else {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $image_required = '';
        $_id = get_safe_value($con, $_GET['id']);
        $res = mysqli_query($con, "SELECT * FROM admin_user WHERE id=$_id");
        $check = mysqli_num_rows($res);

        if ($check > 0) {
            $row = mysqli_fetch_array($res);
            $password = $row['password'];
        } else {
            header('Location: profile');
            die();
        }
    }

    if (isset($_REQUEST['submit'])) {
        $password = get_safe_value($con, $_REQUEST['password']);

        if ($_FILES['image']['type'] != '' && ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/gif' && $_FILES['image']['type'] != 'image/bmp')) {
            $msg = "Please select only png, jpg or jpeg format";
        }

        if ($msg == '') {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                // Update user password or image
                if ($_FILES["image"]["name"] != '') {
                    $image = $_FILES["image"]["name"];
                    $tempname = $_FILES["image"]["tmp_name"];
                    $folder = "./admin_users_images/" . $image;
                    if (move_uploaded_file($tempname, $folder)) {
                        echo "";
                    } else {
                        echo "<h3> Failed to upload image!</h3>";
                    }
                    $pp_update = "UPDATE admin_user SET password='" . md5($password) . "', image='$image' WHERE id='$_id'";
                } else {
                    $pp_update = "UPDATE admin_user SET password='" . md5($password) . "' WHERE id='$_id'";
                }
                mysqli_query($con, $pp_update);
            }

            echo "<script>window.location.href='profile'</script>";
            die();
        }
    }
}

?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Profile</h4><span>Form</span>
			</div>
			<form method="post" enctype="multipart/form-data">
				<div class="card-body card-block">

					<?php
                    if ($_SESSION['ADMIN_ROLE'] == '1') {
                    ?>

					<div class="form-group">
						<label for="categories" class=" form-control-label">Name</label>
						<input type="text" name="name" placeholder="Enter Name" class="form-control" required
							value="<?= $name ?>">
					</div>
					<?php
                    }
                    ?>

					<div class="form-group">
						<label for="categories" class=" form-control-label">Image</label>
						<input type="file" name="image" class="form-control" <?= $image_required ?>>
					</div>
					<?php
                    if ($_SESSION['ADMIN_ROLE'] == '1') {
                    ?>

					<div class="form-group">
						<label for="categories" class=" form-control-label">Email</label>
						<input type="text" name="email" placeholder="Enter Email" class="form-control" required
							value="<?= $email ?>">
					</div>

					<div class="form-group">
						<label for="categories" class=" form-control-label">Mobile</label>
						<input type="text" name="mobile" placeholder="Enter Mobile" class="form-control" required
							value="<?= $mobile ?>">
					</div>
					<?php
                    }
                    ?>

					<div class="form-group">
						<label for="categories" class=" form-control-label">Password</label>
						<input type="text" name="password" placeholder="Enter Password" class="form-control" required>
					</div>
					<?php
                    if ($_SESSION['ADMIN_ROLE'] == '1') {
                    ?>

					<div class="form-group">
						<label for="role" class=" form-control-label">Role</label>
						<select class="form-control" name="role_id">
							<option value="" selected disabled>Select Role</option>
							<?php
                            $select_role_id = mysqli_query($con, "SELECT * FROM admin_role");
                            while ($role_row = mysqli_fetch_array($select_role_id)) {
                                if ($role_row['id'] == $role_id) {
                                    echo "<option selected value=" . $role_row['id'] . "> " . $role_row['role'] . " </option>";
                                } else {
                                    echo "<option value=" . $role_row['id'] . "> " . $role_row['role'] . " </option>";
                                }
                            }
                            ?>
						</select>
					</div>
					<?php
                    }
                    ?>

					<button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-primary btn-block">
						<span id="payment-button-amount">Submit</span>
					</button>
					<div style="color: red; margin-top: 10px;">
						<?= $msg ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
include "footer.php"
?>