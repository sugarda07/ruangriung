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


<body class="skin-purple fixed-layout">
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
                        <li class="nav-item"> <a class="nav-link" href="javascript: history.go(-1)"><i class="fa fa-arrow-left"></i></a> </li>
                        <li class="nav-item" style="margin-left: 10px; padding-top: 3px;">
                        </li>
                    </ul>

                    <ul class="navbar-nav my-lg-0">
                        
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><?php echo Get_profile_image($connect, $_SESSION["user_id"]); ?><span class="hide-menu"><?php echo Get_nama_user($connect, $_SESSION["user_id"]); ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="view_profil.php?data=<?php echo $_SESSION["user_id"]; ?>"><i class="ti-user"></i>&nbsp; My Profile</a></li>
                                <li><a href="logout.php"><i class="fa fa-power-off"></i>&nbsp; Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- MENU</li>
                        <li> <a class="waves-effect waves-dark" href="index.php" aria-expanded="false"><i class="ti-home"></i><span class="hide-menu">Home</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="post_all.php" aria-expanded="false"><i class="ti-search"></i><span class="hide-menu">Cari</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="pencarian_posting.php" aria-expanded="false"><i class="ti-pencil-alt"></i><span class="hide-menu">Materi</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="pesan/index.php" aria-expanded="false"><i class="ti-comments"></i><span class="hide-menu">Pesan</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper" style="background-color: white;">
            <div class="container-fluid" style="padding: 5px;">
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class=col-12>
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#materi" role="tab"><span class="hidden-sm-up"><i class="fa fa-graduation-cap"></i></span> <span class="hidden-xs-down">Materi</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#nilai" role="tab"><span class="hidden-sm-up"><i class="fa fa-star"></i></span> <span class="hidden-xs-down">Nilai</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="materi" role="tabpanel">
                                    <div class="card" style="margin-bottom: 5px;">
                                        <div class="card-body" style="padding: 9px;">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="cari_materi" id="cari_materi" placeholder="Cari">
                                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body" id="data_materi" style="padding: 9px;">

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nilai" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body" id="data_penilaian">
                                            
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <footer class="footer hidden-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; padding: 0px; margin-left: 0px;">
                <div class="row" style="margin-left: 0px; margin-right: 0px;">
                    <div class="col-3" style="padding: 10px">
                        <a href="index.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="icon-home" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                    </div>
                    <div class="col-3" style="padding: 10px">
                        <a href="post_all.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="ti-search" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                    </div>
                    <div class="col-3" style="padding: 10px">
                        <a href="pencarian_posting.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="fa fa-heart" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                    </div>
                    <div class="col-3" style="padding: 10px">
                        <a href="pesan/index.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="ti-comments" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                    </div>
                </div>
            </footer>                    
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
    <script src="assets/node_modules/datatables/jquery.dataTables.min.js"></script>
</body>


<script>
$(document).ready(function(){  


    setInterval(function(){   
    checknotif();
    checknotifchat();
}, 10000);



function checknotif() {
    if (!Notification) {
        $('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
        return;
    }
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        $.ajax(
        {
            url : "json_notif.php",
            type: "POST",
            success: function(data, textStatus, jqXHR)
            {
                var data = jQuery.parseJSON(data);
                if(data.result == true){
                    var data_notif = data.notif;
                    
                    for (var i = data_notif.length - 1; i >= 0; i--) {
                        var theurl = data_notif[i]['url'];
                        var notifikasi = new Notification(data_notif[i]['title'], {
                            icon: data_notif[i]['icon'],
                            body: data_notif[i]['msg'],
                        });
                        notifikasi.onclick = function () {
                            window.open(theurl); 
                            notifikasi.close();     
                        };
                        setTimeout(function(){
                            notifikasi.close();
                        }, 5000);
                    };
                }else{

                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {

            }
        }); 

    }
};


function checknotifchat() {
    if (!Notification) {
        $('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
        return;
    }
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        $.ajax(
        {
            url : "json_notif_chat.php",
            type: "POST",
            success: function(data, textStatus, jqXHR)
            {
                var data = jQuery.parseJSON(data);
                if(data.result == true){
                    var data_notif = data.notif;
                    
                    for (var i = data_notif.length - 1; i >= 0; i--) {
                        var theurl = data_notif[i]['url'];
                        var notifikasi = new Notification(data_notif[i]['title'], {
                            icon: data_notif[i]['icon'],
                            body: data_notif[i]['msg'],
                        });
                        notifikasi.onclick = function () {
                            window.open(theurl); 
                            notifikasi.close();     
                        };
                        setTimeout(function(){
                            notifikasi.close();
                        }, 5000);
                    };
                }else{

                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {

            }
        }); 

    }
};



});
</script>

<script>
$(document).ready(function(){
 
 data_penilaian();
 
 function data_penilaian()
 {
  $.ajax({
   url:"rating.php",
   method:"POST",
   success:function(data)
   {
    $('#data_penilaian').html(data);
   }
  });
 }
 
 $(document).on('mouseenter', '.rating', function(){
  var index = $(this).data("index");
  var post_id = $(this).data('post_id');
  remove_background(post_id);
  for(var count = 1; count<=index; count++)
  {
   $('#'+post_id+'-'+count).css('color', '#ffcc00');
  }
 });
 
 function remove_background(post_id)
 {
  for(var count = 1; count <= 5; count++)
  {
   $('#'+post_id+'-'+count).css('color', '#ccc');
  }
 }
 
 $(document).on('mouseleave', '.rating', function(){
  var index = $(this).data("index");
  var post_id = $(this).data('post_id');
  var rating = $(this).data("rating");
  remove_background(post_id);
  //alert(rating);
  for(var count = 1; count<=rating; count++)
  {
   $('#'+post_id+'-'+count).css('color', '#ffcc00');
  }
 });
 


    load_data_materi();

    function load_data_materi()
    {
      var proses = 'load_data_materi';
      $.ajax({
          url:"proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#data_materi').html(data);
          }
      });
    }

});
</script>
</html>