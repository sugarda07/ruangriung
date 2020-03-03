<?php
include('../koneksi.php');
include('../function.php');
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
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/r16.png">
    <title>RuangDIGITAL</title>
    <!-- Page CSS -->
    <link href="../assets/dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/user-card.css" rel="stylesheet">
    <link href="../assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <link href="../assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="../assets/dist/css/style.css" rel="stylesheet">
    <link href="../assets/node_modules/jqueryui/jquery-ui.min.css" rel="stylesheet">
    <!--<link href="assets/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<style type="text/css">
      .ui-autocomplete-row
      {
        padding:8px;
        background-color: #f4f4f4;
        border-bottom:1px solid #ccc;
        font-weight:bold;
      }
      .ui-autocomplete-row:hover
      {
        background-color: #ddd;
      }
    </style>

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
    <div id="user_model_details">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                    	<li class="nav-item"> <a class="nav-link" href="../index.php"><i class="fa fa-arrow-left"></i></a> </li>
                        <li class="nav-item" style="padding-top: 3px;">
                            <form class="app-search d-md-block d-lg-block">
                                <input type="text" id="cari_kontak" name="cari_kontak" class="form-control" placeholder="cari kontak" aria-label="Search" autocomplete="off">
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        
                    </ul>
                </div>
            </nav>
        </header>
        <div class="page-wrapper" style="background-color: white;">
            <div class="container-fluid" style="padding: 5px;">
                <div class="row">
                    <div class="col-lg-12 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                    	<div class="card">
	                        <div class="card-body" style="padding: 9px;">
	                            <div class="message-box">
	                                <div class="message-widget message-scroll" id="chat_list">

	                                </div>
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
              <a href="../index.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="icon-home" style="font-size: 20px; color: #03a9f3;"></i></button></a>
            </div>
            <div class="col-3" style="padding: 10px">
              <a href="../post_all.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="ti-search" style="font-size: 20px; color: #03a9f3;"></i></button></a>
            </div>
            <div class="col-3" style="padding: 10px">
              <a href="../hashtag.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="fa fa-heart-o" style="font-size: 20px; color: #03a9f3;"></i></button></a>
            </div>
            <div class="col-3" style="padding: 10px">
              <a href="index.php"><button type="button" class="btn btn-block btn-flat btn-link"><i class="fa fa-envelope" style="font-size: 20px; color: #03a9f3;"></i></button></a>
            </div>
          </div>
        </footer>
    </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="../assets/node_modules/jqueryui/jquery-ui.min.js"></script>
    <script src="../assets/dist/js/jquery.form.js"></script>
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
</body>




