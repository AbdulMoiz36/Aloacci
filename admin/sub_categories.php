<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$select = "select sub_categories.*,categories.categories from sub_categories,categories where sub_categories.category_id=categories.id order by sub_categories.id desc";
$res = mysqli_query($con, $select);
$serial_no = 1;
?>
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h4>Sub Categories</h4>
            <a href="manage_sub_categories">Add Sub Category</a>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-striped" id="table-1">
                  <thead>
                     <tr>
                        <th>Serial No.</th>
                        <th>Categories</th>
                        <th>Sub Categories</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <?php
                  if (mysqli_num_rows($res) > 0) {
                  ?>
                     <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($res)) {
                        ?>
                           <tr>
                              <td> <?= $serial_no++; ?></td>
                              <td> <?= $row['categories'] ?> </td>
                              <td> <?= $row['sub_categories'] ?> </td>
                              <td>
                                 <a href="manage_sub_categories?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                 </a>
                                 <a href="sub_categories_delete?id=<?= $row['id'] ?>" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"
                                    data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                    data-confirm-yes="alert('Deleted')">
                                    <i class="fas fa-trash-alt"></i>
                                 </a>
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