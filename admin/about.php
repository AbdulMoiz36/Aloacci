<?php
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$select = "SELECT * FROM about";
$res = mysqli_query($con, $select);
$row = mysqli_fetch_assoc($res);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Manage About</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <th>About</th>
                <th></th>
                <th></th>
                <th>Image</th>
                <th>Action</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php if ($row) { ?>
                <tr class="pb-0">
                  <td></td>
                  <td style="width: 500px;"> <?= $row['about'] ?> </td>
                  <td></td>
                  <td></td>
                  <td><img src="../image/<?= $row['image'] ?>" height="50" width="50" alt=""></td>
                  <td>
                    <a href="manage_about?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1"
                       data-toggle="tooltip" title="Edit">
                      <i class="fas fa-pencil-alt"></i>
                    </a>
                  </td>
                  <td></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php
include "footer.php";
?>
