<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userMessage = trim($_POST['message']);
    $response = ['status' => false, 'message' => 'No matching perfume found.'];

    // Escape special characters in the user input to prevent SQL injection
    $userMessageEscaped = mysqli_real_escape_string($con, $userMessage);

    // Query to check for original or impression names
    $query = "
        SELECT 
            original_name, 
            impression_name, 
            product_id 
        FROM 
            perfumes 
        WHERE 
            original_name LIKE '%$userMessageEscaped%' OR 
            impression_name LIKE '%$userMessageEscaped%'
    ";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (stripos($row['original_name'], $userMessage) !== false) {
                // Original perfume name found
                $response = [
                    'status' => true,
                    'message' => "Found Original Perfume: {$row['original_name']}. 
                        <a href='name.com/product_details?id={$row['product_id']}'>View Details</a>"
                ];
                break;
            } elseif (stripos($row['impression_name'], $userMessage) !== false) {
                // Impression name found
                $response = [
                    'status' => true,
                    'message' => "Found Impression: {$row['impression_name']} 
                        is an impression of {$row['original_name']}."
                ];
                break;
            }
        }
    }

    echo json_encode($response);
    exit;
}
?>
