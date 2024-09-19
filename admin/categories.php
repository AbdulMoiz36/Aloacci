<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$select = "select * from categories";
$res = mysqli_query($con,$select);

?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Categories</h4>
        <a href="manage_categories.php">Add Category</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-1">
            <thead>
              <tr>
                <th>ID</th>
                <th>Categories</th>
                <th>Action</th>
                <th></th>
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
                <td> <?= $row['id'] ?> </td>
                <td> <?= $row['categories'] ?> </td>
                <td>

                  <a href="manage_categories.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1"
                    data-toggle="tooltip" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <a href="cat_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-action" data-toggle="tooltip"
                    title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                    data-confirm-yes="alert('Deleted')">
                    <i class="fas fa-trash-alt"></i>
                  </a>

                </td>
                <td></td>
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