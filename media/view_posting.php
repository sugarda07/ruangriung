<?php
include('../inc/koneksi.php');

session_start();

if(!isset($_SESSION['user_id']))
{
  header('location:../login.php');
}

$user_id = Get_user_id($connect, $_GET["data"]);
$query_post = "
SELECT * FROM postingan
JOIN user ON postingan.post_id = '".$_GET["data"]."'
WHERE postingan.user_id = user.user_id
ORDER BY postingan.post_id DESC
";

$statement = $connect->prepare($query_post);
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
  <title>AdminLTE 2 | Top Navigation</title>
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

    <div class="content-wrapper" style="padding-top: 58px; padding-bottom: 58px;">
      <div class="container">
          <div class="row">

            <div class="col-md-6" id="view_allposting" style="padding-left: 0px; padding-right: 0px;">
              
            </div>
          </div>
      </div>
  </div>


  </div>
</body>

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

  view_allposting();

  function view_allposting()
  {
     var post_id = '<?php echo $_GET["data"];?>';
     var proses = 'posting_all';
     $.ajax({
          url:'view_all_post_proses.php',
          method:"POST",
          data:{proses:proses, post_id:post_id},
          success:function(data)
          {
              $('#view_allposting').html(data);
          }
     })
  }


  var post_id;
  var user_id;

  $(document).on('click', '.post_comment', function(){
      post_id = $(this).attr('id');
      user_id = $(this).data('user_id');
      var proses = 'fetch_comment';
      $.ajax({
          url:"view_all_post_proses.php",
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
                url:"view_all_post_proses.php",
                method:"POST",
                data:{post_id:post_id,receiver_id:receiver_id,comment:comment,proses:proses},
                success:function(data)
                {
                    $('#comment_form'+post_id).slideUp('slow');
                    view_allposting();
                }
            })
        }
    });

  $(document).on('click', '.like_button', function(){
        var post_id = $(this).data('post_id');
        var proses = 'like';
        $.ajax({
            url:"view_all_post_proses.php",
            method:"POST",
            data:{post_id:post_id, proses:proses},
            success:function(data)
            {
                view_allposting();
            }
        })
    });

});
</script>


</html>