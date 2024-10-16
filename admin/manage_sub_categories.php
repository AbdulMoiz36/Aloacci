<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$msg = '';
$category_id = '';
$sub_categories = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
	$image_required = '';
	$_id = get_safe_value($con,$_GET['id']);
	$res = mysqli_query($con,"select * from sub_categories where id=$_id");
 
	$check = mysqli_num_rows($res);
 
	if($check>0){
	   $row = mysqli_fetch_array($res);
	   $category_id = $row['category_id'];
	   $sub_categories = $row['sub_categories'];
	}
	else{
	   header('Location: sub_categories');
	   die();
	}
 
 }
 
 if(isset($_REQUEST['submit'])){
    $category_id = get_safe_value($con,$_REQUEST['categories_id']);
    $sub_categories = get_safe_value($con,$_REQUEST['sub_categories']);

    // Check if category_id is empty
    if(empty($category_id)){
        $msg = "Please Select a Category.";
    } else {
        $res = mysqli_query($con,"select * from sub_categories where category_id='$category_id' and sub_categories='$sub_categories'");
        
        $check = mysqli_num_rows($res);

        if($check > 0){
            if(isset($_GET['id']) && $_GET['id'] !=''){
                $getData = mysqli_fetch_assoc($res);
                if($_id == $getData['id']){
                    // No action needed
                } else {
                    $msg = "Sub Category Already Exists";
                }
            } else {
                $msg = "Sub Category Already Exists";
            }
        }

        if($msg == ''){
            if(isset($_GET['id']) && $_GET['id'] !=''){
                mysqli_query($con,"update sub_categories set category_id='$category_id', sub_categories='$sub_categories' where id='$_id'");
            } else {
                mysqli_query($con,"insert into sub_categories (category_id, sub_categories) Value ('$category_id', '$sub_categories')");
            }

            echo "<script>window.location.href='sub_categories'</script>";
            die();
        }
    }
}




?>

<div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4>Sub Categories</h4><span>Form</span>
               </div>
               <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label">Categories</label>
                                    <select class="form-control" name="categories_id">

									<option value="" selected disabled>Select Category</option>

									<?php

									$select = mysqli_query($con,"select * from categories");

									while($row = mysqli_fetch_array($select)){
										if($row['id']==$category_id){
											echo "<option selected value=".$row['id']."> ".$row['categories']." </option>";
										}
										else{
											echo "<option value=".$row['id']."> ".$row['categories']." </option>";
										}
									}

									?>

                                    </select>
                                    
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Sub Category Name</label>
									<input type="text" name="sub_categories" placeholder="Enter Sub Category Name" class="form-control" required value="<?= $sub_categories ?>">
								</div>
								
								
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