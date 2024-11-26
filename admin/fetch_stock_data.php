<?php
include 'top.php';

$query = "SELECT ps.*, p.name, pf.format, pf.unit_of_measure FROM product_stock AS ps 
JOIN product AS p ON ps.product_id = p.id 
JOIN product_format AS pf ON ps.format_id = pf.id ORDER BY ps.date DESC";

$result = mysqli_query($con, $query);
$stocks = [];

while ($row = mysqli_fetch_assoc($result)) {
    $stocks[] = $row;
}

echo json_encode($stocks);
