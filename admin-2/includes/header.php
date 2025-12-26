<?php
session_start();
include "php/session.php";
include "php/db_config.php";
include "php/security.php";
?>


<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/techmin/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Oct 2023 22:35:35 GMT -->
<head>
	<meta charset="utf-8" />
	<title>Anchored || Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
	<meta content="Techzaa" name="author" />

	<!-- App favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- Daterangepicker css -->
	<link rel="stylesheet" href="assets/vendor/daterangepicker/daterangepicker.css">

	<!-- Vector Map css -->
	<link rel="stylesheet" href="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">

	<!-- Theme Config Js -->
	<script src="assets/js/config.js"></script>

	<!-- App css -->
	<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

	<!-- Icons css -->
	<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<!-- Begin page -->
	<div class="wrapper">

		<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="index.php" class="logo-light">
                    <span class="logo-lg">
                        <img src="assets/images/logo.png" alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="small logo">
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="index.php" class="logo-dark">
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="small logo">
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="mdi mdi-menu"></i>
            </button>

            <!-- Page Title -->
            <h4 class="page-title d-none d-sm-block">Dashboards</h4>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-magnify fs-2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                    <form class="p-3">
                        <input type="search" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                    </form>
                </div>
            </li>


            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="assets/images/users/avatar-1.jpg" alt="user-image" width="32" class="rounded-circle">
                    </span>
                    <span class="d-lg-block d-none">
                        <h5 class="my-0 fw-normal">Admin<i class="ri-arrow-down-s-line fs-22 d-none d-sm-inline-block align-middle"></i></h5>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

							<span>
								<form action="php/logout.php" method="POST">
									<button name="logout" class="btn btn-danger" type="submit">Logout</button>
								</form>
						</span>
        
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->

		<!-- Left Sidebar Start -->
		<div class="leftside-menu">

		    <!-- Logo Light -->
		    <a href="index.php" class="logo logo-light">
		        <span class="logo-lg">
		            <img src="assets/images/logo.png" alt="logo">
		        </span>
		        <span class="logo-sm">
		            <img src="assets/images/logo-sm.png" alt="small logo">
		        </span>
		    </a>

		    <!-- Logo Dark -->
		    <a href="index.php" class="logo logo-dark">
		        <span class="logo-lg">
		            <img src="assets/images/logo-dark.png" alt="dark logo">
		        </span>
		        <span class="logo-sm">
		            <img src="assets/images/logo-sm.png" alt="small logo">
		        </span>
		    </a>

		    <!-- Sidebar -->
		    <div data-simplebar>
		        <ul class="side-nav">
		            <li class="side-nav-title">Main</li>

		            <li class="side-nav-item">
		                <a href="index.php" class="side-nav-link">
		                    <i class="ri-dashboard-2-line"></i>
		                    <span> Dashboard </span>
		                    <span class="badge bg-success float-end">9+</span>
		                </a>
		            </li>

		            <li class="side-nav-title">Components</li>
                    <li class="side-nav-item">
		                <a href="books.php" class="side-nav-link">
		                    <i class="ri-list-ordered"></i>
		                    <span>Books </span>
		                </a>
		            </li>
					<li class="side-nav-item">
		                <a href="certificates.php" class="side-nav-link">
		                    <i class="ri-list-ordered"></i>
		                    <span>Certificates</span>
		                </a>
		            </li>
					<li class="side-nav-item">
		                <a href="pin.php" class="side-nav-link">
		                    <i class="ri-list-ordered"></i>
		                    <span>PIN </span>
		                </a>
		            </li>
					<li class="side-nav-item">
		                <a href="videos.php" class="side-nav-link">
		                    <i class="ri-list-ordered"></i>
		                    <span>Videos </span>
		                </a>
		            </li>
		        </ul>
		    </div>
		</div>
		<!-- Left Sidebar End -->
		