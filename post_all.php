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
    <link rel="stylesheet" href="assets/magnific/css/style.css">
    <!--<link href="assets/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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
                        <li class="nav-item"> <a class="nav-link" href="index.php"><i class="fa fa-arrow-left"></i></a> </li>
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item" style="margin-left: 10px; padding-top: 3px;">
                            <form class="app-search d-md-block d-lg-block">
                                <input type="text" class="form-control" placeholder="Search & enter">
                            </form>
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
                <div class="row" style="margin-bottom: 40px;">
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#post_gallery" role="tab"><span class="hidden-sm-up"><i class="ti-gallery"></i></span> <span class="hidden-xs-down">Gallery</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#post_video" role="tab"><span class="hidden-sm-up"><i class="ti-layout-width-default"></i></span> <span class="hidden-xs-down">Video</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#post_dokumen" role="tab"><span class="hidden-sm-up"><i class="ti-receipt"></i></span> <span class="hidden-xs-down">Dokumen</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="post_gallery" role="tabpanel">
                                    <div class="p-20" style="padding: 9px;">
                                        <div class="gallery-section">
                                            <div class="inner-width">
                                                <div class="gallery" id="post_all_gallery">

                                                </div>
                                                <div id="load_data_message" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="post_video" role="tabpanel">                                    
                                    <div class="card-body" style="padding: 9px;">
                                        <?php 
                                        $query = "
                                        SELECT * FROM postingan
                                        JOIN user ON postingan.user_id = user.user_id
                                        ORDER BY RAND()
                                        ";
                                        $statement = $connect->prepare($query);
                                        $statement->execute();
                                        $result = $statement->fetchAll();
                                        $total_row = $statement->rowCount();

                                        foreach($result as $row)
                                        {
                                            if($row['post_video'] != '')
                                            {
                                                echo '


                                                <div class="row m-b-20">
                                                    <div class="col-4">
                                                        <video src="data/posting/video/'.$row["post_video"].'" class="img-fluid" alt="alb"></video>
                                                    </div>
                                                    <div class="col-8">
                                                        <h5 class="card-title m-b-5">'.strip_tags(substr($row["post_konten"], 0, 25)).'</h5>
                                                        <span class="text-muted">'.$row['nama_depan'].'  |  '.tgl_indo($row['post_tgl']).' </span>
                                                    </div>
                                                </div>
                                                ';
                                            }
                                            else if($row['post_embed'] != '')
                                            {
                                                echo '

                                                <div class="row m-b-20">
                                                    <div class="col-4">
                                                        <img src="https://img.youtube.com/vi/'.$row["post_embed"].'/hqdefault.jpg" alt="Product Image" style="width: 99px; height:auto;">
                                                    </div>
                                                    <div class="col-8">
                                                        <h5 class="card-title m-b-5">'.strip_tags(substr($row["post_konten"], 0, 25)).'</h5><span class="text-muted">'.$row['nama_depan'].'  |  '.tgl_indo($row['post_tgl']).'</span></div>
                                                </div>
                                            ';
                                            }               
                                        }
                                    ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="post_dokumen" role="tabpanel">
                                    <div class="card-body" style="padding: 9px;">
                                        <?php 
                                        $query = "
                                        SELECT * FROM postingan
                                        JOIN user ON postingan.user_id = user.user_id
                                        ORDER By post_id DESC
                                        ";
                                        $statement = $connect->prepare($query);
                                        $statement->execute();
                                        $result = $statement->fetchAll();
                                        $total_row = $statement->rowCount();

                                        foreach($result as $row)
                                        {
                                            if($row['post_ebook'] != '')
                                            {
                                                echo '


                                                <div class="row m-b-20">
                                                    <div class="col-4">
                                                        <a href="javascript:void()">
                                                            <img src="data/akun/profil/'.$row["profile_image"].'" class="img-fluid" alt="alb" />
                                                        </a>
                                                    </div>
                                                    <div class="col-8">
                                                        <h5 class="card-title m-b-5">'.strip_tags(substr($row["post_konten"], 0, 25)).'</h5>
                                                        <span class="text-muted">'.$row['nama_depan'].'  |  '.tgl_indo($row['post_tgl']).' </span>
                                                    </div>
                                                </div>
                                                ';
                                            }            
                                        }
                                    ?>
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
         <footer class="footer hidden-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; padding: 0px; margin-left: 0px;">
            <div class="row" style="margin-left: 0px; margin-right: 0px;">
                <div class="col-3" style="padding: 10px">
                    <a href="index.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="icon-home" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                </div>
                <div class="col-3" style="padding: 10px">
                    <a href="post_all.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="fa fa-search" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                </div>
                <div class="col-3" style="padding: 10px">
                    <a href="hashtag.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="fa fa-heart-o" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                </div>
                <div class="col-3" style="padding: 10px">
                    <a href="pesan/index.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="ti-comments" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                </div>
            </div>
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

 var limit = 21;
 var start = 0;
 var action = 'inactive';
 function post_all_gallery(limit, start)
 {
  var proses = 'post_all_gallery';
  $.ajax({
   url:'proses.php',
   method:"POST",
   data:{limit:limit, start:start, proses:proses},
   cache:false,
   success:function(data)
   {
    $('#post_all_gallery').append(data);
    if(data == '')
    {
      $('#load_data_message').html("<button type='button' class='btn btn-link btn-block'></button>");
     action = 'active';
    }
    else
    {
      $('#load_data_message').html("<button type='button' class='btn btn-link btn-block'></button>");
     action = "inactive";
    }
   }
  });
 }

 if(action == 'inactive')
 {
  action = 'active';
  post_all_gallery(limit, start);
 }
 $(window).scroll(function(){
  if($(window).scrollTop() + $(window).height() > $("#post_all_gallery").height() && action == 'inactive')
  {
   action = 'active';
   start = start + limit;
   setTimeout(function(){
    post_all_gallery(limit, start);
   }, 1000);
  }
 });


});
</script>
</html>