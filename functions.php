<?php

function get_safe_value($con,$str){
    if($str!=''){
        $str = trim($str);
        return mysqli_real_escape_string($con,$str);
    }
}

function get_product($con,$limit='',$cat_id='',$product_id='',$search_str='', bool $getQuery=false){
    $sql = "select product.*,categories.Categories from product,categories where product.Status=1";
    if($cat_id !== "") {
        $sql.= " and Category_Id=$cat_id ";
    }
    if($product_id !== "") {
        $sql.= " and product.Id=$product_id";
    }
    
    $sql.= " and product.Category_Id=categories.Id ";

    if($search_str !== "") {
        $sql.= " and (product.Name like '%$search_str%' or product.Description like '%$search_str%' or categories.Categories like '%$search_str%')";
    }

    $sql.= " order by product.Id desc ";

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