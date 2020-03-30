<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

$foto_status = $exam->Get_foto_status($_SESSION["user_id"]);
$nama_user = $exam->Get_nama_lengkap($_SESSION["user_id"]);
$code_user = $exam->Get_code_user($_SESSION["user_id"]);

$ujian_id = '';
$ujian_status = '';
$durasi_akhir = '';

if(isset($_GET['code']))
{
    $ujian_id = $exam->Get_ujian_id($_GET["code"]);
    $exam->query = "
    SELECT ujian_status, ujian_tanggal, ujian_durasi FROM ujian 
    WHERE ujian_id = '$ujian_id'
    ";

    $result = $exam->query_result();

    foreach($result as $row)
    {
        $ujian_status = $row['ujian_status'];
        $ujian_mulai = $row['ujian_tanggal'];
        $durasi = $row['ujian_durasi'] . ' minute';
        $durasi2 = $row['ujian_durasi'];
        $ujian_akhir = strtotime($ujian_mulai . '+' . $durasi);

        $ujian_akhir = date('Y-m-d H:i:s', $ujian_akhir);
        $durasi_akhir = strtotime($ujian_akhir) - time();
    }
}
else
{
    header('location:enroll_exam.php');
}

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
    <link href="assets/dist/css/pages/tab-page.css" rel="stylesheet">
    <link href="assets/dist/css/placeholder-loading.min.css" rel="stylesheet">
    <link href="assets/dist/css/pages/ribbon-page.css" rel="stylesheet">
    <link href="assets/jquery-mentions-input-master/jquery.mentionsInput.css" rel="stylesheet">
    <link href="assets/dist/css/pages/stylish-tooltip.css" rel="stylesheet">
    <link href="assets/node_modules/jqueryui/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="assets/crop/croppie.css" rel="stylesheet">
    <link href="assets/dist/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dist/TimeCircles.css" />
    <link rel="stylesheet" href="assets/magnific/css/style.css">
    <link href="assets/dist/css/pages/other-pages.css" rel="stylesheet">
    <link href="assets/dist/css/pages/ui-bootstrap-page.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <link href="assets/node_modules/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/node_modules/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="assets/dist/parsley.css" rel="stylesheet">
    

    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/dist/js/jquery.form.js"></script>
    <script src="assets/dist/js/jquery.min.js"></script>
    <script src="assets/node_modules/jqueryui/jquery-ui.js"></script>
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
    <script src="assets/jquery-mentions-input-master/lib/jquery.elastic.js" type="text/javascript"></script>
    <script src="assets/jquery-mentions-input-master/underscore-min.js" type="text/javascript"></script>
    <script src="assets/jquery-mentions-input-master/jquery.mentionsInput.js" type="text/javascript"></script>
    <script src="assets/crop/croppie.min.js"></script>
    <script src="assets/node_modules/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/dist/angular.min.js"></script>
    <script src="assets/dist/bootstrap-datetimepicker.js"></script>
    <script src="assets/dist/parsley.js"></script>
    <script src="assets/dist/TimeCircles.js"></script>
    <script src="assets/node_modules/moment/moment.js"></script>
    <script src="assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <script src="assets/node_modules/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
    <script src="assets/node_modules/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
    <script src="assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <script src="assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
</head>

<body class="skin-purple fixed-layout fix-sidebar single-column" onload="init(),noBack();" onpageshow="if (event.persisted) noBack();" onunload="keluar()">
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
                        <li class="nav-item">

                        </li>
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><h3><span style="font-size: 18px;" id="divwaktu"></span></h3> </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $foto_status; ?> <span class="hidden-md-down"><?php echo $nama_user; ?> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0)" class="dropdown-item konfirm_selesai"><i class="fa fa-check-square-o"></i> Selesai</a>
                            </div>
                        </li>
                        <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="icon-grid"></i></a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="page-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px; padding-top: 5px;">
                        <div class="card" style="margin-bottom: 65px;margin-top: 5px;">
                            <div class="card-body">
                                <div id="single_question_area"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <br />
                        <div align="center">
                            <div id="ujian_timer" data-timer="<?php echo $durasi_akhir; ?>" style="max-width:200px; width: 100%; height: 200px;"></div>
                        </div>
                        <br />
                        <div id="user_details_area"></div>      
                    </div>
                </div>
                <div class="right-sidebar" style="padding-top: 67px; z-index: 10;">
                    <div class="slimscrollright">
                        <div class="rpanel-title">Navigasi Soal</div>
                        <div class="r-panel-body" id="question_navigation_area">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; padding: 10px; margin-left: 0px;">
            <div class="row" style="margin-left: 0px; margin-right: 0px;" id="navigasi_arah">
                
            </div>
        </footer>
    </div>
</body>

