<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$name = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
   $_id = get_safe_value($con,$_GET['id']);
   $res = mysqli_query($con,"select * from units_of_measure where id=$_id");

   $check = mysqli_num_rows($res);

   if($check>0){
      $row = mysqli_fetch_assoc($res);
      $name = $row['name'];
   }
   else{
      echo "<script>window.location.href='units'</script>";
      die();
   }

}

if(isset($_REQUEST['submit'])){
    $name = get_safe_value($con,$_REQUEST['name']);

    $res = mysqli_query($con,"select * from units_of_measure where name='$name'");
   
   $check = mysqli_num_rows($res);

   if($check>0){
      if(isset($_GET['id']) && $_GET['id'] !=''){
         $getData = mysqli_fetch_assoc($res);
         if($_id==$getData['id']){
            
         }
         else{
            $msg = "Unit Already Exist";
         }
      }
      else{
         $msg = "Unit Already Exist";
      }
   }
   if($msg==''){

      if(isset($_GET['id']) && $_GET['id'] !=''){
         mysqli_query($con,"update units_of_measure set name='$name' where id='$_id'");
       }
       else{
         mysqli_query($con,"insert into units_of_measure (name) Value ('$name')");
       }
   
       echo "<script>window.location.href='units'</script>";
       die();
   }
    
}

?>
<div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4>Units Of Measure</h4><span>Form</span>
               </div>
               <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="Category" class=" form-control-label">Add Units</label>
									<input type="text" name="name" placeholder="Enter Unit Name" class="form-control" autofocus required value="<?= $name ?>">
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