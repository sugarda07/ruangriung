<?php
include('koneksi.php');
include('function.php');
session_start();
if(!isset($_SESSION['user_id'])) {
  header("location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/r16.png">
    <title>RuangDIGITAL</title>
    <!-- Page CSS -->
    <link href="assets/dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="assets/dist/css/pages/user-card.css" rel="stylesheet">
    <link href="assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <link href="assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="assets/dist/css/style.css" rel="stylesheet">
    <link href="assets/dist/css/pages/tab-page.css" rel="stylesheet">
    <!--<link href="assets/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="assets/dist/css/pages/tab-page.css" rel="stylesheet">
    <link href="assets/dist/css/placeholder-loading.min.css" rel="stylesheet">
    <link href="assets/dist/css/pages/ribbon-page.css" rel="stylesheet">
    <link href="assets/jquery-mentions-input-master/jquery.mentionsInput.css" rel="stylesheet">
    <link href="assets/dist/css/pages/stylish-tooltip.css" rel="stylesheet">
    <link href="assets/node_modules/jqueryui/jquery-ui.css" rel="stylesheet" type="text/css">
</head>


<body class="skin-purple fixed-layout single-column card-no-border fix-sidebar">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">RuangDIGITAL</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item"> <a class="nav-link" href="index.php"><i class="fa fa-arrow-left"></i></a> </li>
                        <li class="nav-item" style="margin-left: 10px; padding-top: 3px;">
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="padding: 5px;">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card">
                            <div class="card-body">
                                <div class="message-box">
                                    <div class="message-widget message-scroll" id="load_notif">

                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->




        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer hidden-footer" align="center" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; margin-left: 0px;">
          © 2020 RuangDIGITAL by @sugarda3rd
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/dist/js/jquery.form.js"></script>
    <script src="assets/dist/js/jquery.min.js"></script>
    <script src="assets/node_modules/jqueryui/jquery-ui.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="assets/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="assets/dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/dist/js/custom.min.js"></script>
    <script src="assets/fullscreen_modal/dist/bs-modal-fullscreen.js"></script>
    <script src="assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
    <!-- Sweet-Alert  -->
    <script src="assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script src="assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script src="assets/jquery-mentions-input-master/lib/jquery.elastic.js" type="text/javascript"></script>
    <script src="assets/jquery-mentions-input-master/underscore-min.js" type="text/javascript"></script>
    <script src="assets/jquery-mentions-input-master/jquery.mentionsInput.js" type="text/javascript"></script>
</body>


<script>
$(document).ready(function(){  

 load_notif_list();

  function load_notif_list()
  {
      var proses = 'load_notif';
      $.ajax({
          url:"proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#load_notif').html(data);
          }
      });
  }


  $(document).on('click', '.action_button', function(){
        var sender_id = $(this).data('sender_id');
        var proses = $(this).data('proses');
        $.ajax({
            url:"proses.php",
            method:"POST",
            data:{sender_id:sender_id, proses:proses},
            success:function(data)
            {
                load_notif_list();
            }
        })
    });


});
</script>
</html>