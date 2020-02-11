<?php

include('../inc/koneksi.php');

session_start();

if(!isset($_SESSION['user_id']))
{
  header('location:../login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chat</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/plugins/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/plugins/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../assets/magnific/css/style.css">
  <link href="../assets/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
  <link href="../assets/crop/croppie.css" rel="stylesheet">
  <link href="../assets/emoji-picker/lib/css/emoji.css" rel="stylesheet">
  <link href="../assets/emoji-picker/lib/css/style.css" rel="stylesheet">
  <link href="../assets/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
  <link href="../assets/sweetalert2/sweetalert.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/emoji-picker/emojionearea.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue fixed layout-top-nav layout-footer-fixed">
<div class="wrapper" id="user_model_details">
  <!-- Full Width Column -->
    <?php
      if(@$_GET['chat'] == '') {
          include "chat_list.php";
      } else if(@$_GET['chat'] == 'chat_list') {
          include "chat_list.php";
      } else {
          echo '
              <div class="error-box">
                  <div class="error-body text-center">
                      <h1>404</h1>
                      <h3 class="text-uppercase">Belum ada Pesan</h3>
                  </div>                            
              </div>';
          } ?>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<style>
  .layout-footer-fixed .wrapper .main-footer {
    bottom: 0;
    left: 0;
    position: fixed;
    right: 0;
    z-index: 1032;
  }

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

<!-- jQuery 2.2.3 -->
<script src="../assets/plugins/jQuery/jquery-3.4.1.min.js"></script>
<script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../assets/plugins/jquery-ui/jquery-ui.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../assets/dist/js/demo.js"></script>
<script src="../assets/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="../assets/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
<script src="../assets/crop/croppie.min.js"></script>
<script src="../assets/bootstrap/js/jquery.form.js"></script>
<script src="../assets/emoji-picker/lib/js/config.js"></script>
<script src="../assets/emoji-picker/lib/js/util.js"></script>
<script src="../assets/emoji-picker/lib/js/jquery.emojiarea.js"></script>
<script src="../assets/emoji-picker/lib/js/emoji-picker.js"></script>
<script src="../assets/sweetalert2/sweetalert.min.js"></script>
<script src="../assets/emoji-picker/emojionearea.min.js"></script>
</body>
</html>

<script type="text/javascript">
  $(function () {
  // Initializes and creates emoji set from sprite sheet
  window.emojiPicker = new EmojiPicker({
      emojiable_selector: '[data-emojiable=true]',
      assetsPath: '../assets/emoji-picker/lib/img/',
      popupButtonClasses: 'fa fa-smile-o',
      display: 'block'
  });
  window.emojiPicker.discover();
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
     $.ajax({
          url:'list_chat.php',
          method:"POST",
          success:function(data)
          {
              $('#chat_list').html(data);
          }
     })
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
	var konten =	'<header class="main-header">';

  konten +=         '<nav class="navbar navbar-static-top" style="background-color: #4e48da;">';
  konten +=           '<div class="container">';
  konten +=             '<div class="navbar-custom-menu pull-left">';
  konten +=                '<ul class="nav navbar-nav">';
  konten +=                  '<li><a href="?chat=chat_list"><i class="fa fa-arrow-left"></i></a></li>';
  konten +=                  '<li class="user user-menu" id="user_dialog_'+to_user_id+'">';
  konten +=                     '<a href="#" style="padding-bottom: 8px; padding-top: 8px; padding-left: 5px;">';
  konten +=                       '<img src="'+to_foto+'" class="user-image" alt="User Image" style="margin-top: 0px; margin-right: 5px; width: 35px;height: 35px;">';
  konten +=                         '<span id="get_nama_depan">';
  konten +=                       Get_nama_depan(to_user_id);
  konten +=                          '</span>';
  konten +=                     '</a>';
  konten +=                  '</li>';
  konten +=                '</ul>';
  konten +=              '</div>';
  konten +=            '</div>';
  konten +=         '</nav>';
	konten +=		'</header>';
  konten += '<div class="content-wrapper" style="background: #ffffff; padding-top: 58px; padding-bottom: 58px;">';
  konten += '<section class="content" style="padding-left: 0px; padding-right: 0px;">';
  konten +=     '<div class="row" style="margin-right: 0px; margin-left: 0px;">';
  konten +=       '<div class="col-md-12 chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  konten +=           fetch_user_chat_history(to_user_id);
  konten +=       '</div>';
  konten +=     '</div>';
  konten +=   '</section>';
  konten += '</div>';
  konten += '<footer class="main-footer">';
  konten += '<div class="row">';
  konten +=      '<div class="col-xs-10" style="padding-left: 12px; padding-right: 0px;">'   ;       
  konten +=        '<textarea rows="1" name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" placeholder="Type Message ..." class="form-control chat_message" type="text" style="border-radius: 15px;"></textarea>';
  konten +=      '</div>';
  konten +=      '<div class="col-xs-2" style="padding-left: 0px; padding-right: 12px; text-align: right;">';
  konten +=          '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-primary send_chat" style="background-color: #4e48da; border-color: #4e48da; border-radius: 50px;"><i class="fa fa-paper-plane-o">  </i></button>';
  konten +=      '</div>';
  konten +=    '</div>';
  konten += '</footer>';
  $('#user_model_details').html(konten);
  }

  $(document).on('click', '.start_chat', function(){
    var to_user_id = $(this).data('touserid');
    var to_user_name = $(this).data('tousername');
    var to_foto = $(this).data('foto');
    make_chat_dialog_box(to_user_id, to_user_name, to_foto);

    $('#user_dialog_'+to_user_id).data('open');
    $('#chat_message_'+to_user_id).emojioneArea({
      pickerPosition:"top",
      toneStyle: "bullet"
    });
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
          var element = $('#chat_message_'+to_user_id).emojioneArea();
          element[0].emojioneArea.setText('');
          $('#chat_history_'+to_user_id).html(data);
          $('html, body').animate({ scrollTop: 100000 }, 'fast');
          play_sound_send()
          document.getElementById('chat_message_'+to_user_id+'').focus();
        }
      })
    }
    else
    {
      document.getElementById('chat_message_'+to_user_id+'').focus();
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

  $(document).on('click', '.remove_chat', function(){
    var chat_message_id = $(this).attr('id');
    if(confirm("Are you sure you want to remove this chat?"))
    {
      $.ajax({
        url:"remove_chat.php",
        method:"POST",
        data:{chat_message_id:chat_message_id},
        success:function(data)
        {
          update_chat_history_data();
        }
      })
    }
  });


});
</script>


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