<?php

session_start();
require "config.php";
require "functions.php";
$msg = "";

/*------------------------------Multi User Login System------------------------------*/
if (isset($_POST['login'])) {
    $admin = get_safe_value($con, $_POST['name']);
    $password = get_safe_value($con, $_POST['password']);
    
    // Hash the input password using md5
    $hashed_password = md5($password);
    
    $select = "SELECT * FROM admin_user WHERE name='$admin' AND password='$hashed_password'";
    $res = mysqli_query($con, $select);
    $count = mysqli_num_rows($res);
    
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($row['status'] == 0) {
            $msg = "Your Account is Deactivated";
        } else {
            $_SESSION['ADMIN_LOGIN'] = 'yes';
            $_SESSION['ADMIN_IMAGE'] = $row['image'];
            $_SESSION['ADMIN_ID'] = $row['id'];
            $_SESSION['ADMIN_USERNAME'] = $admin;
            $_SESSION['ADMIN_ROLE'] = $row['role_id'];
            header('Location: index');
            die();
        }
    } else {
        $msg = "Please enter correct login details";
    }
}

/*------------------------------Restrict to login if already login------------------------------*/
if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] == 'yes') {
    header('Location: index');
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='../img/logo-cropped-bottom.png' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="user">User Name</label>
                    <input type="text" id="" class="form-control" name="name" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your user name
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="text-center" style="color:red">
                     <?= $msg ?>
                  </div><br>
                  <div class="form-group">
                    <button name="login" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
</html>