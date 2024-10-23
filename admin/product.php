<?php
include "top.php";

/* Restrict employee to access this page */
isAdmin();

/* Active-Deactive status */
if(isset($_GET['type']) && $_GET['type']!=''){
   $type = get_safe_value($con,$_GET['type']);
   if($type=='status'){
      $operation = get_safe_value($con,$_GET['operation']);
      $id = get_safe_value($con,$_GET['id']);
      $status = ($operation == 'active') ? '1' : '0';
      $update_status = mysqli_query($con,"update product set status='$status' where id=$id");
   }
}

/* Modify query to use GROUP_CONCAT for format, price, and qty */
$select = "
    SELECT p.*, 
           IFNULL(c.categories, 'No Category') as categories, 
           GROUP_CONCAT(pf.format ORDER BY pf.id ASC SEPARATOR ', ') as formats,
           GROUP_CONCAT(pf.price ORDER BY pf.id ASC SEPARATOR ', ') as prices,
           GROUP_CONCAT(pf.qty ORDER BY pf.id ASC SEPARATOR ', ') as qtys
    FROM product p
    LEFT JOIN categories c ON p.Category_Id = c.id
    LEFT JOIN product_format pf ON p.id = pf.product_id
    GROUP BY p.id
    ORDER BY p.id DESC";

$res = mysqli_query($con, $select);

$serial_no = 1;
?>
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h4>Products</h4>
            <a href="manage_product">Add Product</a>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-striped" id="table-1">
                  <thead>
                     <tr>
                        <th>Serial No.</th>
                        <th>Categories</th>
                        <th>P_Name</th>
                        <th>Image</th>
                        <th>Formats</th>
                        <th>Prices</th>
                        <th>Stocks</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <?php if(mysqli_num_rows($res) > 0){ ?>
                  <tbody>
                     <?php while($row = mysqli_fetch_array($res)){ ?>
                     <tr>
                        <td> <?= $serial_no++; ?> </td>
                        <td> <?= $row['categories'] ?> </td>
                        <td> <?= $row['name'] ?> </td>
                        <td>
                           <?php
                           $mainImage = "../image/" . $row['image'];
                           $altImage1 = "../image/" . $row['image2']; // Assuming 'image_2' is the column name for the second image
                           $altImage2 = "../image/" . $row['image3']; // Assuming 'image_3' is the column name for the third image

                           if (file_exists($mainImage) && !empty($row['image'])) {
                              $imageToShow = $row['image'];
                           } elseif (file_exists($altImage1) && !empty($row['image2'])) {
                              $imageToShow = $row['image2'];
                           } elseif (file_exists($altImage2) && !empty($row['image3'])) {
                              $imageToShow = $row['image3'];
                           } else {
                              $imageToShow = "default.png"; // Optional: provide a default image if none are found
                           }
                           ?>
                           <img src="../image/<?= $imageToShow ?>" height="50" width="50" alt="">
                        </td>

                        <td> <?= str_replace(", ", "<br>", $row['formats']) ?> </td>
                        <td> <?= str_replace(", ", "<br>", $row['prices']) ?> </td>
                        <td>
                           <?php
                              $soldQtyByFormat = productSoldQtyByProductId($con, $row['id']);
                              $formats = explode(", ", $row['formats']);
                              $totalQtyByFormat = explode(", ", $row['qtys']); // Use 'qtys' for quantities
                              $pricesByFormat = explode(", ", $row['prices']); // Use 'prices' for prices
                              
                              foreach ($formats as $key => $format) {
                                 $totalQty = isset($totalQtyByFormat[$key]) ? (int)$totalQtyByFormat[$key] : 0;
                                 $soldQty = isset($soldQtyByFormat[$format]) ? (int)$soldQtyByFormat[$format] : 0;
                                 $remainingQty = $totalQty - $soldQty;
                                 $price = isset($pricesByFormat[$key]) ? $pricesByFormat[$key] : 'N/A'; // Handle price

                                 echo ($remainingQty > 0) ? "$remainingQty<br> " : "<span style='color: red;'>Out of Stock</span><br> ";

                              }
                           ?>
                        </td>

                        <td>
                           <?php if($row['status'] == '1'){ ?>
                           <a href='?type=status&operation=deactive&id=<?= $row['id'] ?>'>
                              <span class='btn btn-sm btn-success' data-toggle='tooltip' title='Deactive'>Active</span>
                           </a>
                           <?php } else { ?>
                           <a href='?type=status&operation=active&id=<?= $row['id'] ?>'>
                              <span class='btn btn-sm btn-warning' data-toggle='tooltip' title='Active'>Deactive</span>
                           </a>
                           <?php } ?>
                        </td>
                        <td>
                           <a href="manage_product?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1"
                              data-toggle="tooltip" title="Edit">
                              <i class="fas fa-pencil-alt"></i>
                           </a>
                           <a href="p_delete?id=<?= $row['id'] ?>" class="btn btn-danger btn-action"
                              data-toggle="tooltip" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                           </a>
                        </td>
                     </tr>
                     <?php } ?>
                  </tbody>
                  <?php } ?>
               </table>
            </div>
         </div>
      </div>
   </div>

   <?php include "footer.php"; ?>