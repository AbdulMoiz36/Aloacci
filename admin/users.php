<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$select = "select * from users order by id desc";
$res = mysqli_query($con,$select);
$serial_no = 1;
?>
<div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Users</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                      <thead>
                                    <tr>
                                       <th>Serial No.</th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Mobile</th>
                                       <th>Date</th>
                                       <th>Action</th>
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
                                       <td style="text-transform: none"> <?= $row['email'] ?> </td>
                                       <td> <?= $row['mobile'] ?> </td>
                                       <td> <?= $row['date'] ?> </td>
                                       <?php
                                       if(isset($_SESSION['ADMIN_LOGIN'])){
                                       ?>
                                       <td>
                                       <a href="users_delete?id=<?= $row['id'] ?>" class="btn btn-icon btn-danger"><i class="fas fa-trash-alt"></i></a>
                                       </td>
                                       <?php
                                       }
                                       ?>
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