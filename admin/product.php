<?php
include "config.php";
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

$select = "
    SELECT p.*, c.categories, 
           GROUP_CONCAT(pf.format ORDER BY pf.id ASC SEPARATOR ', ') as formats,
           GROUP_CONCAT(pf.price ORDER BY pf.id ASC SEPARATOR ', ') as prices
    FROM product p
    INNER JOIN categories c ON p.Category_Id = c.id
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
            <a href="manage_product.php">Add Product</a>
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
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <?php if(mysqli_num_rows($res) > 0){ ?>
                  <tbody>
                     <?php while($row = mysqli_fetch_array($res)){ ?>
                     <tr>
                        <td> <?= $serial_no++; ?></td>
                        <td> <?= $row['categories'] ?> </td>
                        <td> <?= $row['name'] ?> </td>
                        <td><img src="../image/<?= $row['image'] ?>" height="50" width="50" alt=""></td>
                        <td> <?= $row['formats'] ?> </td>
                        <td> <?= $row['prices'] ?> </td>
                        <td>
                           <?= $row['qty'] ?>/
                           <?php
                              $productSoldQtyByProductId = productSoldQtyByProductId($con, $row['id']);
                              $pending_qty = $row['qty'] - $productSoldQtyByProductId;
                           ?>
                           <?= $pending_qty ?>
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
                           <a href="manage_product.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
                              <i class="fas fa-pencil-alt"></i>
                           </a>
                           <a href="p_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')">
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
