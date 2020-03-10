<?php
include('koneksi.php');
include('function.php');
session_start();
if(!isset($_SESSION['user_id'])) {
  header("location:login.php");
}

$user_id = Get_user_id($connect, $_GET["data"]);
$query_materi = "
SELECT * FROM materi
WHERE materi_id = '".$_GET["data"]."'
";

$statement = $connect->prepare($query_materi);
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
    <link href="assets/dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="assets/dist/css/pages/user-card.css" rel="stylesheet">
    <link href="assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <link href="assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="assets/dist/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/magnific/css/style.css">
    <link href="assets/dist/css/pages/other-pages.css" rel="stylesheet">
    <link href="assets/dist/css/placeholder-loading.min.css" rel="stylesheet">
    <link href="assets/dist/css/pages/ui-bootstrap-page.css" rel="stylesheet">
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

                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        
                    </ul>
                </div>
            </nav>
        </header>
        <div class="page-wrapper">
            <div class="container-fluid" style="padding: 5px;">
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                    	<div class="card">
	                        <div class="card-body" id="view_data_materi">
                            
	                        </div>
	                    </div>                        
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer" align="center" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; margin-left: 0px; padding-top: 5px; padding-bottom: 5px">
          <small>© 2020 RuangDIGITAL by @sugarda3rd</small>
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
    <script src="assets/node_modules/datatables/jquery.dataTables.min.js"></script>
</body>


<script>
$(document).ready(function(){  

    view_data_materi();

    function view_data_materi()
    {
        var materi_id = '<?php echo $_GET["data"];?>';
        var proses = 'view_data_materi';
        $.ajax({
            url:'proses.php',
            method:"POST",
            data:{proses:proses, materi_id:materi_id},
            success:function(data)
            {
              $('#view_data_materi').html(data);
            }
        })
    }




});
</script>

</html>