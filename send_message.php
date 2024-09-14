<?php

require "config.php";
// User must login first to access this page.//
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!=''){
}
else {
    echo "<script>window.location.href='index.php'</script>";
   die();
}
require "functions.php";
$name=get_safe_value($con,$_POST['name']);
$email=get_safe_value($con,$_POST['email']);
$subject=get_safe_value($con,$_POST['subject']);
$message=get_safe_value($con,$_POST['message']);
$date=date('y-m-d h:i:s');
mysqli_query($con,"insert into contact_us(name,email,subject,message,date)values('$name','$email','$subject','$message','$date')");
echo "Thank You";
?>