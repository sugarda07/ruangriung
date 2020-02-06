<?php
include('inc/koneksi.php');
session_start();
if(!isset($_SESSION['user_id'])) {
  header("location:login.php");
}

$query = "
SELECT * FROM user 
WHERE user.user_id = '".$_SESSION['user_id']."' 
";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $log)
{
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RuangRIUNG123</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/plugins/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="assets/magnific/css/style.css">
  <link href="assets/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
  <link href="assets/crop/croppie.css" rel="stylesheet">
  <link href="assets/emoji-picker/lib/css/emoji.css" rel="stylesheet">
  <link href="assets/emoji-picker/lib/css/style.css" rel="stylesheet">
  <link href="assets/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue fixed layout-top-nav layout-footer-fixed">
<div class="wrapper">
<?php include "inc/header.php"; ?>

  <!-- Full Width Column -->
  <?php
      if(@$_GET['page'] == '') {
          include "media/home.php";
      } else if(@$_GET['page'] == 'home') {
          include "media/home.php";
      } else if(@$_GET['page'] == 'all_post') {
          include "media/all_post.php";
      } else if(@$_GET['page'] == 'notif') {
          include "media/notif.php";
      } else if(@$_GET['page'] == 'profil') {
          include "media/profil.php";
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
  <!-- /.content-wrapper -->
  <footer class="main-footer" style="padding-bottom: 0px; padding-top: 0px;">
  <div class="row">
  	<table class="table text-center table-responsive" style="margin-bottom: 0px;">
  		<tr>
  			<td style="padding-bottom: 1px;"><a href="?page=home"><button type="button" class="btn btn-block btn-flat btn-link"><label><i class="fa fa-home" style="font-size: 20px;"></i></label></button></a></td>
  			<td style="padding-bottom: 1px;"><a href="?page=all_post"><button type="button" class="btn btn-block btn-flat btn-link"><label><i class="fa fa-search" style="font-size: 20px;"></i></label></button></a></td>
  			<td style="padding-bottom: 1px;"><a href="#"><button type="button" class="btn btn-block btn-flat btn-link"><label for="upload_posting"><i class="fa fa-camera" style="font-size: 20px;"></i></label></button></a></td>
  			<td style="padding-bottom: 1px;" id="view_notification">
          <a href="?page=notif">
            <button type="button" class="btn btn-block btn-flat btn-link">
              <label id="total_notif">

              </label>
            </button>
          </a>
        </td>
  			<td style="vertical-align: middle;"><a href="?page=profil"><button type="button" class="btn btn-block btn-flat btn-link"><?php echo Get_profile_mini($connect, $_SESSION["user_id"]); ?></button></a></td>
  		</tr>
  	</table>
  	</div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<div id="uploadimageModal" class="modal fade vn-modal-slide-left" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa fa-arrow-left" style="margin-left: 15px;"></i></span></button>
        <h4 class="modal-title" style="margin-left: 40px;">Posting Baru</h4>
      </div>
      <div class="modal-body" style="background-color: #000000;">
        <form method="post" id="form_posting_upload">
      <div class="" id="tampil_posting" align="center" style="position: absolute; top: -55px;"></div>        
      <input type="file" name="upload_posting" id="upload_posting" accept=".jpg, .png, .jpeg"  style="display: none;"/>        
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-xs-10" style="padding-left: 12px; padding-right: 0px;">          
            <textarea class="form-control" data-emojiable="true" type="text" name="posting" id="posting" rows="1" placeholder="Tulis yang anda pikirkan..."  style="border-top-left-radius: 9px;border-bottom-left-radius: 9px;"></textarea>

          </div>
          <div class="col-xs-2" style="padding-left: 0px; padding-right: 12px; text-align: right;">
              <button type="submit" name="tombol_post" id="tombol_post" class="btn btn-info btn-block btn-flat posting_crop" style="border-top-right-radius:15px;"><i class="fa fa-paper-plane-o"></i></button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>

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
<script src="assets/plugins/jQuery/jquery-3.4.1.min.js"></script>
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/plugins/jquery-ui/jquery-ui.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<script src="assets/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="assets/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
<script src="assets/crop/croppie.min.js"></script>
<script src="assets/bootstrap/js/jquery.form.js"></script>
<script src="assets/emoji-picker/lib/js/config.js"></script>
<script src="assets/emoji-picker/lib/js/util.js"></script>
<script src="assets/emoji-picker/lib/js/jquery.emojiarea.js"></script>
<script src="assets/emoji-picker/lib/js/emoji-picker.js"></script>
<?php include "inc/jquery.php"; ?>

<script type="text/javascript">
    function play_sound_send() {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'assets/sound/send_message.m4a');
        audioElement.setAttribute('autoplay', 'autoplay');
        audioElement.load();
        audioElement.play()
    }
</script>

<script type="text/javascript">
    function play_sound_message() {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'assets/sound/ptt_middle_fast.m4a');
        audioElement.setAttribute('autoplay', 'autoplay');
        audioElement.load();
        audioElement.play()
    }
</script>



<script type="text/javascript">
  $(function () {
  // Initializes and creates emoji set from sprite sheet
  window.emojiPicker = new EmojiPicker({
      emojiable_selector: '[data-emojiable=true]',
      assetsPath: 'assets/emoji-picker/lib/img/',
      popupButtonClasses: 'fa fa-smile-o',
      display: 'block'
  });
  window.emojiPicker.discover();
  });
</script>

<script>
  $(document).ready(function(){
      
    $('#cari_teman').autocomplete({
      source: "media/cari_teman.php",
      minLength: 1,
      select: function(event, ui)
      {
        $('#cari_teman').val(ui.item.value);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

  });
</script>

<style>
.modal-body {
    position: relative;
    padding: 0px;
    overflow-y: scroll;
    height: 100%;
}

.vn-modal-slide-left .modal-footer {
    bottom: 0;
    left: 0;
    position: fixed;
    right: 0;
    z-index: 1032;
    background-color: #ffffff;
    text-align: left;
  }

.vn-modal-slide-left .modal-dialog {
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    opacity: 1;
    box-shadow: 7px 0 16px 15px rgba(0, 0, 0, 0.6);
}

.vn-modal-slide-left .modal-content {
    position: relative;
    height: 100%;
    border-radius: 0;
    border: 0;
    background-clip: initial;
}

.vn-modal-slide-left .modal-header {
    position: relative;
}

.vn-modal-slide-left .close {
    float: none;
    position: absolute;
    left: 0rem;
    background-color: #fff;
    opacity: 1;
    width: 3.4rem;
    height: 2.4rem;
    top: 18px;
    border-radius: 0.5rem 0 0 0.5rem;
}

.vn-modal-slide-left .close:after {
    position: absolute;
    left: 0;
    top: 0;
    z-index: -1;
    content: "";
    width: 100%;
    height: 100%;
    box-shadow: 7px 0 16px 15px rgba(0, 0, 0, 0.6);
}
</style>

</body>
</html>
<?php 
} ?>