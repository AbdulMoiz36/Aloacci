<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();


$select = "select * from feedback order by id desc";
$res = mysqli_query($con,$select);

?>

<div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Feedback</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                      <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Subject</th>
                                       <th>Feedback</th>
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
                                       <td> <?= $row['id'] ?> </td>
                                       <td> <?= $row['name'] ?> </td>
                                       <td style="text-transform: none"> <?= $row['email'] ?> </td>
                                       <td> <?= $row['subject'] ?> </td>
                                       <td> <?= $row['feedback'] ?> </td>
                                       <td> <?= $row['date'] ?> </td>
                                       <td>
                                       <a href="feedback_delete.php?id=<?= $row['id'] ?>" class="btn btn-icon btn-danger"><i class="fas fa-trash-alt"></i></a>
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