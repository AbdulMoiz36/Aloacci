<?php
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMessage = trim($_POST['message']);
    $response = ['status' => false, 'message' => 'No matching perfume found.'];

    try {
        // Escape special characters in the user input
        $userMessageEscaped = mysqli_real_escape_string($con, $userMessage);

        // Query to check for original or impression names and fetch product details
        $query = "
            SELECT 
                impressions.original_name, 
                impressions.impression_name, 
                impressions.product_id, 
                product.name AS product_name, 
                product.image AS product_image
            FROM 
                impressions 
            LEFT JOIN 
                product 
            ON 
                impressions.product_id = product.id
            WHERE 
                impressions.original_name LIKE '%$userMessageEscaped%' OR 
                impressions.impression_name LIKE '%$userMessageEscaped%'
        ";

        $result = mysqli_query($con, $query);

        if (!$result) {
            throw new Exception('Query Error: ' . mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (stripos($row['original_name'], $userMessage) !== false) {
                    $response = [
                        'status' => true,
                        'message' => "Here is our impression of <b>{$row['original_name']}</b>.",
                        'product' => [
                            'id' => $row['product_id'],
                            'name' => $row['product_name'],
                            'image' => $row['product_image']
                        ]
                    ];
                    break;
                } elseif (stripos($row['impression_name'], $userMessage) !== false) {
                    $response = [
                        'status' => true,
                        'message' => "Found Impression: {$row['impression_name']} 
                            is an impression of {$row['original_name']}.",
                        'product' => [
                            'id' => $row['product_id'],
                            'name' => $row['product_name'],
                            'image' => $row['product_image']
                        ]
                    ];
                    break;
                }
            }
        }

        echo json_encode($response);
        exit;

    } catch (Exception $e) {
        echo json_encode(['status' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
?>
