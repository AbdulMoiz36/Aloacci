<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$cat = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
   $_id = get_safe_value($con,$_GET['id']);
   $res = mysqli_query($con,"select * from categories where id=$_id");

   $check = mysqli_num_rows($res);

   if($check>0){
      $row = mysqli_fetch_assoc($res);
      $cat = $row['categories'];
   }
   else{
      header('Location: categories');
      die();
   }

}

if(isset($_REQUEST['submit'])){
    $cat = get_safe_value($con,$_REQUEST['cat']);

    $res = mysqli_query($con,"select * from categories where categories='$cat'");
   
   $check = mysqli_num_rows($res);

   if($check>0){
      if(isset($_GET['id']) && $_GET['id'] !=''){
         $getData = mysqli_fetch_assoc($res);
         if($_id==$getData['id']){
            
         }
         else{
            $msg = "Category Already Exist";
         }
      }
      else{
         $msg = "Category Already Exist";
      }
   }
   if($msg==''){

      if(isset($_GET['id']) && $_GET['id'] !=''){
         mysqli_query($con,"update categories set categories='$cat' where id='$_id'");
       }
       else{
         mysqli_query($con,"insert into categories (categories) Value ('$cat')");
       }
   
       echo "<script>window.location.href='categories'</script>";
       die();
   }
    
}

?>
<div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4>Categories</h4><span>Form</span>
               </div>
               <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="Category" class=" form-control-label">Add Category</label>
									<input type="text" name="cat" placeholder="Enter Category Name" class="form-control" autofocus required value="<?= $cat ?>">
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