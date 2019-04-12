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
<link href="assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
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
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

    <div class="loader"></div>
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="index.php">
                            <img src="assets/pages/img/logo.png" alt="logo" class="logo-default"/> </a>
                        </div>
                    </div>
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                            <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                            <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                            <?php
                              

                                $sqlCek     = "SELECT * FROM as_trx_meet_sch 
                                                WHERE date(as_trx_meet_sch_start)='".date('Y-m-d')."'";
                                $qryCek     = mysqli_query($koneksidb, $sqlCek) or die ("Eror Query".mysqli_error()); 
                                $jmlRow     = mysqli_num_rows($qryCek);
                                  # code...
                                
                                
                            ?>

                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-calendar"></i>
                                    <?php 
                                      if($jmlRow>=1){
                                    ?>
                                    <span class="badge badge-default"> <?php echo $jmlRow ?> </span>
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php 
                                      if($jmlRow>=1){
                                    ?>
                                    <li class="external">
                                        <h3><span class="bold"><?php echo $jmlRow ?> </span> notifications</h3>
                                    </li>
                                    <?php }else{ ?>
                                    <li class="external">
                                        <h3>Empty notifications</h3>
                                    </li>

                                    <?php } ?>
                                    <li>
                                        <ul class="dropdown-menu-list fc-scroller" style="max-height: 250px;" data-handle-color="#637283">
                                          <?php

                                            while ($cekRow = mysqli_fetch_array($qryCek)) {
                                                $ID = $cekRow['as_trx_meet_sch_id'];
                                              

                                          ?>
                                            <li>
                                                <a href="?page=<?php echo base64_encode(meetingscheduleview) ?>&amp;id=<?php echo base64_encode($ID); ?>">
                                                    <span class="details">
                                                        </span> <?php echo $cekRow['as_trx_meet_sch_start'] ?> | <?php echo $cekRow['as_trx_meet_sch_agenda'] ?> </span>
                                                </a>
                                            </li>
                                          <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                           
                            <!-- END TODO DROPDOWN -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="login.php" class="dropdown-toggle">
                                    <i class="icon-user"></i>
                                    <span class="username uppercase"> Login </span>
                                    &nbsp;
                                </a>
                            </li>
                            <li class="dropdown dropdown-user dropdown-quick-sidebar-toggler">
                                <a href="javascript:;" class="dropdown-toggle">
                                    <i class="icon-bell"></i>
                                    <span class="username uppercase"> Extention </span>
                                    &nbsp;
                                </a>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        



                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" >
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            
                            <li class="nav-item start ">
                                <a href="index.php" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title">Dasboard</span>
                                </a>
                                
                            </li>
                            <li class="nav-item start">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-feed"></i>
                                    <span class="title">Operating Procedure</span>
                                    <span class="selected"></span>
                                    <span class="arrow open"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item start ">
                                      <a href="?page=<?php echo base64_encode(standardglobal) ?>" class="nav-link "><span class="title">Standard Global</span></a>
                                    </li>
                                    <li class="nav-item start ">
                                      <a href="?page=<?php echo base64_encode(standarddepartemen) ?>" class="nav-link "><span class="title">Standard Departemen</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item start">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-support"></i>
                                    <span class="title">Supporting</span>
                                    <span class="selected"></span>
                                    <span class="arrow open"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item start ">
                                      <a href="?page=<?php echo base64_encode(ticketing) ?>" class="nav-link "><span class="title">Ticketing</span></a>
                                    </li>
                                    <li class="nav-item start ">
                                      <a href="?page=<?php echo base64_encode(meetingschedule) ?>" class="nav-link "><span class="title">Meeting Schedule</span></a>
                                    </li>
                                    <li class="nav-item start ">
                                      <a href="http://192.168.2.17" target="_BLANK" class="nav-link "><span class="title">ERP System</span></a>
                                    </li>
                                    <li class="nav-item start ">
                                      <a href="http://192.168.2.9:9090/electrical" target="_BLANK" class="nav-link "><span class="title">Electrical System</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item start ">
                                <a href="?page=<?php echo base64_encode(sec) ?>" class="nav-link nav-toggle">
                                    <i class="icon-docs"></i>
                                    <span class="title">Education Center</span>
                                </a>
                                
                            </li>
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
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
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- END QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-call-in"></i>
                </a>

                <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                    <div class="page-quick-sidebar">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="javascript:;"> Users Extention
                                </a>
                            </li>
                        </ul>
                        <div class="portlet box">
                            <div class="portlet-body">
                                <table class="table table-striped table-hover table-checkable order-column" id="sample_2">
                                    <thead>
                                        <tr class="active">
                                            <th class="table-checkbox">
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" class="group-checkable" disabled data-set="#sample_2 .checkboxes" />
                                                    <span></span>
                                                </label>
                                            </th>
                                            <th width="40%">NAMA</th>
                                            <th width="30%">DEPARTEMEN</th>
                                            <th width="20%">LINE TELEPON</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                            $dataSql = "SELECT * FROM as_ms_ext a";
                                            $dataQry = mysqli_query($koneksidb, $dataSql);
                                            $nomor  = 0; 
                                            while ($data = mysqli_fetch_array($dataQry)) {
                                            $nomor++;
                                    ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                    <input type="checkbox" disabled class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td><?php echo $data['as_ms_ext_nama']; ?></td>
                                            <td><?php echo $data['as_ms_ext_ket']; ?></td>
                                            <td><?php echo $data['as_ms_ext_line']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> 2018 &copy; IT Developer By
                    <a target="_blank" href="http://sutrakabel.com">Sutrado</a> &nbsp;|&nbsp;
                    <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Metronic Template</a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
       
        <div class="quick-nav-overlay"></div>

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


<script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
<script src="assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
<script src="assets/pages/scripts/form-validation.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script src="assets/scripts/moment.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/fullcalendar/fullcalendar.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

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
