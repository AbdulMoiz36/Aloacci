<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

/* Active-Deactive Status */

if(isset($_GET['type']) && $_GET['type']!=''){
   $type = get_safe_value($con,$_GET['type']);
   if($type=='status'){
      $operation = get_safe_value($con,$_GET['operation']);
      $id = get_safe_value($con,$_GET['id']);
      if($operation=='active'){
         $status = '1';
      }
      else{
         $status = '0';
      }

      $update_status = mysqli_query($con,"update admin_user set Status='$status' where id=$id");
   }
}

$select = "select * from admin_user where role_id!='1' order by id desc";
$res = mysqli_query($con,$select);

$serial_no = 1;
?>
<div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Staff</h4>
                    <a href="manage_panel_users">Add Members</a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                      <thead>
                                    <tr>
                                       <th>Serial No.</th>
                                       <th>Image</th>
                                       <th>User_Name</th>
                                       <th>Password</th>
                                       <th>Email</th>
                                       <th>Mobile</th>
                                       <th>Status</th>
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
                                    <tr>
                                       <td> <?= $serial_no++; ?></td>
                                       <td><img class="rounded-circle" src="./admin_users_images/<?= $row['image'] ?>" height="50" width="50" alt=""></td>
                                       <td> <?= $row['name'] ?> </td>
                                       <td> <?= $row['password'] ?> </td>
                                       <td> <?= $row['email'] ?> </td>
                                       <td> <?= $row['mobile'] ?> </td>
                                       <td>
                                       <?php
                                          if($row['status']=='1'){
                                             echo "<a href='?type=status&operation=deactive&id=".$row['id']."'><span class='btn btn-sm btn-success' data-toggle='tooltip' title='Deactive'>Active</sapn></a>";
                                          }
                                          else{
                                             echo "<a href='?type=status&operation=active&id=".$row['id']."'><span class='btn btn-sm btn-warning' data-toggle='tooltip' title='Active'>Deactive</sapn></a>";
                                          }
                                          ?>
                                       </td>
                                       <td>
                                       <a href="manage_panel_users?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit">
                                          <i class="fas fa-pencil-alt"></i>
                                       </a>
                                       <a href="panel_users_delete?id=<?= $row['id'] ?>" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"
                                          data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                          data-confirm-yes="alert('Deleted')">
                                          <i class="fas fa-trash-alt"></i>
                                       </a>
                                       </td>
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