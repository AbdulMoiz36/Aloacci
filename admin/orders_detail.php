<?php
include "config.php";
include "top.php";
$order_id=get_safe_value($con,$_GET['id']);
if(isset($_POST['update_order_status'])){
    $update_order_status=$_POST['update_order_status'];
    mysqli_query($con,"update orders set order_status='$update_order_status' where id='$order_id'");
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
                                        <th>Total Price</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                        $res=mysqli_query($con,"select distinct(orders_detail.id), orders_detail.*,product.image,product.name,orders.address,orders.city from orders_detail,product ,orders where orders_detail.order_id='$order_id' and orders_detail.product_id=product.id GROUP by orders_detail.id");
                                        $total_price=0;

                                        $userInfo=mysqli_fetch_assoc(mysqli_query($con,"select orders.*,users.name from orders,users where orders.id='$order_id' and orders.User_id=users.id"));

                                        $name=$userInfo['name'];
                                        $email=$userInfo['email'];
                                        $mobile=$userInfo['mobile'];
                                        $address=$userInfo['address'];
                                        $city=$userInfo['city'];
                                        while($row=mysqli_fetch_assoc($res)){
                                        $total_price=$total_price+($row['qty']*$row['price'])
                                    ?>
                                    <tr class=" pb-0">
                                       <td> <img src="../image/<?= $row['image'] ?>" height="50" width="50" alt=""> <?= $row['name'] ?> </td>
                                       <td><?= $row['format'] ?></td>
                                       <td> <?= $row['qty'] ?> </td>
                                       <td> <?= $row['price'] ?> </td>
                                       <td> <?= $row['qty']*$row['price'] ?> </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align: center"; colspan="4"><b>Total</b></td>
                                        <td><b><?= $total_price ?></b></td>
                                    </tr>
                                 </tbody>
                      </table>
                      <div style="color:black"; class="card-header">
                        <h4>Name</h4>
                        <?= $name ?>
                      </div>
                      <div style="color:black"; class="card-header">
                        <h4>Email</h4>
                        <?= $email ?>
                      </div>
                      <div style="color:black"; class="card-header">
                        <h4>Mobile</h4>
                        <?= $mobile ?>
                      </div>
                      <div style="color:black"; class="card-header">
                        <h4>Address</h4>
                        <?= $address ?>, <?= $city ?>
                      </div>
                      <div style="color:black"; class="card-header">
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