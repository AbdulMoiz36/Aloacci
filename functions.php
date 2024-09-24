<?php   
function get_safe_value($con,$str){
    if($str!=''){
        $str = trim($str);
        return mysqli_real_escape_string($con,$str);
    }
}

function get_product($con,$limit='',$cat_id='',$product_id='',$search_str='', bool $getQuery=false){
    $sql = "SELECT product.*,categories.categories FROM product,categories WHERE product.status=1";
    if($cat_id !== "") {
        $sql.= " and category_id=$cat_id ";
    }
    if($product_id !== "") {
        $sql.= " and product.id=$product_id";
    }
    
    $sql.= " and product.category_id=categories.id ";

    if($search_str !== "") {
        $sql.= " and (product.name like '%$search_str%' or product.description like '%$search_str%' or categories.categories like '%$search_str%')";
    }

    $sql.= " order by product.id desc ";

    if($limit !== '') {
		$sql.=" limit $limit";
	}

    if ($getQuery) {
        return $sql;
    }

    $res=mysqli_query($con,$sql);
    $data=array();
    while($row=mysqli_fetch_assoc($res)){
        $data[]=$row;
    }
    return $data;
}

function get_category($con, $limit='', $cat_id='', $search_str='', bool $getQuery=false) {
    $sql = "SELECT * FROM categories WHERE `status`=1";  // where 1=1 added to add more WHERE querie below

    if (!empty($cat_id)) {
        $sql .= " AND id = '".mysqli_real_escape_string($con, $cat_id)."'";
    }

    if (!empty($search_str)) {
        $search_str = mysqli_real_escape_string($con, $search_str);
        $sql .= " AND (name LIKE '%$search_str%' OR categories LIKE '%$search_str%')";
    }

    if (!empty($limit)) {
        $sql .= " LIMIT $limit";
    }

    if ($getQuery) {
        return $sql;
    }

    $res = mysqli_query($con, $sql);

    $categories = [];
    while ($row=mysqli_fetch_assoc($res)) {
        $categories[] = $row;
    }

    return $categories;
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