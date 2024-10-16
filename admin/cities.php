<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$select = "select * from cities";
$res = mysqli_query($con,$select);
$serial_no = 1;
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Cities</h4>
        <a href="manage_cities">Add City</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-1">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Cities</th>
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
                <td> <?= $row['cities'] ?> </td>
                <td>

                  <a href="manage_cities?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1"
                    data-toggle="tooltip" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <a href="cities_delete?id=<?= $row['id'] ?>" class="btn btn-danger btn-action" data-toggle="tooltip"
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