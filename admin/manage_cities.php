<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$cities = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
   $_id = get_safe_value($con,$_GET['id']);
   $res = mysqli_query($con,"select * from cities where id=$_id");

   $check = mysqli_num_rows($res);

   if($check>0){
      $row = mysqli_fetch_assoc($res);
      $cities = $row['cities'];
   }
   else{
      header('Location: cities');
      die();
   }

}

if(isset($_REQUEST['submit'])){
    $cities = get_safe_value($con,$_REQUEST['cities']);

    $res = mysqli_query($con,"select * from cities where cities='$cities'");
   
   $check = mysqli_num_rows($res);

   if($check>0){
      if(isset($_GET['id']) && $_GET['id'] !=''){
         $getData = mysqli_fetch_assoc($res);
         if($_id==$getData['id']){
            
         }
         else{
            $msg = "City Already Exist";
         }
      }
      else{
         $msg = "City Already Exist";
      }
   }
   if($msg==''){

      if(isset($_GET['id']) && $_GET['id'] !=''){
         mysqli_query($con,"update cities set cities='$cities' where id='$_id'");
       }
       else{
         mysqli_query($con,"insert into cities (cities) Value ('$cities')");
       }
   
       echo "<script>window.location.href='cities'</script>";
       die();
   }
    
}

?>
<div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4>Cities</h4><span>Form</span>
               </div>
               <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="City" class=" form-control-label">Add City</label>
									<input type="text" name="cities" placeholder="Enter City Name" class="form-control" autofocus required value="<?= $cities ?>">
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