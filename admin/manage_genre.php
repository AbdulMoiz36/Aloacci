<?php

include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$genre = '';
$msg = '';

if(isset($_GET['id']) && $_GET['id'] !=''){
   $_id = get_safe_value($con,$_GET['id']);
   $res = mysqli_query($con,"select * from genre where id=$_id");

   $check = mysqli_num_rows($res);

   if($check>0){
      $row = mysqli_fetch_assoc($res);
      $genre = $row['genre'];
   }
   else{
      header('Location: genre.php');
      die();
   }

}

if(isset($_REQUEST['submit'])){
    $genre = get_safe_value($con,$_REQUEST['genre']);

    $res = mysqli_query($con,"select * from genre where genre='$genre'");
   
   $check = mysqli_num_rows($res);

   if($check>0){
      if(isset($_GET['id']) && $_GET['id'] !=''){
         $getData = mysqli_fetch_assoc($res);
         if($_id==$getData['id']){
            
         }
         else{
            $msg = "Genre Already Exist";
         }
      }
      else{
         $msg = "Genre Already Exist";
      }
   }
   if($msg==''){

      if(isset($_GET['id']) && $_GET['id'] !=''){
         mysqli_query($con,"update genre set genre='$genre' where id='$_id'");
       }
       else{
         mysqli_query($con,"insert into genre (genre) Value ('$genre')");
       }
   
       echo "<script>window.location.href='genre.php'</script>";
       die();
   }
    
}

?>
<div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4>Genres</h4><span>Form</span>
               </div>
               <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="Category" class=" form-control-label">Add Genre</label>
									<input type="text" name="genre" placeholder="Enter Genre Name" class="form-control" autofocus required value="<?= $genre ?>">
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