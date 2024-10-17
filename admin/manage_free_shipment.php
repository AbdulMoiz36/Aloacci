<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$price = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
    $_id = get_safe_value($con,$_GET['id']);
    $res = mysqli_query($con,"select * from shipment where id=$_id");
 
    $check = mysqli_num_rows($res);
 
    if($check>0){
       $row = mysqli_fetch_assoc($res);
       $price = $row['price'];
    }
    else{
       echo "<script>window.location.href='shipment'</script>";
       die();
    }
 
 }

if(isset($_REQUEST['submit'])){
    $price = get_safe_value($con,$_REQUEST['price']);

    $res = mysqli_query($con,"SELECT * FROM shipment WHERE price='$price'");
   
    $check = mysqli_num_rows($res);

      if(isset($_GET['id']) && $_GET['id'] !=''){
         mysqli_query($con,"UPDATE shipment SET price='$price' WHERE id='$_id'");
       }
   
       echo "<script>window.location.href='shipment'</script>";
       die();
    
}

?>
<div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4>Manage Free Shipment</h4><span>Form</span>
               </div>
               <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="Price" class=" form-control-label">Add Price</label>
									<input type="text" name="price" placeholder="Enter Price" class="form-control" autofocus required value="<?= $price ?>">
								</div>
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-primary btn-block">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							</div>
					</form>
                </div>
            </div>

<?php
include "footer.php"
?>