<?php
include('../inc/koneksi.php');

session_start();

if(!isset($_SESSION['user_id']))
{
  header('location:../login.php');
}

$user_id = Get_user_id($connect, $_GET["data"]);
$query_cari = "
SELECT * FROM user 
WHERE user.user_id = '".$_GET["data"]."' 
";

$statement = $connect->prepare($query_cari);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row) 
{
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RuangRIUNG</title>
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
    <header class="main-header">
      <nav class="navbar navbar-static-top" style="background-color: #4e48da;">
        <div class="container">
          <div class="navbar-custom-menu pull-left">
            <ul class="nav navbar-nav">
              <li><a href="javascript: history.go(-1)"><i class="fa fa-arrow-left"></i></a></li>
                <li class="user user-menu">
                <a href="#" style="padding-bottom: 8px; padding-top: 8px; padding-left: 5px;">
                  <?php 
                    if($row['profile_image'] != '')
                      {
                        echo '<img src="../images/profile_image/'.$row['profile_image'].'" class="user-image" alt="User Image" style="margin-top: 0px; margin-right: 5px; width: 35px;height: 35px;">';
                      }
                      else
                      {
                        echo  '<img src="../images/profile_image/user.png" class="user-image" alt="User Image" style="margin-top: 0px; margin-right: 5px; width: 35px;height: 35px;">';
                      }                        
                  ?>            
                  <span><?php echo $row["nama_depan"];?></span>
                </a>
                </li>
            </ul>
          </div>
        </div>
        <!-- /.container-fluid -->
      </nav>
    </header>

    <div class="content-wrapper" style="padding-top: 60px; padding-bottom: 60px;">
      <div class="container">
          <div class="row">
            <div class="col-md-4" style="padding-left: 0px; padding-right: 0px; padding-bottom: 10px;">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user" style="margin-bottom: 0px;">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div>
                    <?php 
                      if($row['back_profile'] != '')
                      {
                        $back_profile = '<div class="widget-user-header bg-black" style="background: url(../images/back/'.$row['back_profile'].') round; height: 140px;">';
                      }
                      else
                      {
                        $back_profile = '<div class="widget-user-header bg-black" style="background: url(../images/back/background.jpg) round; height: 140px;">';
                      }
                      echo '
                      '.$back_profile.'
                      </div>
                      ';
                    ?>
                </div>
                <div class="widget-user-image" style="top:88px;">
                    <?php
                        if($row['profile_image'] != '')
                        {
                          $foto_profile = '<img class="img-circle" src="../images/profile_image/'.$row["profile_image"].'" alt="User Avatar">';
                        }
                        else
                        {
                          $foto_profile = '<img class="img-circle" src="../images/profile_image/user.png" alt="User Avatar">';
                        }
                        echo $foto_profile;
                    ?>
                </div>
                <div class="box-footer">
                  <div class="col-xs-12">
                    <div class="description-block" style="margin-top: 20px;">
                      <h5 class="description-header"><a href="#" data-toggle="modal" data-target="#edit_profilModal" title="Klik untuk edit data"><?php echo $row['nama_depan']; ?></a></h5>
                      <span class="description"><?php echo $row['nama_belakang']; ?></span>
                    </div>
                  </div>                  
                <div class="row">
                  <div class="col-xs-12" id="tombol_follow_profil_cari">

                  </div>
                </div>
                  <div class="row">
                    <div class="col-xs-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header"><a href="#" data-toggle="modal" data-target="#pengikut_profil_cari_modal"><?php echo $row["follower_number"];?></a></h5>
                        <span class="description">Pengikut</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header"><a href="#" ><?php echo count_postingan($connect, $row["user_id"]); ?></a></h5>
                        <span class="description">Post</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                      <div class="description-block">
                        <h5 class="description-header"><a href="#" data-toggle="modal" data-target="#mengikuti_profil_cari_modal"><?php echo count_mengikuti($connect, $row["user_id"]); ?></a></h5>
                        <span class="description">Mengikuti</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>                
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#"><i class="fa fa-graduation-cap"></i>&nbsp;&nbsp;<?php echo $row["sekolah"]; ?> <span class="pull-right badge bg-green"></span></a></li>
                    <li><a href="#"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo $row["kelas"]; ?> <span class="pull-right badge bg-green"></span></a></li>
                  </ul>
                </div>
              </div>
              <!-- /.widget-user -->
            </div>

            <div class="col-md-8" id="view_posting" style="padding-left: 0px; padding-right: 0px;">
              
            </div>
          </div>
      </div>
  </div>


  </div>
</body>

<div id="pengikut_profil_cari_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><small>Pengikut</small> <b><?php echo $row['nama_depan']; ?></b></h4>
      </div>
      <div class="modal-body">
        <div class="box box-widget" id="pengikut_list_profil_cari" style="margin-bottom: 0px; box-shadow: none;">
        
        </div>
      </div>
    </div>
  </div>
</div>


<div id="mengikuti_profil_cari_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><b><?php echo $row['nama_depan']; ?></b> <small>mengikuti</small></h4>
      </div>
      <div class="modal-body">
        <div class="box box-widget" id="mengikuti_list_profil_cari" style="margin-bottom: 0px; box-shadow: none;">
        
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.modal-body {
    position: relative;
    padding: 0px;
    overflow-y: scroll;
    height: 100%;
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
<script src="../assets/crop/croppie.js"></script>
<script src="../assets/bootstrap/js/jquery.form.js"></script>
<script src="../assets/emoji-picker/lib/js/config.js"></script>
<script src="../assets/emoji-picker/lib/js/util.js"></script>
<script src="../assets/emoji-picker/lib/js/jquery.emojiarea.js"></script>
<script src="../assets/emoji-picker/lib/js/emoji-picker.js"></script>
<?php } ?>
<script>
$(document).ready(function(){

  view_posting();

  function view_posting()
  {
     var user_id = '<?php echo $_GET["data"];?>';
     var proses = 'posting_profil';
     $.ajax({
          url:'view_post.php',
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#view_posting').html(data);
          }
     })
  }


    $(document).on('click', '.action_button', function(){
        var sender_id = $(this).data('sender_id');
        var proses = $(this).data('proses');
        $.ajax({
            url:"view_post.php",
            method:"POST",
            data:{sender_id:sender_id, proses:proses},
            success:function(data)
            {
                pengikut_profil_cari();
                mengikuti_profil_cari();
                tombol_follow_profil_cari();
            }
        })
    });

  var post_id;
  var user_id;

  $(document).on('click', '.post_comment', function(){
      post_id = $(this).attr('id');
      user_id = $(this).data('user_id');
      var proses = 'fetch_comment';
      $.ajax({
          url:"view_post.php",
          method:"POST",
          data:{post_id:post_id, user_id:user_id, proses:proses},
          success:function(data){
              $('#old_comment'+post_id).html(data);
              $('#comment_form'+post_id).slideToggle('slow');
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
                url:"view_post.php",
                method:"POST",
                data:{post_id:post_id,receiver_id:receiver_id,comment:comment,proses:proses},
                success:function(data)
                {
                    $('#comment_form'+post_id).slideUp('slow');
                    view_posting();
                }
            })
        }
    });

  $(document).on('click', '.like_button', function(){
        var post_id = $(this).data('post_id');
        var proses = 'like';
        $.ajax({
            url:"view_post.php",
            method:"POST",
            data:{post_id:post_id, proses:proses},
            success:function(data)
            {
                view_posting();
            }
        })
    });


  pengikut_profil_cari();

  function pengikut_profil_cari()
  {
      var user_id = <?php echo $_GET["data"] ?>;
      var proses = 'pengikut_profil_cari';
      $.ajax({
          url:"view_post_profil.php",
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#pengikut_list_profil_cari').html(data);
          }
      });
  }

  mengikuti_profil_cari();

  function mengikuti_profil_cari()
  {
      var user_id = <?php echo $_GET["data"] ?>;
      var proses = 'mengikuti_profil_cari';
      $.ajax({
          url:"view_post_profil.php",
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#mengikuti_list_profil_cari').html(data);
          }
      });
  }


  tombol_follow_profil_cari();

  function tombol_follow_profil_cari()
  {
      var user_id = <?php echo $_GET["data"] ?>;
      var proses = 'tombol_follow_profil_cari';
      $.ajax({
          url:"view_post_profil.php",
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#tombol_follow_profil_cari').html(data);
          }
      });
  }

});
</script>


</html>