<?php
include "config.php";
include "top.php";

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

<?php
include "footer.php";
?>
