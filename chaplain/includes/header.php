<?php
session_start();
include "php/session.php";
include "php/db_config.php";
include "php/security.php";
$chaplainId = $_SESSION['chaplain-id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
      <style>
        :root {
            --bs-primary: #4361ee;
            --bs-success: #00b894;
            --bs-warning: #fdcb6e;
            --bs-danger: #d63031;
            --bs-info: #00cec9;
        }
        
        .bg-light-primary { background-color: rgba(67, 97, 238, 0.1) !important; }
        .bg-light-success { background-color: rgba(0, 184, 148, 0.1) !important; }
        .bg-light-warning { background-color: rgba(253, 203, 110, 0.1) !important; }
        .bg-light-danger { background-color: rgba(214, 48, 49, 0.1) !important; }
        .bg-light-info { background-color: rgba(0, 206, 201, 0.1) !important; }
        
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .folder-item, .file-item {
            transition: all 0.3s ease;
        }
        
        .folder-item:hover, .file-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .border-dashed {
            border-style: dashed !important;
            cursor: pointer;
        }
        
        .border-dashed:hover {
            border-color: var(--bs-primary) !important;
            background-color: rgba(var(--bs-primary-rgb), 0.05);
        }
    </style>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Zono admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
  <meta name="keywords"
    content="admin template, Zono admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="pixelstrap">
  <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
  <title>Anchored Chaplain</title>
  <!-- Google font -->
  <link rel="preconnect" href="../../../fonts.googleapis.com/index.html">
  <link rel="preconnect" href="../../../fonts.gstatic.com/index.html" crossorigin="">
  <link
    href="../../../fonts.googleapis.com/css2e3ea.css?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
    rel="stylesheet">
  <link
    href="../../../fonts.googleapis.com/css8807.css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
    rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <!-- ico-font-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/icofont.css">
  <!-- Themify icon-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/themify.css">
  <!-- Flag icon-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/flag-icon.css">
  <!-- Feather icon-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/feather-icon.css">
  <!-- Plugins css start-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css">
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css">
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/animate.css">
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/datatables.css">
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/owlcarousel.css">
  <!-- Plugins css Ends-->
  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">
  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
</head>

<body>
  <!-- loader starts-->
  <!-- <div class="loader-wrapper">
    <div class="theme-loader">
      <div class="loader-p"></div>
    </div>
  </div> -->
  <!-- loader ends-->
  <!-- tap on top starts-->
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
  <!-- tap on tap ends-->
  <!-- page-wrapper Start   -->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-header">
      <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
          <div class="logo-wrapper"><a href="index.html"> <img class="img-fluid for-light"
                src="assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark"
                src="assets/images/logo/logo_dark.png" alt=""></a></div>
          <div class="toggle-sidebar">
            <svg class="sidebar-toggle">
              <use href="assets/svg/icon-sprite.svg#stroke-animation"></use>
            </svg>
          </div>
        </div>
        <form class="col-sm-4 form-inline search-full d-none d-xl-block" action="#" method="get">
     
        </form>
        <div class="nav-right col-xl-8 col-lg-12 col-auto pull-right right-header p-0">
          <ul class="nav-menus">
            <li>
              <div class="mode">
                <svg class="for-dark">
                  <use href="assets/svg/icon-sprite.svg#moon"></use>
                </svg>
                <svg class="for-light">
                  <use href="assets/svg/icon-sprite.svg#Sun"></use>
                </svg>
              </div>
            </li>
            <li class="language-nav">
              <div class="translate_wrapper">
                <div class="current_lang">
                  <div class="lang"><i class="flag-icon flag-icon-gb"></i><span class="lang-txt box-col-none">EN </span>
                  </div>
                </div>
                <div class="more_lang">
                  <div class="lang selected" data-value="en"><i class="flag-icon flag-icon-us"></i><span
                      class="lang-txt">English<span> (US)</span></span></div>
                </div>
              </div>
            </li>
            <li class="profile-nav onhover-dropdown pe-0 py-0">
              <div class="d-flex align-items-center profile-media"><img class="b-r-25"
                  src="assets/images/dashboard/profile.png" alt="">
                <div class="flex-grow-1 user"><span>Admin</span>
                  <p class="mb-0 font-nunito">Admin
                    <svg>
                      <use href="assets/svg/icon-sprite.svg#header-arrow-down"></use>
                    </svg>
                  </p>
                </div>
              </div>
              <ul class="profile-dropdown onhover-show-div">
                <!-- <li><a href="user-profile.html"><i data-feather="user"></i><span>Account </span></a></li> -->
                <li><a href="login.html"> <i data-feather="log-in"></i><span>Log Out</span></a></li>
              </ul>
            </li>
          </ul>
        </div>
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">              
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            </div>
            </div>
          </script>
      </div>
    </div>
    <!-- Page Header Ends                              -->
    <!-- Page body Start -->
    <div class="page-body-wrapper">
      <!-- Page Sidebar Start-->
      <div class="sidebar-wrapper" data-layout="stroke-svg">
        <div>
          <div class="logo-wrapper"><a href="index.html"> <img class="img-fluid for-light"
                src="assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark"
                src="assets/images/logo/logo_dark.png" alt=""></a>
            <div class="toggle-sidebar">
              <svg class="sidebar-toggle">
                <use href="assets/svg/icon-sprite.svg#toggle-icon"></use>
              </svg>
            </div>
          </div>
          <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                src="assets/images/logo/logo-icon.png" alt=""></a></div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
              <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="index.html"><img class="img-fluid" src="assets/images/logo/logo-icon.png"
                      alt=""></a>
                  <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                      aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                  <div>
                    <h6>Pinned</h6>
                  </div>
                </li>
                <li class="sidebar-main-title">
                  <div>
                    <h6 class="lan-1">General</h6>
                  </div>
                </li>
                <li class="sidebar-list"></i><a class="sidebar-link sidebar-title" href="index.php">
                    <svg class="stroke-icon">
                      <use href="assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="assets/svg/icon-sprite.svg#fill-home"></use>
                    </svg><span>Dashboard </span></a>
                </li>

                <li class="sidebar-list">
                  <a class="sidebar-link sidebar-title" href="chaplain-coaching.php">
                    <svg class="stroke-icon">
                      <use href="assets/svg/icon-sprite.svg#stroke-user-check"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="assets/svg/icon-sprite.svg#fill-user-check"></use>
                    </svg>
                    <span>Chaplain Coaching</span>
                  </a>
                </li>

                <li class="sidebar-list">
                  <a class="sidebar-link sidebar-title" href="chaplain-training.php">
                    <svg class="stroke-icon">
                      <use href="assets/svg/icon-sprite.svg#stroke-book-open"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="assets/svg/icon-sprite.svg#fill-book-open"></use>
                    </svg>
                    <span>Chaplain Training</span>
                  </a>
                </li>

                <li class="sidebar-list">
                  <a class="sidebar-link sidebar-title" href="book-coaching.php">
                    <svg class="stroke-icon">
                      <use href="assets/svg/icon-sprite.svg#stroke-calendar"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="assets/svg/icon-sprite.svg#fill-calendar"></use>
                    </svg>
                    <span>Book Coaching</span>
                  </a>
                </li>

                <li class="sidebar-list">
                  <a class="sidebar-link sidebar-title" href="life-coaching.php">
                    <svg class="stroke-icon">
                      <use href="assets/svg/icon-sprite.svg#stroke-heart"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="assets/svg/icon-sprite.svg#fill-heart"></use>
                    </svg>
                    <span>Life Coaching</span>
                  </a>
                </li>

                <li class="sidebar-list">
                  <a class="sidebar-link sidebar-title" href="business-coaching.php">
                    <svg class="stroke-icon">
                      <use href="assets/svg/icon-sprite.svg#stroke-briefcase"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="assets/svg/icon-sprite.svg#fill-briefcase"></use>
                    </svg>
                    <span>Business Coaching</span>
                  </a>
                </li>

                <li class="sidebar-list">
                  <a class="sidebar-link sidebar-title" href="affiliate.php">
                    <svg class="stroke-icon">
                      <use href="assets/svg/icon-sprite.svg#stroke-share-2"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="assets/svg/icon-sprite.svg#fill-share-2"></use>
                    </svg>
                    <span>Affiliate</span>
                  </a>
                </li>

             </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
          </nav>
        </div>
      </div>
      <!-- Page Sidebar Ends-->


