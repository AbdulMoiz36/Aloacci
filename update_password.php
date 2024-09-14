<?php
require "config.php";
require "functions.php";

// have to login first//
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!=''){
}
else {
    echo "<script>window.location.href='index.php'</script>";
   die();
}

$id = $_SESSION['USER_ID'];
$crnt_password=get_safe_value($con,$_POST['crnt_password']);
$new_password=get_safe_value($con,$_POST['new_password']);
$cf_password=get_safe_value($con,$_POST['cf_password']);

$res=mysqli_query($con,"select * from users where id='$id'");
$check_user=mysqli_num_rows($res);
if($check_user>0){
	$row=mysqli_fetch_assoc($res);
	if($crnt_password==$row['password']){
      $update = mysqli_query($con,"update users set password='$new_password' where id='$id'");
      echo "updated";
  }else{
    echo "wrong_password";
  }
}
?>