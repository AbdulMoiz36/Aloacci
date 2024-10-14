<?php
include "config.php";
include "top.php";

$select = "select * from users order by id desc";
$res = mysqli_query($con,$select);

$serial_no = 1;

// Fetch total orders
$totalOrdersQuery = "SELECT COUNT(*) as total FROM orders";
$totalOrdersResult = mysqli_query($con, $totalOrdersQuery);
$totalOrders = mysqli_fetch_assoc($totalOrdersResult)['total'];

// Fetch completed orders
$completedOrdersQuery = "SELECT COUNT(*) as total FROM orders WHERE order_status = '5'";
$completedOrdersResult = mysqli_query($con, $completedOrdersQuery);
$completedOrders = mysqli_fetch_assoc($completedOrdersResult)['total'];

// Fetch pending orders
$pendingOrdersQuery = "SELECT COUNT(*) as total FROM orders WHERE order_status != '5'";
$pendingOrdersResult = mysqli_query($con, $pendingOrdersQuery);
$pendingOrders = mysqli_fetch_assoc($pendingOrdersResult)['total'];

// Fetch total users
$totalUsersQuery = "SELECT COUNT(*) as total FROM users";
$totalUsersResult = mysqli_query($con, $totalUsersQuery);
$totalUsers = mysqli_fetch_assoc($totalUsersResult)['total'];

?>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 card-primary">
            <div class="card-icon l-bg-purple">
                <i class="fas fa-cart-plus"></i>
            </div>
            <div class="card-wrap">
                <div class="padding-20">
                    <div class="text-right">
                        <h3 class="font-light mb-0">
                            <i class="ti-arrow-up text-success"></i> <?php echo $totalOrders; ?>
                        </h3>
                        <span class="text-muted">Total Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 card-primary">
            <div class="card-icon l-bg-purple">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
                <div class="padding-20">
                    <div class="text-right">
                        <h3 class="font-light mb-0">
                            <i class="ti-arrow-up text-success"></i> <?php echo $completedOrders; ?>
                        </h3>
                        <span class="text-muted">Complete Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 card-primary">
            <div class="card-icon l-bg-purple">
                <i class="fas fa-cart-arrow-down"></i>
            </div>
            <div class="card-wrap">
                <div class="padding-20">
                    <div class="text-right">
                        <h3 class="font-light mb-0">
                            <i class="ti-arrow-up text-success"></i> <?php echo $pendingOrders; ?>
                        </h3>
                        <span class="text-muted">Pending Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 card-primary">
            <div class="card-icon l-bg-green">
                <i class="fas fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="padding-20">
                    <div class="text-right">
                        <h3 class="font-light mb-0">
                            <i class="ti-arrow-up text-success"></i> <?php echo $totalUsers; ?>
                        </h3>
                        <span class="text-muted">Total Users</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Orders</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-1">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Order Date</th>
                <th>Address</th>
                <th>Order From</th>
                <th>Order Status</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $res = mysqli_query($con,"SELECT orders.*, order_status.Name as order_status_str 
                  FROM orders 
                  JOIN order_status ON order_status.id = orders.order_status 
                  ORDER BY orders.order_status, orders.date DESC, orders.id DESC");          
                  while($row=mysqli_fetch_assoc($res)){
                ?>
              <tr class=" pb-0">
                <td> <?= $serial_no++; ?> </td>
                <td> <?= $row['date'] ?> </td>
                <td style="text-transform: none">
                  <?= $row['address'] ?>
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
                  <span class='badge badge-warning'> <?= $row['order_status_str'] ?> </sapn>
                    <?php
                    }
                    elseif($row['order_status']=='2'){
                    ?>
                    <span class='badge badge-info'> <?= $row['order_status_str'] ?> </sapn>
                      <?php
                    }elseif($row['order_status']=='3'){
                    ?>
                      <span class='badge badge-secondary'> <?= $row['order_status_str'] ?> </sapn>
                        <?php
                    }elseif($row['order_status']=='4'){
                    ?>
                        <span class='badge badge-danger'> <?= $row['order_status_str'] ?> </sapn>
                          <?php
                    }else{
                    ?>
                          <span class='badge badge-success'> <?= $row['order_status_str'] ?> </sapn>
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