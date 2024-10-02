<?php   
function get_safe_value($con,$str){
    if($str!=''){
        $str = trim($str);
        return mysqli_real_escape_string($con,$str);
    }
}

function get_product($con, $limit = '', $cat_id = '', $product_id = '', $search_str = '', $getQuery = false, $sub_cat_id = '') {
    $sql = "SELECT product.*, categories.categories, product_format.format, product_format.price 
            FROM product 
            JOIN categories ON product.category_id = categories.id 
            LEFT JOIN product_format ON product.id = product_format.product_id 
            WHERE product.status = 1";

    if ($cat_id !== "") {
        $sql .= " AND product.category_id = $cat_id ";
    }

    if ($sub_cat_id !== "") {
        $sql .= " AND product.sub_category_id = $sub_cat_id ";
    }

    if ($product_id !== "") {
        $sql .= " AND product.id = $product_id";
    }

    if ($search_str !== "") {
        $sql .= " AND (product.name LIKE '%$search_str%' OR product.description LIKE '%$search_str%' OR categories.categories LIKE '%$search_str%')";
    }

    $sql .= " ORDER BY product.id DESC ";

    if ($limit !== '') {
        $sql .= " LIMIT $limit";
    }

    if ($getQuery) {
        return $sql;
    }

    $res = mysqli_query($con, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    return $data;
}



function productSoldQtyByProductId($con,$pid){
	$sql="select sum(orders_detail.Qty) as qty from orders_detail,orders where orders.id=orders_detail.order_id and orders_detail.product_id=$pid and orders.order_status!=4";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

function productQty($con,$pid){
	$sql="select qty from product where id='$pid'";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}