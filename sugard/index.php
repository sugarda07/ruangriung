<?php
include('../koneksi.php');
include('../function.php');
session_start();
if(!isset($_SESSION['id_admin'])) {
  header("location:login_admin.php");
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
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/r16.png">
    <title>RuangDIGITAL</title>
    <!-- Page CSS -->
    <link href="../assets/dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/user-card.css" rel="stylesheet">
    <link href="../assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <link href="../assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="../assets/dist/css/style.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/tab-page.css" rel="stylesheet">
    <!--<link href="../assets/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="../assets/dist/css/pages/tab-page.css" rel="stylesheet">
    <link href="../assets/dist/css/placeholder-loading.min.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/ribbon-page.css" rel="stylesheet">
    <link href="../assets/jquery-mentions-input-master/jquery.mentionsInput.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/stylish-tooltip.css" rel="stylesheet">
    <link href="../assets/node_modules/jqueryui/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="../assets/crop/croppie.css" rel="stylesheet">
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
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        <li class="nav-item">

                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown" id="show_load_pemberitahuan">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="total_notif" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 

                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">Pemberitahuan</div>
                                    </li>
                                    <li>
                                        <div class="message-center" id="load_pemberitahuan">
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center link" href="notif.php"> <strong>Lihat Semua</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="round" style="width: 40px; height: 40px; line-height: 40px;">Y</span> <span class="hidden-md-down">Yeni Siti Anisa &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <a href="#" class="dropdown-item"><i class="mdi mdi-settings"></i>&nbsp;  My Profil</a>
                                <div class="dropdown-divider"></div>
                                <a href="../logout.php" class="dropdown-item"><i class="fa fa-power-off"></i>&nbsp; Logout</a>
                            </div>
                        </li>
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
                        <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="round" style="width: 40px; height: 40px; line-height: 40px;">Y</span> <span class="hide-menu">Yeni Siti Anisa</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="view_profil.php?data=<?php echo $_SESSION["user_id"]; ?>"><i class="ti-user"></i>&nbsp; My Profile</a></li>
                                <li><a href="logout.php"><i class="fa fa-power-off"></i>&nbsp; Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- MENU</li>
                        <li> <a class="waves-effect waves-dark" href="index.php" aria-expanded="false"><i class="ti-home"></i><span class="hide-menu">Home</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="?admin=kelas" aria-expanded="false"><i class="ti-home"></i><span class="hide-menu">Kelas</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="?admin=user_list" aria-expanded="false"><i class="ti-search"></i><span class="hide-menu">Manajemen User</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="?admin=post_list" aria-expanded="false"><i class="ti-image"></i><span class="hide-menu">Postingan</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="?admin=vote_list" aria-expanded="false"><i class="ti-image"></i><span class="hide-menu">Voting</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <?php
            if(@$_GET['admin'] == '') {
                include "beranda.php";
            } else if(@$_GET['admin'] == 'beranda') {
                include "beranda.php";
            } else if(@$_GET['admin'] == 'kelas') {
                include "kelas.php";
            } else if(@$_GET['admin'] == 'user_list') {
                include "user_list.php";
            } else if(@$_GET['admin'] == 'post_list') {
                include "post_list.php";
            } else if(@$_GET['admin'] == 'vote_list') {
                include "vote_list.php";
            } else {
                echo '
                    <div class="error-box">
                        <div class="error-body text-center">
                            <h1>404</h1>
                            <h3 class="text-uppercase">Page Not Found !</h3>
                        </div>                            
                    </div>';
            }
          ?>
        </div>
        <footer class="footer">
            @sugarda3rd 2020
        </footer>
    </div>

<div id="daftar_siswa_modal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="judul_modal">Sekolah</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>        
        <div class="modal-body" id="daftar_siswa">

        </div>        
        <div class="modal-footer">
            <button type="button" class="btn btn-info waves-effect pull-right" data-dismiss="modal">Close</button>
        </div>
      </div>         
    </div>
</div>


    <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="../assets/dist/js/jquery.form.js"></script>
    <script src="../assets/dist/js/jquery.min.js"></script>
    <script src="../assets/node_modules/jqueryui/jquery-ui.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/node_modules/popper/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="../assets/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../assets/dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../assets/dist/js/custom.min.js"></script>
    <script src="../assets/fullscreen_modal/dist/bs-modal-fullscreen.js"></script>
    <script src="../assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="../assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
    <!-- Sweet-Alert  -->
    <script src="../assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script src="../assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script src="../assets/jquery-mentions-input-master/lib/jquery.elastic.js" type="text/javascript"></script>
    <script src="../assets/jquery-mentions-input-master/underscore-min.js" type="text/javascript"></script>
    <script src="../assets/jquery-mentions-input-master/jquery.mentionsInput.js" type="text/javascript"></script>
    <script src="../assets/crop/croppie.min.js"></script>
    <script src="../assets/node_modules/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/dist/angular.min.js"></script>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable();

        vote_data();

          function vote_data()
          {
            $.ajax({
              url:"vote_data.php",
              method:"POST",
              success:function(data){
                $('#vote_data').html(data);
              }
            })
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
         
         $(document).on('click', '.rating', function(){
          var index = $(this).data("index");
          var post_id = $(this).data('post_id');
          var id_admin = $(this).data('id_admin');
          $.ajax({
           url:"rating_insert.php",
           method:"POST",
           data:{index:index, post_id:post_id, id_admin:id_admin},
           success:function(data)
           {
            if(data == 'done')
            {
             vote_data();
             alert("You have rate "+index +" out of 5");
            }
            else
            {
                vote_data();
             alert("There is some problem in System");
            }
           }
          });
          
         });




        kelas_data();

          function kelas_data()
          {
            $.ajax({
              url:"kelas_data.php",
              method:"POST",
              success:function(data){
                $('#data_kelas').html(data);
              }
            })
          }


          user_data();

          function user_data()
          {
            $.ajax({
              url:"user_data.php",
              method:"POST",
              success:function(data){
                $('#user_data').html(data);
              }
            })
          }

          post_data();

          function post_data()
          {
            $.ajax({
              url:"post_data.php",
              method:"POST",
              success:function(data){
                $('#post_data').html(data);
              }
            })
          }

          $(document).on('click', '.delete', function(){
            var post_id = $(this).attr("id");
            if(confirm("Are you sure you want to delete this?"))
            {
              $.ajax({
                url:"post_delete.php",
                method:"POST",
                data:{post_id:post_id},
                success:function(data)
                {
                  post_data();
                }
              });
            }
            else
            {
              return false; 
            }
          });


      $(document).on('click', '.lihat_daftar_siswa', function(){  
         var id = $(this).attr("id");
         var kelas = $(this).data('kelas');  
         if(id != '')  
         {  
            $.ajax({  
                 url:"daftar_siswa.php",  
                 method:"POST",  
                 data:{id:id},  
                 success:function(data){   
                      $('#daftar_siswa').html(data);
                      $('#judul_modal').text("Daftar Siswa "+kelas+"");
                      $('#daftar_siswa_modal').modal('show');  
                 }  
            });  
         }            
      });



    });
</script>
