<?php

function get_safe_value($con,$str){
    if($str!=''){
        $str = trim($str);
        return mysqli_real_escape_string($con,$str);
    }
}

function isAdmin(){
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        echo "<script>window.location.href='login.php'</script>";
    }
    if($_SESSION['ADMIN_ROLE']!='admin'){
        echo "<script>window.location.href='order.php'</script>";
    }
}

function productSoldQtyByProductId($con,$pid){
	$sql="select sum(orders_detail.qty) as qty from orders_detail,orders where orders.id=orders_detail.order_id and orders_detail.product_id=$pid and orders.order_status!=4";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

?>