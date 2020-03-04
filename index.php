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
                        <li class="nav-item dropdown">
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
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo Get_profile_image($connect, $_SESSION["user_id"]); ?> <span class="hidden-md-down"><?php echo Get_nama_user($connect, $_SESSION["user_id"]); ?> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <a href="view_profil.php?data=<?php echo $_SESSION["user_id"]; ?>" class="dropdown-item"><i class="mdi mdi-settings"></i>&nbsp;  My Profil</a>
                                <div class="dropdown-divider"></div>
                                <a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i>&nbsp; Logout</a>
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
                        <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><?php echo Get_profile_image($connect, $_SESSION["user_id"]); ?><span class="hide-menu"><?php echo Get_nama_user($connect, $_SESSION["user_id"]); ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="view_profil.php?data=<?php echo $_SESSION["user_id"]; ?>"><i class="ti-user"></i>&nbsp; My Profile</a></li>
                                <li><a href="logout.php"><i class="fa fa-power-off"></i>&nbsp; Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- MENU</li>
                        <li> <a class="waves-effect waves-dark" href="index.php" aria-expanded="false"><i class="ti-home"></i><span class="hide-menu">Home</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="hashtag.php" aria-expanded="false"><i class="ti-search"></i><span class="hide-menu">Cari</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="post_all.php" aria-expanded="false"><i class="ti-image"></i><span class="hide-menu">Postingan</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="pesan/index.php" aria-expanded="false"><i class="ti-comments"></i><span class="hide-menu">Pesan</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-pencil-alt"></i><span class="hide-menu">Artikel</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card" style="margin-bottom: 5px;margin-top: 5px;">
                            <div class="card-body" style="padding: 5px;">
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img"  style="margin-bottom: 0px;"><?php echo Get_profile_image($connect, $_SESSION["user_id"]); ?>                                                
                                            </div>
                                            <div class="mail-contnet"  style="width: 80%;">
                                                <span class="mail-desc">
                                                    <button class="btn btn-block btn-rounded btn-secondary" data-toggle="modal" data-target="#postingan_baru_modal">Tuliskan sesuatu disini...</butoon>
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>

                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                        <div class="card">
                            <!-- Nav tabs -->
                            <div class="card-body" style="padding: 5px;">
                                <div class="profiletimeline" id="postingan_list">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->


<div id="postingan_baru_modal" class="modal modal-fullscreen" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;">
            <div class="modal-header">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" id="myLargeModalLabel" style="padding-left: 25px;">Postingan Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
            <form method="post" id="posting_form">
                <div class="modal-body" style="background-color: #000000e6;">
                    <p align="center" style="margin-bottom: 0px;">
                        <div class="row el-element-overlay" style="margin-right: 0px; margin-left: 0px;">
                            <div class="card" style="margin-bottom: 0px;">
                                <div class="el-card-item" style="padding-bottom: 0px;">
                                    <div class="el-card-avatar el-overlay-1" style="margin-bottom: 0px;">
                                        <img id="image_preview" src="data/akun/profil/user.png" alt="user" />
                                        <div class="el-overlay">
                                            <ul class="el-info">
                                                <input type="file" id="uploadFile" name="uploadFile" style="display: none;" />
                                                <li><a class="btn default btn-outline" href="javascript:changeProfile()"><i class="icon-magnifier"></i></a></li>
                                                <li><a class="btn default btn-outline" href="javascript:removeImage()"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <textarea class="form-control mention" type="text" rows="3" name="posting_konten" id="posting_konten" placeholder="Tulis sesuatu ..."  style="border-radius: 9px;"></textarea>
                    <input type="hidden" name="proses" value="insert"/>
                    <button type="submit" name="share_post" id="share_post" class="btn btn-info waves-effect waves-light">Post </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
            </div>
        </div>
        <footer class="footer hidden-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; padding: 0px; margin-left: 0px;">
            <div class="row" style="margin-left: 0px; margin-right: 0px;">
                <div class="col-3" style="padding: 10px">
                    <a href="index.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="fa fa-home" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                </div>
                <div class="col-3" style="padding: 10px">
                    <a href="post_all.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="ti-search" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                </div>
                <div class="col-3" style="padding: 10px">
                    <a href="hashtag.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="fa fa-heart-o" style="font-size: 20px; color: #03a9f3;"></i></button></a>
                </div>
                <div class="col-3" style="padding: 10px">
                    <a href="pesan/index.php" aria-haspopup="true" aria-expanded="false"><button type="button" class="btn btn-block btn-flat btn-link" id="total_notif_chat">
                        
                    </button></a>
                </div>
            </div>
        </footer>
    </div>
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

    function changeProfile() {
        $('#uploadFile').click();
    }

    $('#uploadFile').change(function () {
        var imgPath = this.value;
        var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        if (ext == "png" || ext == "jpeg" || ext == "gif" || ext == "jpg")
            readURL(this);
        else
            swal("File tidak didukung!", "silahkan pilih jenis file (png, jpeg, jpg).")
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = function (e) {
                $('#image_preview').attr('src', e.target.result);
            };
        }
    }

    function removeImage() {
        $('#image_preview').attr('src', 'data/akun/profil/user.png');
        $('#uploadFile').val('');
    }

