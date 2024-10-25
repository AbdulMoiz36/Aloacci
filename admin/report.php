<?php
include "config.php";
include "top.php";

// Fetch filter values
$filter_date = isset($_GET['date']) ? $_GET['date'] : '';
$filter_mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
$filter_order_from = isset($_GET['order_from']) ? $_GET['order_from'] : '';
$filter_order_status = isset($_GET['order_status']) ? $_GET['order_status'] : '';

// Build query with filters
$query = "SELECT orders.*, order_status.Name as order_status_str 
          FROM orders 
          JOIN order_status ON order_status.id = orders.order_status 
          WHERE 1=1";

if ($filter_date != '') {
    $query .= " AND orders.date = '$filter_date'";
}
if ($filter_mobile != '') {
    $query .= " AND orders.mobile LIKE '%$filter_mobile%'";
}
if ($filter_order_from != '') {
    $query .= " AND orders.order_from = '$filter_order_from'";
}
if ($filter_order_status != '') {
    $query .= " AND orders.order_status = '$filter_order_status'";
}

$query .= " ORDER BY orders.order_status, orders.date DESC, orders.id DESC";
$res = mysqli_query($con, $query);

$serial_no = 1;
?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Orders</h4>
      </div>
      <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="">
          <div class="row">
            <div class="col-md-3">
              <input type="date" class="form-control" name="date" value="<?= $filter_date ?>" placeholder="Filter by Date">
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control" name="mobile" value="<?= $filter_mobile ?>" placeholder="Filter by Mobile">
            </div>
            <div class="col-md-3">
              <select class="form-control" name="order_from">
                <option value="">Filter by Order From</option>
                <option value="0" <?= ($filter_order_from === '0') ? 'selected' : '' ?>>Website</option>
                <option value="1" <?= ($filter_order_from === '1') ? 'selected' : '' ?>>Call</option>
              </select>
            </div>
            <div class="col-md-3">
              <select class="form-control" name="order_status">
                <option value="">Filter by Order Status</option>
                <option value="1" <?= ($filter_order_status === '1') ? 'selected' : '' ?>>Pending</option>
                <option value="2" <?= ($filter_order_status === '2') ? 'selected' : '' ?>>Processing</option>
                <option value="3" <?= ($filter_order_status === '3') ? 'selected' : '' ?>>Completed</option>
                <option value="4" <?= ($filter_order_status === '4') ? 'selected' : '' ?>>Canceled</option>
                <option value="5" <?= ($filter_order_status === '5') ? 'selected' : '' ?>>Delivered</option>
              </select>
            </div>
          </div>
          <br>
          <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <br>
        <!-- End Filter Form -->

        <div class="table-responsive">
          <table class="table table-striped" id="table-1">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Order Date</th>
                <th>Phone No.</th>
                <th>Order From</th>
                <th>Order Status</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              <?php          
                while($row=mysqli_fetch_assoc($res)){
                ?>
              <tr class=" pb-0">
                <td> <?= $serial_no++; ?> </td>
                <td> <?= $row['date'] ?> </td>
                <td style="text-transform: none">
                  <?= $row['mobile'] ?>
                </td>
                <td>
                  <?php 
                    if ($row['order_from'] == '0') {
                      echo "Website";
                    } else {
                      echo "Call";
                    }
                  ?>
                </td>

                <td>
                  <?php
                    if($row['order_status']=='1'){
                  ?>
                  <span class='badge badge-warning'> <?= $row['order_status_str'] ?> </span>
                    <?php
                    }
                    elseif($row['order_status']=='2'){
                    ?>
                    <span class='badge badge-info'> <?= $row['order_status_str'] ?> </span>
                      <?php
                    }elseif($row['order_status']=='3'){
                    ?>
                      <span class='badge badge-secondary'> <?= $row['order_status_str'] ?> </span>
                        <?php
                    }elseif($row['order_status']=='4'){
                    ?>
                        <span class='badge badge-danger'> <?= $row['order_status_str'] ?> </span>
                          <?php
                    }else{
                    ?>
                          <span class='badge badge-success'> <?= $row['order_status_str'] ?> </span>
                            <?php
                      }
                    ?>
                </td>
                <td> <a class="btn btn-icon btn-primary" data-toggle="tooltip" title="View"
                    href="orders_detail?id=<?= $row['id'] ?>"><i class="fas fa-eye"></i></a> </td>
              </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php
include "footer.php";
?>
