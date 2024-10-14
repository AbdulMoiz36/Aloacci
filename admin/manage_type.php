<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$type = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
   $_id = get_safe_value($con,$_GET['id']);
   $res = mysqli_query($con,"select * from type where id=$_id");

   $check = mysqli_num_rows($res);

   if($check>0){
      $row = mysqli_fetch_assoc($res);
      $type = $row['type'];
   }
   else{
      header('Location: type');
      die();
   }

}

if(isset($_REQUEST['submit'])){
    $type = get_safe_value($con,$_REQUEST['type']);

    $res = mysqli_query($con,"select * from type where type='$type'");
   
   $check = mysqli_num_rows($res);

   if($check>0){
      if(isset($_GET['id']) && $_GET['id'] !=''){
         $getData = mysqli_fetch_assoc($res);
         if($_id==$getData['id']){
            
         }
         else{
            $msg = "Type Already Exist";
         }
      }
      else{
         $msg = "Type Already Exist";
      }
   }
   if($msg==''){

      if(isset($_GET['id']) && $_GET['id'] !=''){
         mysqli_query($con,"update type set type='$type' where id='$_id'");
       }
       else{
         mysqli_query($con,"insert into type (type) Value ('$type')");
       }
   
       echo "<script>window.location.href='type'</script>";
       die();
   }
    
}

?>
<div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4>Product Types</h4><span>Form</span>
               </div>
               <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="Category" class=" form-control-label">Add Type</label>
									<input type="text" name="type" placeholder="Enter Type Name" class="form-control" autofocus required value="<?= $type ?>">
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