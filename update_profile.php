<?php
require "config.php";
require "functions.php";

// have to login first//
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!=''){
}
else {
    echo "<script>window.location.href='index'</script>";
   die();
}

$id = $_SESSION['USER_ID'];
$p_name=get_safe_value($con,$_POST['p_name']);
$p_email=get_safe_value($con,$_POST['p_email']);
$p_mobile=get_safe_value($con,$_POST['p_mobile']);


$p_update = mysqli_query($con,"UPDATE users SET `name`='$p_name', `email`='$p_email', `mobile`='$p_mobile' WHERE id='$id'");
if($p_update){
    echo 'updated';
}else{
    echo "Error: " . mysqli_error($con);
}