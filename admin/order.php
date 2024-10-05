<?php
include "config.php";
include "top.php";

$select = "select * from users order by id desc";
$res = mysqli_query($con,$select);

$serial_no = 1;
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
                                      <th>Serial No.</th>
                                      <th>Order Date</th>
                                      <th>Address</th>
                                      <th>Order Status</th>
                                      <th>View</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $res=mysqli_query($con,"select orders.*,order_status.Name as order_status_str from orders,order_status where order_status.id=orders.order_status order by orders.date desc");
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
                                        <td> <a class="btn btn-icon btn-primary"data-toggle="tooltip"
                                        title="View" href="orders_detail.php?id=<?= $row['id'] ?>"><i class="fas fa-eye"></i></a> </td>
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