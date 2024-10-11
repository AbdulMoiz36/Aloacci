<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$review_id = get_safe_value($con, $_GET['id']);

$select = "SELECT * FROM reviews WHERE id = $review_id LIMIT 1";
$result = mysqli_query($con, $select);

$review = mysqli_fetch_assoc($result);

$product_id = 0;

if ($review) {
  $product_id = $review['product_id'];
} else {
  error_log("No review found for id: $review_id");
}


// get the User_id from the orders table
$query = "SELECT orders.user_id
  FROM reviews
  JOIN orders ON reviews.order_id = orders.id
  WHERE reviews.id = ?
";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $review_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$user_id = 0;

if ($row = mysqli_fetch_assoc($result)) {
  $user_id = $row['user_id'];
  // echo "User ID: " . $user_id;
} else {
  echo "No user found for the given review ID.";
}

?>
<style>
  .star {
    font-size: 1.3em;
    color: gold;
  }
</style>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Review Details</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Product</th>
                <th>Format</th>
                <th>Rating</th>
                <th>Images</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $select = "SELECT product.*, categories.Categories FROM product JOIN categories ON product.Category_id = categories.id WHERE product.id = '$product_id' ORDER BY product.id DESC;";
              $res = mysqli_query($con, $select);

              $userInfo=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM users WHERE id = '$user_id'"));

              $name=$userInfo['name'];
              $email=$userInfo['email'];
              $mobile=$userInfo['mobile'];
              $address=$userInfo['address'];
              $city=$userInfo['city'];
              if ($row = mysqli_fetch_assoc($res)) {
              ?>
              <tr class="pb-0">
                <td> <img src="../image/<?= $row['image'] ?>" height="50" width="50" alt=""> <?= $row['name'] ?> </td>
                <td><?= $review['format'] ?></td>
                <td>
                  <?php for ($i=0; $i < round($review['rating']); $i++) { ?>
                  <span class="star active">★</span>
                  <?php } ?>
                </td>
                <td>
                  <?php 
                    // Assuming the images are stored as comma-separated values in the 'image' column
                    $images = explode(',', $review['image']); // Split images into an array
                    foreach ($images as $img) { 
                    // Display each image
                  ?>
                    <img src="../image/<?= trim($img) ?>" height="50" width="50" alt="">
                  <?php 
                    } 
                  ?>
                </td>
              </tr>
              <?php
              } else {
                // Handle case where no product is found
                echo "<tr><td colspan='4'>No product found</td></tr>";
              }
              ?>
            </tbody>
          </table>

          <div style="color:black" ; class="card-header">
            <h4>Name</h4>
            <?= $name ?>
          </div>
          <!-- <div style="color:black"; class="card-header">
                        <h4>Email</h4>
                        <?= $email ?>
                      </div>
                      <div style="color:black"; class="card-header">
                        <h4>Mobile</h4>
                        <?= $mobile ?>
                      </div>
                      <div style="color:black"; class="card-header">
                        <h4>Address</h4>
                        <?= $address ?>, <?= $city ?>, <?= $pincode ?>
                      </div> -->
          <div style="color:black" ; class="card-header">
            <h4>Review</h4>
            <?= $review['comment'] ?>
          </div>
          <div class="card-footer">
            <a href="orders_detail.php?id=<?= $review['order_id'] ?>" class="btn btn-icon btn-info text-white"><i
                class="fas fa-box"></i> Order</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include "footer.php";
  ?>