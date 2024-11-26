<?php
include 'config.php';

// Read the raw POST data (since it's sent as JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Get the product, format, and quantity from the decoded JSON
$product_id = $data['product'];
$format_id = $data['format'];
$quantity = $data['quantity'];

// Insert into the product_stock table
$query = "INSERT INTO product_stock (product_id, format_id, qty, date) VALUES ('$product_id', '$format_id', '$quantity', NOW())";

if (mysqli_query($con, $query)) {
    // Fetch the current quantity from the product_format table
    $select_format_qty = "SELECT qty FROM product_format WHERE id = '$format_id'";
    $result = mysqli_query($con, $select_format_qty);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_qty = $row['qty']; // Get the current quantity from the product_format table
        
        // Calculate the new quantity by adding the new stock quantity
        $new_qty = $current_qty + $quantity;
        
        // Update the product_format table with the new quantity
        $update_format_qty = "UPDATE product_format SET qty = '$new_qty' WHERE id = '$format_id'";
        
        if (mysqli_query($con, $update_format_qty)) {
            // Fetch the updated stock data
            $select = "SELECT ps.*, p.name, pf.format, pf.unit_of_measure 
                       FROM product_stock as ps 
                       JOIN product as p ON ps.product_id = p.id 
                       JOIN product_format as pf ON ps.format_id = pf.id 
                       ORDER BY ps.id DESC";
            
            $res = mysqli_query($con, $select);
            $stockData = [];

            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $stockData[] = $row;
                }
            }

            // Return updated stock data as a response
            $response = ['status' => 'success', 'data' => $stockData];
            echo json_encode($response);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update product format quantity']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to retrieve product format quantity']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add stock']);
}
?>
