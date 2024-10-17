<?php
include "config.php";
include "top.php";
$order_id=get_safe_value($con,$_GET['id']);
if(isset($_POST['update_order_status'])){
    $update_order_status=get_safe_value($con, $_POST['update_order_status']);
    mysqli_query($con,"update orders set order_status='$update_order_status' where id='$order_id'");
    echo "<script>window.location.href='index'</script>";
}

?>

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
                <th>Product</th>
                <th>Format</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Sub Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
        // Fetching order details
        $res = mysqli_query($con, "SELECT DISTINCT(orders_detail.id), orders_detail.*, product.image, product.name, orders.address, orders.city, orders.user_id FROM orders_detail JOIN product ON orders_detail.product_id = product.id JOIN orders ON orders_detail.order_id = orders.id WHERE orders_detail.order_id='$order_id'");

        $total_price = 0;

        // Fetching user information based on user_id
        $userInfo = mysqli_fetch_assoc(mysqli_query($con, "SELECT orders.*, orders.name AS oname, users.name AS uname, users.email FROM orders LEFT JOIN users ON orders.user_id = users.id WHERE orders.id='$order_id'"));

        // Determine the name based on user_id
        $name = ($userInfo['user_id'] == 0) ? $userInfo['oname'] : $userInfo['uname'];
        $email = $userInfo['email'];
        $mobile = $userInfo['mobile'];
        $address = $userInfo['address'];
        $city = $userInfo['city'];
        $shipping = $userInfo['shipping'];

        // Loop through order details to display them
        while ($row = mysqli_fetch_assoc($res)) {
            $total_price += ($row['qty'] * $row['price']);
              ?>
              <tr class="pb-0">
                <td><img src="../image/<?= htmlspecialchars($row['image']) ?>" height="50" width="50" alt="">
                  <?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['format']) ?></td>
                <td><?= htmlspecialchars($row['qty']) ?></td>
                <td><?= htmlspecialchars($row['price']) ?></td>
                <td><?= htmlspecialchars($row['qty'] * $row['price']) ?></td>
              </tr>
              <?php
                }
              ?>
              <tr>
                <td style="text-align: center;" colspan="4"><b>Shipping</b></td>
                <td><b><?= htmlspecialchars($shipping == 0 ? 'Free' : $shipping) ?></b></td>
              </tr>

              <tr>
                <td style="text-align: center;" colspan="4"><b>Total</b></td>
                <td><b><?= htmlspecialchars($total_price + $shipping) ?></b></td>
              </tr>
            </tbody>
          </table>
          <div style="color:black;" class="card-header">
            <h4>Name</h4>
            <?= htmlspecialchars($name) ?>
          </div>
          <?php if (!empty($email)) : ?>
          <div style="color:black;" class="card-header">
            <h4>Email</h4>
            <?= htmlspecialchars($email) ?>
          </div>
          <?php endif; ?>
          <div style="color:black;" class="card-header">
            <h4>Mobile</h4>
            <?= htmlspecialchars($mobile) ?>
          </div>
          <div style="color:black;" class="card-header">
            <h4>Address</h4>
            <?= htmlspecialchars($address) ?>, <?= htmlspecialchars($city) ?>
          </div>

          <div style="color:black" ; class="card-header">
            <h4>Order Status</h4>
            <?php
                        $order_status_arr=mysqli_fetch_assoc(mysqli_query($con,"select order_status.name from order_status,orders where orders.id='$order_id' and orders.order_status=order_status.id"));
                        ?>
            <b style="color:red"><?= $order_status_arr['name'] ?></b>
          </div>
          <form action="" method="post">
            <div class="card-body card-block">
              <div class="form-group">
                <select class="form-control" name="update_order_status">
                  <option selected disabled>Select Status</option>
                  <?php
                        $select = mysqli_query($con,"select * from order_status");
                        while($row = mysqli_fetch_array($select)){
                          if($row['id']==$category_id){
                            echo "<option selected value=".$row['id']."> ".$row['name']." </option>";
                          }
                          else{
                            echo "<option value=".$row['id']."> ".$row['name']." </option>";
                          }
                        }
                        ?>
                </select>
              </div>
              <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="payment-button-amount">Submit</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
include "footer.php";
?>