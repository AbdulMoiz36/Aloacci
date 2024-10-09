<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

$select = "SELECT reviews.*, product.image AS product_image 
           FROM reviews 
           JOIN product ON reviews.product_id = product.id";
if ($product_id > 0) {
  $select .= " WHERE product_id = $product_id";
}
$select .= " ORDER BY reviews.id DESC";

$res = mysqli_query($con, $select);

$serial_no = 1;
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
                    <h4>Reviews</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                      <thead>
                                    <tr>
                                       <th>Serial No.</th>
                                       <th>Product</th>
                                       <th>Ratings</th>
                                       <th>Comments</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <?php
                                 if(mysqli_num_rows($res) > 0){
                                 ?>
                                 <tbody>
                                    <?php
                                    while($row = mysqli_fetch_array($res)){
                                    ?>
                                    <tr class=" pb-0">
                                       <td> <?= $serial_no++; ?> </td>
                                       <td> <img src="../image/<?= $row['product_image'] ?>" height="50" width="50" alt="Product Image"> </td>
                                       <td>
                                        <?php for ($i=0; $i < round($row['rating']); $i++) { ?>
                                          <span class="star active">★</span>
                                        <?php } ?>
                                      </td>
                                       <td> <?= $row['comment'] ?> </td>
                                       <td>
                                        <a href="review_detail.php?id=<?= $row['id'] ?>" class="btn btn-icon btn-primary"><i class="fas fa-eye"></i></a>
                                        
                                        <a href="orders_detail.php?id=<?= $row['order_id'] ?>" class="btn btn-icon btn-info text-white"><i class="fas fa-box"></i></a>

                                        <a href="review_delete.php?id=<?= $row['id'] ?>" class="btn btn-icon btn-danger text-white"><i class="fas fa-trash-alt"></i></a>
                                       </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                 </tbody>
                                 <?php
                                 }
                                 ?>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

<?php
include "footer.php";
?>