<?php   
function get_safe_value($con,$str){
    if($str!=''){
        $str = trim($str);
        return mysqli_real_escape_string($con,$str);
    }
}

function get_product($con, $limit = '', $cat_id = '', $product_id = '', $search_str = '', $getQuery = false, $sub_cat_id = '', $max_price = '', $sort = '') {
    $sql = "SELECT product.*, categories.categories, sub_categories.sub_categories, product_format.format, product_format.price,
            (SELECT MIN(product_format.price) FROM product_format WHERE product_format.product_id = product.id) AS min_price 
            FROM product 
            JOIN categories ON product.category_id = categories.id 
            LEFT JOIN sub_categories ON product.sub_category_id = sub_categories.id 
            LEFT JOIN product_format ON product.id = product_format.product_id 
            WHERE product.status = 1";

    // Apply category filter
    if ($cat_id !== "") {
        $sql .= " AND product.category_id = $cat_id ";
    }

    // Apply sub-category filter
    if ($sub_cat_id !== "") {
        $sql .= " AND product.sub_category_id = $sub_cat_id ";
    }

    // Apply max price filter
    if ($max_price !== "") {
        $sql .= " AND product_format.price < $max_price";
    }

    // Apply product ID filter
    if ($product_id !== "") {
        $sql .= " AND product.id = $product_id";
    }

    // Apply search string filter (including sub-categories)
    if ($search_str !== "") {
        $sql .= " AND (product.name LIKE '%$search_str%' 
                  OR product.description LIKE '%$search_str%' 
                  OR categories.categories LIKE '%$search_str%' 
                  OR sub_categories.sub_categories LIKE '%$search_str%')";
    }

    // Add sorting logic based on the sort parameter
    if ($sort === 'price_low_high') {
        $sql .= " ORDER BY min_price ASC"; // Sort by lowest price
    } elseif ($sort === 'price_high_low') {
        $sql .= " ORDER BY min_price DESC"; // Sort by highest price
    } elseif ($sort === 'newest') {
        $sql .= " ORDER BY product.id DESC"; // Sort by newest
    } elseif ($sort === 'a_to_z') {
        $sql .= " ORDER BY product.name ASC"; // Sort alphabetically A to Z
    } elseif ($sort === 'z_to_a') {
        $sql .= " ORDER BY product.name DESC"; // Sort alphabetically Z to A
    } else {
        $sql .= " ORDER BY product.id DESC"; // Default sorting by product ID
    }

    // Apply limit if set
    if ($limit !== '') {
        $sql .= " LIMIT $limit";
    }

    // Return SQL query if $getQuery is true
    if ($getQuery) {
        return $sql;
    }

    // Execute the query and fetch results
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