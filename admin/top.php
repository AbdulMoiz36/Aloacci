<?php

session_start();
require "config.php";
require "functions.php";

$active = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1);

/*------------------------------Force to login first------------------------------*/
if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){

}
else {
   header('Location: login');
   die();
}

$select = "select * from admin_user where admin_user.id='".$_SESSION['ADMIN_ID']."'";
$res = mysqli_query($con,$select);
$row = mysqli_fetch_array($res);

?>
<!DOCTYPE html>
<html lang="en">


<!-- datatables.html  21 Nov 2019 03:55:21 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Aloacci - Admin Dashboard</title>
  <link rel='shortcut icon' type='image/x-icon' href='../img/logo-cropped-bottom.png' />
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
          </ul>
        </div>
        <div class="dropdown-title" style="text-transform: capitalize;">Hi! <?= $_SESSION['ADMIN_USERNAME']; ?></div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="./admin_users_images/<?= $row['image'] ?>" class="user-img-radious-style">
              <span class="d-sm-none d-lg-inline-block"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title"><?= $_SESSION['ADMIN_USERNAME']; ?></div>
              <a href="profile" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="categories"> <img alt="image" src="../img/logo-cropped-bottom.png" class="header-logo" /> <span
                class="logo-name">Aloacci</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Ecommerce</li>
            <?php
            if($_SESSION['ADMIN_ROLE']=='1'){
            ?>
            <li class="dropdown <?= $active=="create_order.php"? 'active':''; ?>">
              <a href="create_order" class="nav-link"><i data-feather="monitor"></i><span>Create Order</span></a>
            </li>
            <li class="dropdown <?= $active=="banner.php" || $active == "manage_banner.php"? 'active':''; ?>">
              <a href="banner" class="nav-link"><i data-feather="monitor"></i><span>Banners</span></a>
            </li>
            <li class="dropdown <?= $active=="categories.php" || $active == "manage_categories.php"? 'active':''; ?>">
              <a href="categories" class="nav-link"><i data-feather="monitor"></i><span>Categories</span></a>
            </li>
            <li class="dropdown <?= $active=="sub_categories.php" || $active == "manage_sub_categories.php"? 'active':''; ?>">
              <a href="sub_categories" class="nav-link"><i data-feather="monitor"></i><span>Sub Categories</span></a>
            </li>
            <li class="dropdown <?= $active=="genre.php" || $active == "manage_genre.php"? 'active':''; ?>">
              <a href="genre" class="nav-link"><i data-feather="monitor"></i><span>Genre</span></a>
            </li>
            <li class="dropdown <?= $active=="type.php" || $active == "manage_type.php"? 'active':''; ?>">
              <a href="type" class="nav-link"><i data-feather="monitor"></i><span>Product Types</span></a>
            </li>
            
            <li class="dropdown <?= $active=="product.php" || $active == "manage_product.php"? 'active':''; ?>">
              <a href="product" class="nav-link"><i data-feather="monitor"></i><span>Products</span></a>
            </li>
            <li class="dropdown <?= $active=="index.php" || $active == "orders_detail.php"? 'active':''; ?>">
              <a href="index" class="nav-link"><i data-feather="monitor"></i><span>Orders</span></a>
            </li>
            <li class="dropdown <?= $active=="users.php"? 'active':''; ?>">
              <a href="users" class="nav-link"><i data-feather="monitor"></i><span>Users</span></a>
            </li>
            <li class="dropdown <?= $active=="contact_us.php"? 'active':''; ?>">
              <a href="contact_us" class="nav-link"><i data-feather="monitor"></i><span>Contact Us</span></a>
            </li>
            <li class="dropdown <?= $active=="review.php" || $active == "review_detail.php"? 'active':''; ?>">
              <a href="review" class="nav-link"><i data-feather="monitor"></i><span>Review</span></a>
            </li>
            <li class="menu-header">Admin Users</li>
            <li class="dropdown <?= $active=="panel_users.php" || $active == "manage_panel_users.php"? 'active':''; ?>">
              <a href="panel_users" class="nav-link"><i data-feather="monitor"></i><span>Staff</span></a>
            </li>
            <?php
            }else{
            ?>
            <li class="dropdown <?= $active=="index.php"? 'active':''; ?>">
              <a href="index" class="nav-link"><i data-feather="monitor"></i><span>Orders</span></a>
            </li>
            <?php
            }
            ?>
          </ul>
        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">