<?php
error_reporting(0);
session_start();
$con = mysqli_connect("localhost","root","","aloacci");

// Display error if failed to connect  
if ($con->connect_errno) {  
    printf("Connect failed: %s\n", $con->connect_error);  
    exit();  
}