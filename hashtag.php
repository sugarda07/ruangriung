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
    <link href="assets/dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/magnific/css/style.css">
    <link href="assets/dist/css/pages/other-pages.css" rel="stylesheet">
    <link href="assets/dist/css/placeholder-loading.min.css" rel="stylesheet">
    <!--<link href="assets/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>


<body class="skin-purple fixed-layout single-column card-no-border fix-sidebar">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">RuangDIGITAL</p>
        </div>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"> <a class="nav-link" href="index.php"><i class="fa fa-arrow-left"></i></a> </li>
                        <li class="nav-item" style="margin-left: 10px; padding-top: 3px;">
                        </li>
                    </ul>

                    <ul class="navbar-nav my-lg-0">
                        
                    </ul>
                </div>
            </nav>
        </header>
        <div class="page-wrapper">
            <div class="container-fluid" style="padding: 5px;">
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class=col-12>
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#konten" role="tab"><span class="hidden-sm-up"><i class="ti-tag"></i></span> <span class="hidden-xs-down">Postingan</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#orang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Orang</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="konten" role="tabpanel">
                                    <div class="card" style="margin-bottom: 5px;">
                                        <div class="card-body" style="padding: 9px;">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search_box" id="search_box" placeholder="Cari">
                                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" id="dynamic_content">

                                    </div>
                                </div>
                                <div class="tab-pane" id="orang" role="tabpanel">                                    
                                    <div class="card" style="margin-bottom: 5px;">
                                        <div class="card-body" style="padding: 9px;">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="cari_kontak" id="cari_kontak" placeholder="Cari">
                                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" id="dynamic_kontak">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    
            </div>
        </div>
    </div>
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/dist/js/jquery.form.js"></script>
    <script src="assets/dist/js/jquery.min.js"></script>
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
</body>


<script>
$(document).ready(function(){  

    load_data(1);

    function load_data(page, query = '')
    {
      $.ajax({
        url:"live_pencarian.php",
        method:"POST",
        data:{page:page, query:query},
        success:function(data)
        {
          $('#dynamic_content').html(data);
        }
      });
    }

    $(document).on('click', '.page-link', function(){
      var page = $(this).data('page_number');
      var query = $('#search_box').val();
      load_data(page, query);
    });

    $('#search_box').keyup(function(){
      var query = $('#search_box').val();
      load_data(1, query);
    });


    load_kontak(1);

    function load_kontak(page, query = '')
    {
      $.ajax({
        url:"cari_kontak.php",
        method:"POST",
        data:{page:page, query:query},
        success:function(data)
        {
          $('#dynamic_kontak').html(data);
        }
      });
    }

    $(document).on('click', '.page-link', function(){
      var page = $(this).data('page_number');
      var query = $('#cari_kontak').val();
      load_data(page, query);
    });

    $('#cari_kontak').keyup(function(){
      var query = $('#cari_kontak').val();
      load_kontak(1, query);
    });



});
</script>
</html>