<script>
  $(document).ready(function(){
      
    $('#cari_kontak').autocomplete({
      source: "cari_kontak.php",
      minLength: 1,
      select: function(event, ui)
      {
        $('#cari_kontak').val(ui.item.value);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

  });
</script>

<script>
$(document).ready(function(){

  setInterval(function(){
    update_last_activity();
    list_chat();
    update_chat_history_data();
  }, 5000);

	list_chat()

	function list_chat()
    {
     	var proses = 'list_chat';
     	$.ajax({
          	url:'../proses.php',
          	method:"POST",
          	data:{proses:proses},
          	success:function(data)
          	{
            	$('#chat_list').html(data);
          	}
     	});
    }

    function update_last_activity()
    {
        $.ajax({
            url:"update_last_activity.php",
            success:function()
            {

            }
        })
    }


    function make_chat_dialog_box(to_user_id, to_user_name, to_foto)
    {
        var konten =    '<header id="user_dialog_'+to_user_id+'" class="topbar">';
        konten +=           '<nav class="navbar top-navbar navbar-expand-md navbar-dark">';
        konten +=               '<div class="navbar-collapse">';
        konten +=               '<ul class="navbar-nav mr-auto">';
        konten +=                   '<li class="nav-item"> <a class="nav-link" href="index.php"><i class="fa fa-arrow-left"></i></a> </li>';
        konten +=                   '<li class="nav-item dropdown u-pro">';
        konten +=                       '<a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left: 0px;"><img src="'+to_foto+'" alt="user" style="width: 40px;"> <span class="username" id="get_nama_depan" style="color: white;">';
        konten +=                   Get_nama_depan(to_user_id);
        konten +=                   '</span>&nbsp;<i class="fa fa-angle-down"></i></a>';
        konten +=                       '<div class="dropdown-menu dropdown-menu-right animated flipInY">';
        konten +=                           '<a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> Profile</a>';
        konten +=                       '</div>';
        konten +=                   '</li>';
        konten +=                   '<li class="nav-item" style="padding-top: 3px;">';

        konten +=                   '</li>';
        konten +=               '</ul>';
        konten +=               '<ul class="navbar-nav my-lg-0">';

        konten +=               '</ul>';
        konten +=           '</div>';
        konten +=       '</nav>';
        konten +=   '</header>';
        konten +=   '<div class="page-wrapper" style="background-color: white;">';
        konten +=       '<div class="container-fluid" style="padding: 5px;">';
        konten +=           '<div class="row">';
        konten +=               '<div class="col-lg-12 col-xlg-9 col-md-7">';
        konten +=                  '<div class="card" style="background-color: aqua;margin-bottom: 0px;">';
        konten +=                       '<div class="card-body">';
        konten +=                           '<div class="chat-box">';
        konten +=                               '<ul class="chat-list chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
        konten +=                               fetch_user_chat_history(to_user_id);
        konten +=                               '</ul>';
        konten +=                            '</div>';
        konten +=                       '</div>';
        konten +=                   '</div>';                        
        konten +=               '</div>';
        konten +=           '</div>';
        konten +=        '</div>';
        konten +=   '</div>';
        konten +=   '<footer class="footer" style="position: fixed; margin-left: 0px; padding: 10px; background: #00ffff00; border-top-width: 0px;">';
        konten += '<div class="row">';
        konten +=      '<div class="col-10" style="padding-right: 5px;">'   ;       
        konten +=        '<textarea rows="1" name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" placeholder="Tulis pesan ..." class="form-control chat_message" type="text" style="border-radius: 15px;"></textarea>';
        konten +=      '</div>';
        konten +=      '<div class="col-2 text-right" style="padding-left: 5px; padding-right: 15px;">';
        konten +=          '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-primary btn-circle btn-xs send_chat" style="background-color: #4e48da; border-color: #4e48da; border-radius: 50px;"><i class="mdi mdi-send">  </i></button>';
        konten +=      '</div>';
        konten +=    '</div>';
        konten +=   '</footer>';
        $('#user_model_details').html(konten);
    }

  $(document).on('click', '.start_chat', function(){
    var to_user_id = $(this).data('touserid');
    var to_user_name = $(this).data('tousername');
    var to_foto = $(this).data('foto');
    make_chat_dialog_box(to_user_id, to_user_name, to_foto);

    $('#user_dialog_'+to_user_id).data('open');
    $('html, body').animate({ scrollTop: 100000 }, 'fast');
    document.getElementById('chat_message_'+to_user_id+'').focus();
  });

  $(document).on('click', '.send_chat', function(){
    var to_user_id = $(this).attr('id');
    var chat_message = $.trim($('#chat_message_'+to_user_id).val());
    if(chat_message != '')
    {
      $.ajax({
        url:"insert_chat.php",
        method:"POST",
        data:{to_user_id:to_user_id, chat_message:chat_message},
        success:function(data)
        {
            $('#chat_message_'+to_user_id).val('');
          $('#chat_history_'+to_user_id).html(data);
          $('html, body').animate({ scrollTop: 100000 }, 'fast');
          play_sound_send()
          $('chat_message_'+to_user_id+'').focus();
        }
      })
    }
    else
    {
      $('chat_message_'+to_user_id+'').focus();
    }
  });

  function fetch_user_chat_history(to_user_id)
  {
    $.ajax({
      url:"fetch_user_chat_history.php",
      method:"POST",
      data:{to_user_id:to_user_id},
      success:function(data){
        $('#chat_history_'+to_user_id).html(data);
      }
    })
  }

  function Get_nama_depan(to_user_id)
  {
    $.ajax({
      url:"fetch_nama_depan.php",
      method:"POST",
      data:{to_user_id:to_user_id},
      success:function(data){
        $('#get_nama_depan').html(data);
      }
    })
  }

  function update_chat_history_data()
  {
    $('.chat_history').each(function(){
      var to_user_id = $(this).data('touserid');
      fetch_user_chat_history(to_user_id);
    });
  }

  $(document).on('focus', '.chat_message', function(){
    var is_type = 'yes';
    $.ajax({
      url:"update_is_type_status.php",
      method:"POST",
      data:{is_type:is_type},
      success:function()
      {

      }
    })
  });

  $(document).on('blur', '.chat_message', function(){
    var is_type = 'no';
    $.ajax({
      url:"update_is_type_status.php",
      method:"POST",
      data:{is_type:is_type},
      success:function()
      {
        
      }
    })
  });


  $(document).on('dblclick', '.remove_chat', function(){ 
      var chat_message_id = $(this).attr('id');

      swal({
        title: "Anda Yakin?",
        text: "Postingan ini akan di hapus",
        type: "warning",
        showCancelButton: true,
        cancleButtonText: "Batal",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Hapus",
        closeOnConfirm: false
      },
      function(){
        $.ajax({
            url:"remove_chat.php",
            method:"POST",
            data:{chat_message_id:chat_message_id},
            success: function(data){
                swal({
                    title : "Pesan",
                    text: "Berhasil di Hapus",
                    type: "success",
                    timer: 5000
                });
            update_chat_history_data();
            }
        });        
      });
    });




});
</script>

<script type="text/javascript">
    function play_sound_send() {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '../assets/sound/send_message.m4a');
        audioElement.setAttribute('autoplay', 'autoplay');
        audioElement.load();
        audioElement.play()
    }
</script>

<script type="text/javascript">
    function play_sound_message() {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '../assets/sound/ptt_middle_fast.m4a');
        audioElement.setAttribute('autoplay', 'autoplay');
        audioElement.load();
        audioElement.play()
    }
</script>

</html>