<?php

include "config.php";
include "functions.php";

/* Restrict employee to access this page */
isAdmin();


$_id=$_REQUEST['id'];

$delete = "delete from cities where id=$_id";

$res = mysqli_query($con,$delete);

echo "<script>window.location.href='cities'</script>";