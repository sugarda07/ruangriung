<?php

//header.php

include('koneksi.php');

$exam = new Koneksi;

$exam->admin_session_private();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/r16.png">
    <title>RuangDIGITAL</title>
    <link href="../assets/dist/css/pages/contact-app-page.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/user-card.css" rel="stylesheet">
    <link href="../assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <link href="../assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="../assets/dist/css/style.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/tab-page.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/tab-page.css" rel="stylesheet">
    <link href="../assets/dist/css/placeholder-loading.min.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/ribbon-page.css" rel="stylesheet">
    <link href="../assets/jquery-mentions-input-master/jquery.mentionsInput.css" rel="stylesheet">
    <link href="../assets/dist/css/pages/stylish-tooltip.css" rel="stylesheet">
    <link href="../assets/node_modules/jqueryui/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="../assets/crop/croppie.css" rel="stylesheet">
    <link href="../assets/dist/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/node_modules/html5-editor/bootstrap-wysihtml5.css" />
    <link href="../assets/node_modules/summernote/dist/summernote.css" rel="stylesheet" />

    <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="../assets/dist/js/jquery.form.js"></script>
    <script src="../assets/dist/js/jquery.min.js"></script>
    <script src="../assets/node_modules/jqueryui/jquery-ui.js"></script>
    <script src="../assets/node_modules/popper/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/dist/js/waves.js"></script>
    <script src="../assets/dist/js/sidebarmenu.js"></script>
    <script src="../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <script src="../assets/dist/js/custom.min.js"></script>
    <script src="../assets/fullscreen_modal/dist/bs-modal-fullscreen.js"></script>
    <script src="../assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="../assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
    <script src="../assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <script src="../assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script src="../assets/jquery-mentions-input-master/lib/jquery.elastic.js" type="text/javascript"></script>
    <script src="../assets/jquery-mentions-input-master/underscore-min.js" type="text/javascript"></script>
    <script src="../assets/jquery-mentions-input-master/jquery.mentionsInput.js" type="text/javascript"></script>
    <script src="../assets/crop/croppie.min.js"></script>
    <script src="../assets/node_modules/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/dist/angular.min.js"></script>
    <script src="../assets/dist/bootstrap-datetimepicker.js"></script>
    <script src="../assets/dist/parsley.js"></script>
    <script src="../assets/node_modules/tinymce/tinymce.min.js"></script>
    <script src="../assets/dist/js/pages/jasny-bootstrap.js"></script>
    <script src="../assets/node_modules/summernote/dist/summernote.min.js"></script>
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
                        <li> <a class="waves-effect waves-dark" href="index.php" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Home</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="user.php" aria-expanded="false"><i class="fa fa-group"></i><span class="hide-menu">User</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="kelas.php" aria-expanded="false"><i class="fa fa-sitemap"></i><span class="hide-menu">Kelas</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="materi.php" aria-expanded="false"><i class="fa fa-list-ul"></i><span class="hide-menu">Materi</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="quiz.php" aria-expanded="false"><i class="fa fa-list-ul"></i><span class="hide-menu">Quiz</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="ujian.php" aria-expanded="false"><i class="fa fa-list-ul"></i><span class="hide-menu">Ujian</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="postingan.php" aria-expanded="false"><i class="fa fa-list-ul"></i><span class="hide-menu">Postingan</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="logout.php" aria-expanded="false"><i class="fa fa-power-off"></i><span class="hide-menu">LogOut</span></a></li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">