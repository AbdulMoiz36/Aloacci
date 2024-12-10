<?php

session_start();
require "config.php";
require "functions.php";

$active = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);

/*------------------------------Force to login first------------------------------*/
if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != '') {
} else {
  echo "<script>window.location.href='login'</script>";
  die();
}

$select = "select * from admin_user where admin_user.id='" . $_SESSION['ADMIN_ID'] . "'";
$res = mysqli_query($con, $select);
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
            <?php
            if ($_SESSION['ADMIN_ROLE'] == 1) {
            ?>
              <li class="menu-header">Order Management</li>
              <li class="dropdown <?= $active == "index.php" || $active == "orders_detail.php" ? 'active' : ''; ?>">
                <a href="index" class="nav-link"><i data-feather="truck"></i><span>Orders</span></a>
              </li>
              <li class="dropdown <?= $active == "create_order.php" ? 'active' : ''; ?>">
                <a href="create_order" class="nav-link"><i data-feather="clipboard"></i><span>Create Order</span></a>
              </li>
              <li class="menu-header">Product Management</li>
              <li class="dropdown <?= $active == "product.php" || $active == "manage_product.php" ? 'active' : ''; ?>">
                <a href="product" class="nav-link"><i data-feather="archive"></i><span>Products</span></a>
              </li>
              <li class="dropdown <?= $active == "stock.php" || $active == "manage_stock.php" ? 'active' : ''; ?>">
                <a href="stock" class="nav-link"><i data-feather="package"></i><span>Stocks</span></a>
              </li>
              <li class="dropdown <?= $active == "shipment.php" || $active == "manage_free_shipment.php" ? 'active' : ''; ?>">
                <a href="shipment" class="nav-link"><i data-feather="gift"></i><span>Free Shipment</span></a>
              </li>
              <li class="dropdown <?= $active == "bundles.php" || $active == "manage_bundles.php" ? 'active' : ''; ?>">
                <a href="bundles" class="nav-link"><i data-feather="bold"></i><span>Bundles</span></a>
              </li>
              <li class="menu-header">Product Features</li>
              <li class="dropdown <?= $active == "categories.php" || $active == "manage_categories.php" ? 'active' : ''; ?>">
                <a href="categories" class="nav-link"><i data-feather="more-horizontal"></i><span>Categories</span></a>
              </li>
              <li class="dropdown <?= $active == "sub_categories.php" || $active == "manage_sub_categories.php" ? 'active' : ''; ?>">
                <a href="sub_categories" class="nav-link"><i data-feather="list"></i><span>Sub Categories</span></a>
              </li>
              <li class="dropdown <?= $active == "units.php" || $active == "manage_units.php" ? 'active' : ''; ?>">
                <a href="units" class="nav-link"><i data-feather="underline"></i><span>Units Of Measure</span></a>
              </li>
              <li class="dropdown <?= $active == "genre.php" || $active == "manage_genre.php" ? 'active' : ''; ?>">
                <a href="genre" class="nav-link"><i data-feather="file-text"></i><span>Genre</span></a>
              </li>
              <li class="dropdown <?= $active == "lasting.php" || $active == "manage_lasting.php" ? 'active' : ''; ?>">
                <a href="lasting" class="nav-link"><i data-feather="clock"></i><span>Lasting</span></a>
              </li>
              <li class="dropdown <?= $active == "type.php" || $active == "manage_type.php" ? 'active' : ''; ?>">
                <a href="type" class="nav-link"><i data-feather="type"></i><span>Product Types</span></a>
              </li>
              <li class="dropdown <?= $active == "impression.php" || $active == "manage_impression.php" ? 'active' : ''; ?>">
                <a href="impression" class="nav-link"><i data-feather="filter"></i><span>Impressions</span></a>
              </li>
              <li class="menu-header">Content Management</li>
              <li class="dropdown <?= $active == "banner.php" || $active == "manage_banner.php" ? 'active' : ''; ?>">
                <a href="banner" class="nav-link"><i data-feather="image"></i><span>Banners</span></a>
              </li>
              <li class="dropdown <?= $active == "home.php" || $active == "manage_home.php" ? 'active' : ''; ?>">
                <a href="home" class="nav-link"><i data-feather="home"></i><span>Home</span></a>
              </li>
              <li class="dropdown <?= $active == "about.php" || $active == "manage_about.php" ? 'active' : ''; ?>">
                <a href="about" class="nav-link"><i data-feather="book-open"></i><span>About</span></a>
              </li>
              <li class="dropdown <?= $active == "contact_us.php" ? 'active' : ''; ?>">
                <a href="contact_us" class="nav-link"><i data-feather="phone"></i><span>Contact Us</span></a>
              </li>
              <li class="dropdown <?= $active == "review.php" || $active == "review_detail.php" ? 'active' : ''; ?>">
                <a href="review" class="nav-link"><i data-feather="message-square"></i><span>Reviews</span></a>
              </li>
              <li class="menu-header">User Management</li>
              <li class="dropdown <?= $active == "users.php" ? 'active' : ''; ?>">
                <a href="users" class="nav-link"><i data-feather="users"></i><span>Users</span></a>
              </li>
              <li class="dropdown <?= $active == "cities.php" || $active == "manage_cities.php" ? 'active' : ''; ?>">
                <a href="cities" class="nav-link"><i data-feather="map-pin"></i><span>Cities</span></a>
              </li>
              <li class="menu-header">Admin Users</li>
              <li class="dropdown <?= $active == "panel_users.php" || $active == "manage_panel_users.php" ? 'active' : ''; ?>">
                <a href="panel_users" class="nav-link"><i data-feather="monitor"></i><span>Staff</span></a>
              </li>
            <?php
            } else {
            ?>
              <li class="dropdown <?= $active == "index.php" ? 'active' : ''; ?>">
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