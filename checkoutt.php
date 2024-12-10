<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    // The vulnerable query
    $userInput = $_POST['query'];
    $result = $con->query($userInput);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo "<pre>" . print_r($row, true) . "</pre>";
        }
    } else {
        echo "Error: " . $con->error;
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkoutt</title>
</head>
<body>
    <form method="POST">
        <input type="text" id="query" name="query">
        <button type="submit"></button>
    </form>
</body>
</html>
