<?php
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$select = "select * from units_of_measure";
$res = mysqli_query($con,$select);
$serial_no = 1;
?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Units Of Measure</h4>
        <a href="manage_unit">Add Unit</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-1">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Units</th>
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
                <td> <?= $serial_no++; ?> </td>
                <td> <?= $row['name'] ?> </td>
                <td>

                  <a href="manage_unit?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1"
                    data-toggle="tooltip" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <a href="unit_delete?id=<?= $row['id'] ?>" class="btn btn-danger btn-action" data-toggle="tooltip"
                    title="Delete">
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