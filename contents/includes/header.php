<?php
  include('../../db/guard.php');
  include('../../db/define.php');
?>
<!doctype html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="msapplication-tap-highlight" content="no">
  <title><?= (isset($title)&&!empty($title))? $title.' | Outlendars' : 'Outlendars' ; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
  <link rel="shortcut icon" href="./favicon/favicon.ico">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/assets/favicon/favicon.jpg">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/assets/favicon/favicon.jpg">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/libs/select2/dist/css/select2.min.css"/>
  <link href="<?= BASE_URL ?>/assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= BASE_URL ?>/assets/libs/jquery-steps/jquery.steps.css"
  rel="stylesheet"/>
  <link href="<?= BASE_URL ?>/assets/libs/jquery-steps/steps.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/libs/datatables/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/style.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/libs/toastr/build/toastr.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/libs/sweetalert/css/sweetalert.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/custom_style.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/vendor/flag-icons-main/css/flag-icons.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/vendor/flag-icons-main/css/flag-icons.min.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.13/dist/css/bootstrap-select.min.css">
</head>
<body>
<input type="hidden" name="userid" id="userid" value="<?= $_SESSION["userid"]; ?>">
<div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
<header class="topbar">
<nav class="navbar top-navbar navbar-expand-md navbar-light">
  <div class="navbar-header" data-logobg="skin5">
    <a class="navbar-brand" href="javascript:void(0)">
      <b class="logo-icon ps-2">
      <img src="" alt="" class="" width="25"/>
      </b>
    </a>
    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
  </div>
  <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
    <ul class="navbar-nav float-start translator_box">
      <li class="nav-item d-none d-lg-block">
        <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void (0)"data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav float-start">
      <div class="form-group country_translator">
        <div id="google_translate_element" style="display: none;"></div>
        <select class="form-control custom-select langSelect notranslate selectpicker" id="basic2">
          <option class="mmenmm" value="English" data-content='<span class="fi fi-us"></span> English'></option>
          <option class="mmgrmm" value="German"data-content='<span class="fi fi-de"></span> German'></option>
        </select>
      </div>
    </ul>
    <ul class="navbar-nav float-start me-auto trial_box">
      <li class="nav-item nav-search d-none d-lg-block ">
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="container d-flex justify-content-center">
              <div class="trial_card">
                <div class="media">
                  <div class="media-body">
                    <h6 class=" mb-0"><a id="trialTimer" class="text-danger notranslate"></a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  <div class="dropdown">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle p-2 mt-1 text-muted waves-effect waves-dark pro-pic" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"aria-expanded="false">
          <span class="text-outlendars p-2"><?= ucfirst($_SESSION['fullname']) ?></span>
          <img src="/assets/images/users-1.png" alt="user" class="rounded-circle"width="31"/>
        </a>
        <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/profile">
            <i class="mdi mdi-account me-1 ms-1"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/settings">
            <i class="mdi mdi-settings me-1 ms-1"></i> Settings
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/logout">
            <i class="fa fa-power-off me-1 ms-1"></i> Logout
          </a>
        </ul>
      </li>
    </ul>
  </div>
  </div>
  </nav>
</header>
<?php include( 'sidebar.php' );?>