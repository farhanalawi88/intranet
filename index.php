<?php
session_start();
include_once "config/inc.connection.php";
include_once "config/inc.library.php";
date_default_timezone_set('Asia/Jakarta');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING |E_DEPRECATED));


  
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Intranet - Information Center</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

<link href="assets/global/css/components-rounded.css" rel="stylesheet" type="text/css" />
<link href="assets/global/css/plugins-rounded.css" rel="stylesheet" type="text/css" />

<link href="assets/layouts/layout/css/layout.css" rel="stylesheet" type="text/css" />
<link href="assets/layouts/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
<link href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

<link href="assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />

<link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

<link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<link rel="shortcut icon" href="favicon.ico" /> </head>
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-full-width">
  <div class="loader"></div>
<!--<div class="loader"></div>-->
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
  <!-- BEGIN HEADER INNER -->
  <div class="page-header-inner">
    <!-- BEGIN LOGO -->
    <div class="page-logo">
        <a href="index.php">
            <img src="assets/pages/img/logo.png" alt="logo" class="logo-default"/></a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN HORIZANTAL MENU -->
    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
    <!-- DOC: This is desktop version of the horizontal menu. The mobile version is defined(duplicated) sidebar menu below. So the horizontal menu has 2 seperate versions -->
    <div class="hor-menu hidden-sm hidden-xs">
      <ul class="nav navbar-nav">
        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
        <li class="classic-menu-dropdown"><a href="index.php"><i class="fa fa-home"></i> Dasboard </a></li>
        <li class="classic-menu-dropdown">
          <a data-toggle="dropdown" href="javascript:;"><i class="fa fa-delicious"></i> SOP <i class="fa fa-angle-down"></i></a>
          <ul class="dropdown-menu pull-left">
            <li><a href="?page=<?php echo base64_encode(standardglobal) ?>">Standard Global</a></li>
            <li><a href="?page=<?php echo base64_encode(standarddepartemen) ?>">Standard Departemen</a></li>
          </ul>
        </li>
        <li class="classic-menu-dropdown">
          <a data-toggle="dropdown" href="javascript:;"><i class="fa fa-database"></i> Supporting <i class="fa fa-angle-down"></i></a>
          <ul class="dropdown-menu pull-left">
            <li><a href="?page=<?php echo base64_encode(sec) ?>"> Education Center </a></li>
            <li><a href="?page=<?php echo base64_encode(ithelpdesk) ?>" class="disabled"> IT Ticketing </a></li>
            <li><a href="?page=<?php echo base64_encode(bookmeetingroomdata) ?>"> Book Meeting Room</a></li>
            <li><a href="http://192.168.2.17" target="_BLANK"> ERP System </a></li>
            <li><a href="http://192.168.2.9:9090/electrical" target="_BLANK"> Electrical System </a></li>
          </ul>
        </li>
      </ul>
    </div>
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    <i class="fa fa-bars"></i></a>
    <div class="top-menu">
      <ul class="nav navbar-nav pull-right">
          <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
              <a href="login.php" class="dropdown-toggle">
                  <i class="icon-login"></i>
              </a>
              <ul class="dropdown-menu"></ul>
          </li>
          <!-- END QUICK SIDEBAR TOGGLER -->
      </ul>
  </div>
    <!-- END TOP NAVIGATION MENU -->
  </div>
  <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
  <!-- BEGIN SIDEBAR -->
  <div class="page-sidebar-wrapper">
    <!-- BEGIN HORIZONTAL RESPONSIVE MENU -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
      <ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true">
        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
        <!-- DOC: This is mobile version of the horizontal menu. The desktop version is defined(duplicated) in the header above -->
        <li class="sidebar-search-wrapper">
          <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
          <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
          <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
          <form class="sidebar-search sidebar-search-bordered" action="extra_search.html" method="POST">
            <a href="javascript:;" class="remove">
            <i class="icon-close"></i>
            </a>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
              <button class="btn submit"><i class="icon-magnifier"></i></button>
              </span>
            </div>
          </form>
          <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        <li><a href="?page=home"> Dashboard </a></li>
        
        <li class="nav-item">
          <a href="javascript:;" class="nav-link nav-toggle">
          <i class="<?php echo $menuShow['menu_icon'] ?>"></i> <?php echo $menuShow['menu_nama'] ?> <i class="fa fa-angle-down"></i>
          </a>
          <ul class="sub-menu">
            
            <li><a href="<?php echo $submenulink ?>">
                <?php echo $submenunama ?>
                </a>
            </li>
          </ul>
        </li>


        
      </ul>
    </div>
    <!-- END HORIZONTAL RESPONSIVE MENU -->
  </div>
  <!-- END SIDEBAR -->
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content">
      
    <?php
          if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '' || isset($_SESSION['info']) && $_SESSION['info'] <> '') {
                echo '  <div class="alert alert-'.$_SESSION['info'].'">
                      <button class="close" data-dismiss="alert"></button>
                      '.$_SESSION['pesan'].'
                    </div>
                    ';
              }
              $_SESSION['pesan'] = '';
              $_SESSION['info'] = '';
        
          if(isset($_GET['page'])){
            include("pages.php");
          }
          else{
            include("modul/home.php");
          }
        ?>  
    </div>
  </div>
  <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
  <div class="page-footer-inner">
     2018 &copy; Created By IT Sutrado.
  </div>
  <div class="page-footer-tools">
    <span class="go-top">
    <i class="fa fa-angle-up"></i>
    </span>
  </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
<script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>


<script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

<script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
<script src="assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/form-validation.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script>
     $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('slow');}, 500);});
     setTimeout(function(){$(".alert").fadeOut('slow');}, 3000);
</script>
<script type="text/javascript">
  $(window).load(function() {
    $(".loader").fadeOut("slow");
  });
</script>
<script type="text/javascript" src="assets/scripts/my.js"></script>
<script type="text/javascript" charset="utf-8">
  function fnHitung() {
  var angka = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(document.getElementById('inputku').value)))); //input ke dalam angka tanpa titik
  if (document.getElementById('inputku').value == "") {
    alert("Jangan Dikosongi");
    document.getElementById('inputku').focus();
    return false;
  }
  else
    if (angka >= 1) {
    alert("angka aslinya : "+angka);
    document.getElementById('inputku').focus();
    document.getElementById('inputku').value = tandaPemisahTitik(angka) ;
    return false; 
    }
  }
</script>
<script>
     $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('slow');}, 500);});
     setTimeout(function(){$(".alert").fadeOut('slow');}, 3000);
</script>

</body>
<!-- END BODY -->
</html>
