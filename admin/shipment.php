<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

/* Active-Deactive status */
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'status') {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        $status = ($operation == 'active') ? '1' : '0';
        $update_status = mysqli_query($con, "UPDATE shipment SET status='$status' WHERE id=$id");
    }
}

$select = "SELECT * FROM shipment";
$res = mysqli_query($con, $select);
$price = mysqli_fetch_array($res);
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Manage Free Shipment</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php if ($price) { // Check if the shipment exists ?>
              <tr class="pb-0">
                <td></td>
                <td><?= $price['price'] ?></td>
                <td>
                  <?php if ($price['status'] == '1') { ?>
                  <a href='?type=status&operation=deactive&id=<?= $price['id'] ?>'>
                    <span class='btn btn-sm btn-success' data-toggle='tooltip' title='Deactive'>Active</span>
                  </a>
                  <?php } else { ?>
                  <a href='?type=status&operation=active&id=<?= $price['id'] ?>'>
                    <span class='btn btn-sm btn-warning' data-toggle='tooltip' title='Active'>Deactive</span>
                  </a>
                  <?php } ?>
                </td>
                <td>
                  <a href="manage_free_shipment?id=<?= $price['id'] ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
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
