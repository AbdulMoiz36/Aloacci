<?php

include "config.php";
include "functions.php";

/* Restrict employee to access this page */
isAdmin();


$_id=$_REQUEST['id'];

$delete = "delete from bundles where id=$_id";
$res = mysqli_query($con,$delete);

$delete_products = "delete from bundle_details where bundle_id=$_id";
$res = mysqli_query($con,$delete_products);

if($res) {
    header("Location:bundles");
}
