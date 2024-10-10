<?php
include "config.php";
include "top.php";

/* Restrict employee to access this page */
isAdmin();

$select = "select * from banner";
$res = mysqli_query($con,$select);
?>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card-body">
      <div class="bootstrap snippet">
        <section id="portfolio" class="gray-bg padding-top-bottom">
          <!-- ======= Portfolio items ===-->
          <div class="projects-container scrollimation in">
            <div class="row">
              <article style="margin: auto;" class="col-md-4 col-sm-6 portfolio-item web-design apps psd">
                <?php
                                 if(mysqli_num_rows($res) > 0){
                                  while($row = mysqli_fetch_array($res)){
                                 ?>
                <div style="width: fit-content;" class="portfolio-thumb in">
                  <img class="img-responsive img-center" src="../image/<?= $row['image'] ?>" width="300px" alt="">
                  <span class="project-title">Banner</span>
                  <span class="overlay-mask"></span>
                  <a class="link centered" href="manage_banner.php?id=<?= $row['id'] ?>"><i
                      class="fa fa-pencil-alt fa-fw"></i></a>
                </div>
                <?php
                  }
                }
                ?>
              </article>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
<?php
include "footer.php";
?>