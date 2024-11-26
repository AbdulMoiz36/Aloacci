<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$lasting = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
   $_id = get_safe_value($con,$_GET['id']);
   $res = mysqli_query($con,"select * from lasting where id=$_id");

   $check = mysqli_num_rows($res);

   if($check>0){
      $row = mysqli_fetch_assoc($res);
      $lasting = $row['lasting'];
   }
   else{
      echo "<script>window.location.href='lasting'</script>";
      die();
   }

}

if(isset($_REQUEST['submit'])){
    $lasting = get_safe_value($con,$_REQUEST['lasting']);

    $res = mysqli_query($con,"select * from lasting where lasting='$lasting'");
   
   $check = mysqli_num_rows($res);

   if($check>0){
      if(isset($_GET['id']) && $_GET['id'] !=''){
         $getData = mysqli_fetch_assoc($res);
         if($_id==$getData['id']){
            
         }
         else{
            $msg = "lasting Already Exist";
         }
      }
      else{
         $msg = "lasting Already Exist";
      }
   }
   if($msg==''){

      if(isset($_GET['id']) && $_GET['id'] !=''){
         mysqli_query($con,"update lasting set lasting='$lasting' where id='$_id'");
       }
       else{
         mysqli_query($con,"insert into lasting (lasting) Value ('$lasting')");
       }
   
       echo "<script>window.location.href='lasting'</script>";
       die();
   }
    
}

?>
<div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4>lastings</h4><span>Form</span>
               </div>
               <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="Category" class=" form-control-label">Add lasting</label>
									<input type="text" name="lasting" placeholder="Enter lasting Name" class="form-control" autofocus required value="<?= $lasting ?>">
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