<div class="modal" id="konfirmModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Selesai</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h3 align="center">Yakin Selesai?</h3>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" name="ok_selesai" id="ok_selesai" class="btn btn-primary btn-sm">OK</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</html>

<script>
    var waktunya;
    waktunya = <?php echo $durasi2; ?> * 60;
    var waktu;
    var jalan = 0;
    var habis = 0;

    function init(){
        checkCookie();
        mulai();
    }

    function keluar(){
        if(habis==0){
            setCookie('waktux',waktu,365);
        }else{
            setCookie('waktux',0,-1);
        }
    }
    function mulai(){
        jam = Math.floor(waktu/3600);
        sisa = waktu%3600;
        menit = Math.floor(sisa/60);
        sisa2 = sisa%60
        detik = sisa2%60;
        if(detik<10){
            detikx = "0"+detik;
        }else{
            detikx = detik;
        }
        if(menit<10){
            menitx = "0"+menit;
        }else{
            menitx = menit;
        }
        if(jam<10){
            jamx = "0"+jam;
        }else{
            jamx = jam;
        }
        document.getElementById("divwaktu").innerHTML = jamx+":"+menitx+":"+detikx +"";
        waktu --;
        if(waktu>0){
            t = setTimeout("mulai()",1000);
            jalan = 1;
        }else{
            if(jalan==1){
                clearTimeout(t);
            }
            habis = 1;
            document.getElementById("ok_selesai").click();
        }
    }
    function selesai(){    
        if(jalan==1){
            clearTimeout(t);
        }
        habis = 1;
    }
    function getCookie(c_name){
        if (document.cookie.length>0){
            c_start=document.cookie.indexOf(c_name + "=");
            if (c_start!=-1){
                c_start=c_start + c_name.length+1;
                c_end=document.cookie.indexOf(";",c_start);
                if (c_end==-1) c_end=document.cookie.length;
                return unescape(document.cookie.substring(c_start,c_end));
            }
        }
        return "";
    }
    function setCookie(c_name,value,expiredays){
        var exdate=new Date();
        exdate.setDate(exdate.getDate()+expiredays);
        document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
    }
    function checkCookie(){
        waktuy=getCookie('waktux');
        if (waktuy!=null && waktuy!=""){
            waktu = waktuy;
        }else{
            waktu = waktunya;
            setCookie('waktux',waktunya,7);
        }
    }
</script>

<script type="text/javascript">
    window.history.forward();
    function noBack(){ window.history.forward(); }
</script>

<script>

$(document).ready(function(){
    var ujian_id = "<?php echo $ujian_id; ?>";

    load_soal();
    soal_navigation();
    load_navigasi_arah();

    function load_soal(soal_id = '')
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{ujian_id:ujian_id, soal_id:soal_id, page:'proses_ujian', action:'load_soal'},
            success:function(data)
            {
                $('#single_question_area').html(data);
            }
        })
    }

    function load_navigasi_arah(soal_id = '')
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{ujian_id:ujian_id, soal_id:soal_id, page:'proses_ujian', action:'navigasi_arah'},
            success:function(data)
            {
                $('#navigasi_arah').html(data);
            }
        })
    }

    $(document).on('click', '.next', function(){
        var soal_id = $(this).attr('id');
        load_soal(soal_id);
        load_navigasi_arah(soal_id);
    });

    $(document).on('click', '.previous', function(){
        var soal_id = $(this).attr('id');
        load_soal(soal_id);
        load_navigasi_arah(soal_id);
    });

    function soal_navigation()
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{ujian_id:ujian_id, page:'proses_ujian', action:'soal_navigation'},
            success:function(data)
            {
                $('#question_navigation_area').html(data);
            }
        })
    }

    $(document).on('click', '.navigasi_soal', function(){
        var soal_id = $(this).data('soal_id');
        load_soal(soal_id);
    });

    $(document).on('click', '.pilihan_jawaban', function(){
        var soal_id = $(this).data('soal_id');

        var pilihan_jawaban = $(this).data('id');

        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{soal_id:soal_id, pilihan_jawaban:pilihan_jawaban, ujian_id:ujian_id, page:'proses_ujian', action:'jawaban'},
            success:function(data)
            {
                load_soal(soal_id);
                load_navigasi_arah(soal_id);
                soal_navigation();
            }
        })
    });

    $(document).on('click', '.konfirm_selesai', function(){
        $('#konfirmModal').modal('show');
    });

    $('#ok_selesai').click(function(){
        konfirmasi_selesai();
        window.location='ujian_user.php';
    });

    function konfirmasi_selesai()
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{page:'proses_ujian', ujian_id:ujian_id, action:'konfirmasi_selesai'},
            success:function(data)
            {
                
            }
        })
    }



});
</script>