</script>


<script>
$(function () {
    $('textarea.mention').mentionsInput({
        onDataRequest:function (mode, query, callback) {
            $.getJSON('get_users_json.php', function(responseData) {
            responseData = _.filter(responseData, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });
            callback.call(this, responseData);
            });
        }
    });
});
</script>


<script>
$(document).ready(function () {
    $(document).on('click', '.hover', function (e) {
        e.preventDefault();
            $('.hover').tooltip({
               title: fetchData,
               html: true,
               placement: 'right'
              });
            function fetchData()
              {
               var fetch_data = '';
               var element = $(this);
               var id = element.attr("id");
               $.ajax({
                url:"tooltip.php",
                method:"POST",
                async: false,
                data:{id:id},
                success:function(data)
                {
                 fetch_data = data;
                }
               });   
               return fetch_data;
              }
    });

});

 </script>

<script>
$(document).ready(function(){  

    postingan_post();
    function postingan_post()
    {
     var proses = 'postingan_post';
     $.ajax({
          url:'proses.php',
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
            $('#postingan_list').html(data);
          }
     });
    }

    load_pemberitahuan();

    function load_pemberitahuan()
    {
        var proses = 'load_pemberitahuan';
        $.ajax({
            url:"proses.php",
            method:"POST",
            data:{proses:proses},
            success:function(data)
            {
                $('#load_pemberitahuan').html(data);
            }
        });
    }


    $('#posting_form').on('submit', function(event){
        event.preventDefault();

        if($('#posting_konten').val() == '')
        {
            $('#posting_konten').focus();
            //swal("Form kosong!", "Tulis yang Anda pikirkan...")
        }
        else
        {
            $.ajax({
                url:"proses.php",
                method:"POST",
                data:new FormData(this),
                  contentType:false,
                  cache:false,
                  processData:false,
                beforeSend:function()
                {
                    $('#share_post').attr('disabled', 'disabled');
                },
                success:function(data)
                {
                  $('#postingan_baru_modal').modal('hide');
                  $('#posting_form')[0].reset();
                  $('#posting_konten').val('');
                  $('#uploadFile').val('');
                  $("textarea.mention").mentionsInput('reset');
                  removeImage();
                  postingan_post();
                }
            })
        }
    });


    $(document).on('click', '.like_button', function(){
        var post_id = $(this).data('post_id');
        var proses = 'like';
        $.ajax({
            url:"proses.php",
            method:"POST",
            data:{post_id:post_id, proses:proses},
            success:function(data)
            {
                postingan_post();
            }
        })
    });


    $(document).on('click', '.post_comment', function(){
        post_id = $(this).attr('id');
        user_id = $(this).data('user_id');
        var proses = 'fetch_comment';
        $.ajax({
            url:"proses.php",
            method:"POST",
            data:{post_id:post_id, user_id:user_id, proses:proses},
            success:function(data){
                $('#old_comment'+post_id).html(data);
                $('#comment_form'+post_id).modal('show');
            }
        })      
    });


    $(document).on('click', '.submit_comment', function(){
        var comment = $('#comment'+post_id).val();
        var proses = 'submit_comment';
        var receiver_id = user_id;
        if(comment != '')
        {
            $.ajax({
                url:"proses.php",
                method:"POST",
                data:{post_id:post_id,receiver_id:receiver_id,comment:comment,proses:proses},
                success:function(data)
                {
                    $('#comment_form'+post_id).modal('hide');
                    postingan_post();
                }
            })
        }
    });


  load_total_notif();

  function load_total_notif()
  {
      var proses = 'load_total_notif';
      $.ajax({
          url:"proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#total_notif').html(data);
          }
      });
  }

  $('#total_notif').click(function(){
        var proses = 'update_notification_status';
        $.ajax({
            url:"proses.php",
            method:"post",
            data:{proses:proses},
            success:function(data)
            {
                $('#total_notifikasi').remove();
            }
        })
    });


    total_notif_chat();

    function total_notif_chat()
    {
      var proses = 'total_notif_chat';
      $.ajax({
          url:"proses.php",
          method:"POST",
          data:{proses:proses},
          success:function(data)
          {
              $('#total_notif_chat').html(data);
          }
      });
    }

    setInterval(function(){
    //postingan_post();
    load_total_notif();
    total_notif_chat();
  }, 5000);


});
</script>
</html>