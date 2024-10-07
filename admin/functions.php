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

function productSoldQtyByProductId($con, $pid) {
    // Query to fetch the sold quantities based on product ID and format
    $sql = "
        SELECT pf.format, SUM(od.qty) as sold_qty 
        FROM orders_detail od
        INNER JOIN orders o ON od.order_id = o.id
        INNER JOIN product_format pf ON od.product_id = pf.product_id
        WHERE od.product_id = $pid AND o.order_status != 4
        GROUP BY pf.format
    ";
    $res = mysqli_query($con, $sql);
    
    // Prepare an array to store sold quantities for each format
    $soldQtyByFormat = [];
    
    // Fetch all sold quantities format-wise and store them in the array
    while ($row = mysqli_fetch_assoc($res)) {
        $soldQtyByFormat[$row['format']] = $row['sold_qty'];
    }
    
    return $soldQtyByFormat;
}