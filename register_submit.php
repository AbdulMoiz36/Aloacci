<?php
require "config.php";
require "functions.php";

$name = get_safe_value($con, $_POST['name']);
$email = get_safe_value($con, $_POST['email']);
$mobile = get_safe_value($con, $_POST['mobile']);
$password = get_safe_value($con, $_POST['password']);

// Encrypt the password using md5
$encrypted_password = md5($password);

$check_user = mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));
if ($check_user > 0) {
    echo "exist";
} else {
    $added_on = date('Y-m-d H:i:s'); // use 'H' for 24-hour format
    $insert = mysqli_query($con, "INSERT INTO users(name, email, mobile, password, date) VALUES('$name', '$email', '$mobile', '$encrypted_password', '$added_on')");
    if ($insert) {
        echo "insert";
    }
}
?>
