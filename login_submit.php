<?php
require "config.php";
require "functions.php";

$l_email = get_safe_value($con, $_POST['email']);
$l_password = get_safe_value($con, $_POST['password']);

// Encrypt the login password using md5
$encrypted_password = md5($l_password);

$res = mysqli_query($con, "SELECT * FROM users WHERE BINARY email='$l_email' AND password='$encrypted_password'");
$check_user = mysqli_num_rows($res);
if ($check_user > 0) {
    $row = mysqli_fetch_assoc($res);
    $_SESSION['USER_LOGIN'] = 'yes';
    $_SESSION['USER_ID'] = $row['id'];
    $_SESSION['USER_NAME'] = $row['name'];
    echo "valid";
} else {
    echo "wrong";
}
?>
