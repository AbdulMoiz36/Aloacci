<?php

include "config.php";
include "functions.php";

/* Restrict employee to access this page */
isAdmin();


$_id=$_REQUEST['id'];

$delete = "delete from reviews where id=$_id";

$res = mysqli_query($con,$delete);

header('Location: review.php');

?>