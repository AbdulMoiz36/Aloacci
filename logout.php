<?php
require "config.php";
require "functions.php";

unset($_SESSION['USER_LOGIN']);
unset($_SESSION['USER_ID']);
unset($_SESSION['USER_NAME']);
echo "<script>window.location.href='index'</script>";
die();