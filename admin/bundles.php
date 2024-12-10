<?php
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$select = "select * from bundles";
$res = mysqli_query($con,$select);

?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Bundles</h4>
        <a href="manage_bundle">Add Bundle</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="table-1">
            <thead>
              <tr>
                <th>Bundle No.</th>
                <th>Products</th>
                <th>Discount</th>
                <th>Final Amount</th>
                <th>Action</th>
                <th></th>
              </tr>
            </thead>
            <?php
              if(mysqli_num_rows($res) > 0){
            ?>
            <tbody>
              <?php
                while($row = mysqli_fetch_array($res)){
                  $bundle_id = $row['id'];
                  $fetch_products = mysqli_query($con,"SELECT p.name,pf.format,pf.unit_of_measure FROM bundle_details as bd JOIN product as p ON bd.product_id = p.id JOIN product_format as pf ON bd.format_id = pf.id WHERE bd.bundle_id = '$bundle_id'");
                  if($row['discount_type'] == 'price'){
                    $type = 'Rs';
                  }else{
                    $type = '%';
                  }
              ?>
              <tr class=" pb-0">
                <td><?= $row['id'] ?></td>
                <td>
                  <?php
                  while($products = mysqli_fetch_array($fetch_products)){
                    $name = $products['name'];
                    $format = $products['format'].$products['unit_of_measure'];
                    echo html_entity_decode($name.' '.'('.$format.')<br/>');
                  }
                  ?>
                </td>
                <td><?= $row['discount_value'].$type ?></td>
                <td><?= $row['discount_amount'] ?></td>
                <td>

                  <a href="manage_bundle?id=<?= $row['id'] ?>" class="btn btn-primary btn-action mr-1"
                    data-toggle="tooltip" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <a href="bundle_delete?id=<?= $row['id'] ?>" class="btn btn-danger btn-action" data-toggle="tooltip"
                    title="Delete">
                    <i class="fas fa-trash-alt"></i>
                  </a>

                </td>
                <td></td>
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