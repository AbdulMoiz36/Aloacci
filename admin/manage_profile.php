<?php

include "config.php";
include "top.php";

$msg = '';
$name = '';
$image = '';
$password = '';
$confirm_password = ''; // New variable for confirm password
$email = '';
$mobile = '';
$role_id = '';
$image_required = 'required';
$old_password = ''; // New variable for old password

if ($_SESSION['ADMIN_ROLE'] == "1") {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $image_required = '';
        $_id = get_safe_value($con, $_GET['id']);
        $res = mysqli_query($con, "select * from admin_user where id=$_id");

        $check = mysqli_num_rows($res);

        if ($check > 0) {
            $row = mysqli_fetch_array($res);
            $name = $row['name'];
            $old_password = $row['password']; // Store the old password for checking
            $email = $row['email'];
            $mobile = $row['mobile'];
            $role_id = $row['role_id'];
        } else {
            header('Location: profile');
            die();
        }
    }

    if (isset($_REQUEST['submit'])) {
        $name = get_safe_value($con, $_REQUEST['name']);
        $password = get_safe_value($con, $_REQUEST['password']);
        $confirm_password = get_safe_value($con, $_REQUEST['confirm_password']); // Get confirm password
        $email = get_safe_value($con, $_REQUEST['email']);
        $mobile = get_safe_value($con, $_REQUEST['mobile']);
        $role_id = get_safe_value($con, $_REQUEST['role_id']);
        $old_password_input = get_safe_value($con, $_REQUEST['old_password']); // Get old password input

        // Check if the entered old password matches the stored old password
        if (md5($old_password_input) !== $old_password) {
            $msg = "Old password is incorrect.";
        }

        // Check if passwords match
        if ($password !== $confirm_password) {
            $msg = "Passwords do not match.";
        }

        $res = mysqli_query($con, "select * from admin_user where email='$email' || mobile='$mobile'");
        $check = mysqli_num_rows($res);

        if ($check > 0) {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $getData = mysqli_fetch_assoc($res);
                if ($_id == $getData['id']) {
                    // No action needed, user exists
                } else {
                    $msg = "User Already Exist";
                }
            } else {
                $msg = "User Already Exist";
            }
        }

        if ($_FILES['image']['type'] != '' && ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/gif' && $_FILES['image']['type'] != 'image/bmp')) {
            $msg = "Please select only png, jpg or jpeg format";
        }

        if ($msg == '') {
            // Use md5 to hash the password before storing
            $hashed_password = md5($password);

            if (isset($_GET['id']) && $_GET['id'] != '') {
                if ($_FILES["image"]["name"] != '') {
                    $image = $_FILES["image"]["name"];
                    $tempname = $_FILES["image"]["tmp_name"];
                    $folder = "./admin_users_images/" . $image;
                    if (move_uploaded_file($tempname, $folder)) {
                        echo "";
                    } else {
                        echo "<h3>  Failed to upload image!</h3>";
                    }
                    $p_update = "update admin_user set name='$name', password='$hashed_password', email='$email', mobile='$mobile', role_id='$role_id', image='$image' where id='$_id'";
                } else {
                    $p_update = "update admin_user set name='$name', password='$hashed_password', email='$email', mobile='$mobile', role_id='$role_id' where id='$_id'";
                }
                mysqli_query($con, $p_update);
            } else {
                $image = $_FILES["image"]["name"];
                $tempname = $_FILES["image"]["tmp_name"];
                $folder = "./admin_users_images/" . $image;
                if (move_uploaded_file($tempname, $folder)) {
                    echo "";
                } else {
                    echo "<h3>  Failed to upload image!</h3>";
                }
                mysqli_query($con, "insert into admin_user (name, password, email, mobile, status, role_id, image) Value ('$name', '$hashed_password', '$email', '$mobile', '1', '$role_id', '$image')");
            }

            echo "<script>window.location.href='profile'</script>";
            die();
        }
    }
} else {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $image_required = '';
        $_id = get_safe_value($con, $_GET['id']);
        $res = mysqli_query($con, "select * from admin_user where id=$_id");

        $check = mysqli_num_rows($res);

        if ($check > 0) {
            $row = mysqli_fetch_array($res);
            $old_password = $row['password']; // Store the old password for checking
        } else {
            header('Location: profile');
            die();
        }
    }

    if (isset($_REQUEST['submit'])) {
        $old_password_input = get_safe_value($con, $_REQUEST['old_password']); // Get old password input
        $password = get_safe_value($con, $_REQUEST['password']);
        $confirm_password = get_safe_value($con, $_REQUEST['confirm_password']); // Get confirm password

        // Check if the entered old password matches the stored old password
        if (md5($old_password_input) !== $old_password) {
            $msg = "Old password is incorrect.";
        }

        // Check if passwords match
        if ($password !== $confirm_password) {
            $msg = "Passwords do not match.";
        }

        if ($_FILES['image']['type'] != '' && ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/gif' && $_FILES['image']['type'] != 'image/bmp')) {
            $msg = "Please select only png, jpg or jpeg format";
        }

        if ($msg == '') {
            // Use md5 to hash the password before updating
            $hashed_password = md5($password);

            if (isset($_GET['id']) && $_GET['id'] != '') {
                if ($_FILES["image"]["name"] != '') {
                    $image = $_FILES["image"]["name"];
                    $tempname = $_FILES["image"]["tmp_name"];
                    $folder = "./admin_users_images/" . $image;
                    if (move_uploaded_file($tempname, $folder)) {
                        echo "";
                    } else {
                        echo "<h3>  Failed to upload image!</h3>";
                    }
                    $pp_update = "update admin_user set password='$hashed_password', image='$image' where id='$_id'";
                } else {
                    $pp_update = "update admin_user set password='$hashed_password' where id='$_id'";
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
							if($_SESSION['ADMIN_ROLE']=='1'){
							?>

								<div class="form-group">
									<label for="categories" class=" form-control-label">name</label>
									<input type="text" name="name" placeholder="Enter name" class="form-control" required value="<?= $name ?>">
								</div>
							<?php
							}
							?>

                        		<div class="form-group">
									<label for="categories" class=" form-control-label">Image</label>
									<input type="file" name="image" class="form-control" <?= $image_required ?> >
								</div>
							<?php
							if($_SESSION['ADMIN_ROLE']=='1'){
							?>

                        		<div class="form-group">
									<label for="categories" class=" form-control-label">email</label>
									<input type="text" name="email" placeholder="Enter Email" class="form-control" required value="<?= $email ?>">
								</div>

                        		<div class="form-group">
									<label for="categories" class=" form-control-label">mobile</label>
									<input type="text" name="mobile" placeholder="Enter Mobile" class="form-control" required value="<?= $mobile ?>">
								</div>
							<?php
							}
							?>

<div class="form-group">
									<label for="old_password" class=" form-control-label">Old Password</label>
									<input type="text" name="old_password" placeholder="Enter Old Password" class="form-control" required>
								</div>
								
								<div class="form-group">
									<label for="password" class=" form-control-label">Password</label>
									<input type="text" name="password" placeholder="Enter Password" class="form-control" required>
								</div>

								<div class="form-group">
									<label for="confirm_password" class=" form-control-label">Confirm Password</label>
									<input type="text" name="confirm_password" placeholder="Confirm Password" class="form-control" required>
								</div>
							<?php
							if($_SESSION['ADMIN_ROLE']=='1'){
							?>

								<div class="form-group">
						<label for="role" class=" form-control-label">Role</label>
						<select class="form-control" name="role_id">

							<option value="" selected disabled>Select Role</option>

							<?php

									$select_role_id = mysqli_query($con,"select * from admin_role");

									while($role_row = mysqli_fetch_array($select_role_id)){
										if($role_row['id']==$role_id){
											echo "<option selected value=".$role_row['id']."> ".$role_row['role']." </option>";
										}
										else{
											echo "<option value=".$role_row['id']."> ".$role_row['role']." </option>";
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

<?php
include "footer.php"
?>