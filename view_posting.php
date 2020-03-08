<?php
include('koneksi.php');
include('function.php');
session_start();
if(!isset($_SESSION['user_id'])) {
  header("location:login.php");
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/r16.png">
    <title>RuangDIGITAL</title>
    <link href="assets/dist/css/pages/user-card.css" rel="stylesheet">
    <link href="assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <link href="assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="assets/dist/css/style.css" rel="stylesheet">
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
                              <div class="profiletimeline" id="view_posting">
                                    
                              </div>
	                        </div>
	                    </div>                        
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer" align="center" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; margin-left: 0px;">
          © 2020 RuangDIGITAL by @sugarda3rd
        </footer>
    </div>
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/dist/js/jquery.form.js"></script>
    <script src="assets/dist/js/jquery.min.js"></script>
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/dist/js/waves.js"></script>
    <script src="assets/dist/js/sidebarmenu.js"></script>
    <script src="assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/dist/js/custom.min.js"></script>
    <script src="assets/fullscreen_modal/dist/bs-modal-fullscreen.js"></script>
    <script src="assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
    <script src="assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script src="assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>
</body>


<script>
$(document).ready(function(){  

  view_posting();

  function view_posting()
  {
     var post_id = '<?php echo $_GET["data"];?>';
     var proses = 'view_posting';
     $.ajax({
          url:'view_posting_proses.php',
          method:"POST",
          data:{proses:proses, post_id:post_id},
          success:function(data)
          {
              $('#view_posting').html(data);
          }
     })
  }

  $(document).on('click', '.like_button', function(){
        var post_id = $(this).data('post_id');
        var proses = 'like';
        $.ajax({
            url:"view_posting_proses.php",
            method:"POST",
            data:{post_id:post_id, proses:proses},
            success:function(data)
            {
                view_posting();
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
            url:"view_posting_proses.php",
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
                url:"view_posting_proses.php",
                method:"POST",
                data:{post_id:post_id,receiver_id:receiver_id,comment:comment,proses:proses},
                success:function(data)
                {
                    $('#comment_form'+post_id).modal('hide');
                    view_posting();
                }
            })
        }
    });





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

</html>