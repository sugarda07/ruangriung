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
    <link href="assets/dist/css/style.min.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="assets/node_modules/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="assets/node_modules/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="assets/node_modules/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="assets/node_modules/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="assets/crop/croppie.css" rel="stylesheet">
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
                    <ul class="navbar-nav my-lg-0" id="pengaturan">
                        
                    </ul>
                </div>
            </nav>
        </header>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-xlg-9 col-md-7" style="padding-left: 0px; padding-right: 0px;">
                    	<div class="card" id="view_profil">

                        </div>
                        <div class="card">
                            <div class="card-body" style="padding: 9px;">
                                <div class="profiletimeline" id="view_profil_posting">

                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer" align="center">
          © 2020 RuangDIGITAL by @sugarda3rd
        </footer>
    </div>

<div id="fotoprofil_modal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="margin:0px; position: absolute; top: 0; bottom: 0; right: 0; width: 100%; height: 100%; margin: 0;
    opacity: 1; box-shadow: 7px 0 16px 15px rgba(0, 0, 0, 0.6);">
      <div class="modal-content" style="position: relative; height: 100%; border-radius: 0; border: 0; background-clip: initial;">
        <div class="modal-header">
            <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
            <h4 class="modal-title" style="padding-left: 25px;">Ganti Foto Profil</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body" style="background-color: #0c59f796;">
          <div id="tampil_gambar" align="center"></div>
          <input type="file" name="upload_fotoprofil" id="upload_fotoprofil" accept=".jpg, .png"  style="display: none;"/> 
        </div>
        <div class="modal-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; background-color: #ffffff;"> 
            <div class="input-group">
               <button class="btn btn-info btn-flat btn-block crop_image">Simpan</button>
            </div>
        </div>
      </div>         
    </div>
</div>

<div id="pengikutModal" class="modal modal-fullscreen" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;">
            <div class="modal-header">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" id="myLargeModalLabel" style="padding-left: 25px;">Pengikut</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
            <div class="modal-body">
                <div class="message-box">
                  <div class="message-widget message-scroll" id="data_pengikut">
                    
                  </div>
              </div>
            </div>
            <div class="modal-footer" style="padding-top: 5px;padding-bottom: 5px;">
                © 2020 RuangDIGITAL by @sugarda3rd
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>


<div id="mengikutiModal" class="modal modal-fullscreen" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none;">
            <div class="modal-header">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" id="myLargeModalLabel" style="padding-left: 25px;">Mengikuti</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
            <div class="modal-body">
                <div class="message-box">
                  <div class="message-widget message-scroll" id="data_mengikuti">
                    
                  </div>
              </div>
            </div>
            <div class="modal-footer" style="padding-top: 5px;padding-bottom: 5px;">
                © 2020 RuangDIGITAL by @sugarda3rd
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
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
    <script src="assets/node_modules/moment/moment.js"></script>
    <script src="assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="assets/node_modules/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="assets/node_modules/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
    <script src="assets/node_modules/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
    <script src="assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="assets/crop/croppie.min.js"></script>
</body>

<script>
    $('#tgl_lahir').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
    $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

    $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });
    // Clock pickers
    $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
    // Colorpicker
    $(".colorpicker").asColorPicker();
    $(".complex-colorpicker").asColorPicker({
        mode: 'complex'
    });
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });
    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
    // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        format: 'MM/DD/YYYY h:mm A',
        timePickerIncrement: 30,
        timePicker12Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'MM/DD/YYYY',
        minDate: '06/01/2015',
        maxDate: '06/30/2015',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        dateLimit: {
            days: 6
        }
    });
</script>

<script>
$(document).ready(function(){  

  view_profil();

  function view_profil()
  {
     var user_id = '<?php echo $_GET["data"];?>';
     var proses = 'view_profil';
     $.ajax({
          url:'view_posting_proses.php',
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#view_profil').html(data);
          }
     })
  }

  view_profil_posting();

  function view_profil_posting()
  {
     var user_id = '<?php echo $_GET["data"];?>';
     var proses = 'view_profil_posting';
     $.ajax({
          url:'view_posting_proses.php',
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#view_profil_posting').html(data);
          }
     })
  }


  $(document).on('click', '.action_button', function(){
        var sender_id = $(this).data('sender_id');
        var proses = $(this).data('proses');
        $.ajax({
            url:"view_posting_proses.php",
            method:"POST",
            data:{sender_id:sender_id, proses:proses},
            success:function(data)
            {              
                view_profil();
                pengikut();
                mengikuti();
            }
        })
    });


    $(document).on('click', '.like_button', function(){
        var post_id = $(this).data('post_id');
        var proses = 'like';
        $.ajax({
            url:"view_posting_proses.php",
            method:"POST",
            data:{post_id:post_id, proses:proses},
            success:function(data)
            {
                view_profil_posting();
            }
        })
    });


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
                    view_profil_posting();
                }
            })
        }
    });


    $(document).on('click', '.edit_profilModal', function(){
        $('#edit_profilModal').modal('show');     
        $('#form_view_edit_profil').on('submit', function(event){
        event.preventDefault();

        if($('#nama_depan').val() == '')
        {
           swal('','Nama Depan masih kosong');
        }
        else if($('#nama_belakang').val() == '')
        {
           swal('','Nama Belakang masih kosong');
        }
        else if($('#jenis_kelamin').val() == '')
        {
           swal('','Pilih jenis kelamin Anda');
        }
        else
        {
          $.ajax({
              url:"view_posting_proses.php",
              method:"POST",
                data:new FormData(this),
                  contentType:false,
                  cache:false,
                  processData:false,
              beforeSend:function()
              {
                  $('#tombol_edit_profil').attr('disabled', 'disabled');  
              },
              success:function(data)
              {
                $('#edit_profilModal').modal('hide'); 
                swal('','Berhasil diperbaharui');                
                view_profil();
              }
          })
        }
    }); 
    });


  pengaturan();

  function pengaturan()
  {
     var user_id = '<?php echo $_GET["data"];?>';
     var proses = 'pengaturan';
     $.ajax({
          url:'view_posting_proses.php',
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#pengaturan').html(data);
          }
     })
  }

  $(document).on('click', '.tombol_sekolahModal', function(){             
    $('#sekolahModal').modal('show');
    $('#form_data_sekolah').on('submit', function(event){
        event.preventDefault();

        if($('#sekolah').val() == '')
        {
           swal('','Sekolah harus di isi');
        }
        else if($('#kelas').val() == '')
        {
           swal('','kelas harus di isi');
        }
        else
        {
          $.ajax({
              url:"view_posting_proses.php",
              method:"POST",
                data:new FormData(this),
                  contentType:false,
                  cache:false,
                  processData:false,
              beforeSend:function()
              {
                  $('#tombol_data_sekolah').attr('disabled', 'disabled');  
              },
              success:function(data)
              {
                $('#sekolahModal').modal('hide'); 
                swal('','Berhasil diperbaharui');                
                view_profil();
              }
          })
        }
    });
  });
 

  $(document).on('click', '.akunModal', function(){              
    $('#akunModal').modal('show');
    $('#form_data_akun').on('submit', function(event){
        event.preventDefault();

        if($('#email').val() == '')
        {
           swal('','email harus di isi');
        }
        else
        {
          $.ajax({
              url:"view_posting_proses.php",
              method:"POST",
                data:new FormData(this),
                  contentType:false,
                  cache:false,
                  processData:false,
              beforeSend:function()
              {
                  $('#tombol_data_akun').attr('disabled', 'disabled');  
              },
              success:function(data)
              {
                $('#akunModal').modal('hide'); 
                swal('','Berhasil diperbaharui');                
                view_profil();
              }
          })
        }
    });
  });

  $(document).on('click', '.tombol_pengikut', function(){              
    $('#pengikutModal').modal('show');
    pengikut();
  });

  pengikut();

  function pengikut()
  {
      var user_id = '<?php echo $_GET["data"];?>';
      var proses = 'pengikut';
      $.ajax({
          url:"view_posting_proses.php",
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#data_pengikut').html(data);
          }
      });
  }


  $(document).on('click', '.tombol_mengikuti', function(){              
    $('#mengikutiModal').modal('show');
    mengikuti();
  });
  mengikuti();

  function mengikuti()
  {
      var user_id = '<?php echo $_GET["data"];?>';
      var proses = 'mengikuti';
      $.ajax({
          url:"view_posting_proses.php",
          method:"POST",
          data:{proses:proses, user_id:user_id},
          success:function(data)
          {
              $('#data_mengikuti').html(data);
          }
      });
  }

  $profil_crop = $('#tampil_gambar').croppie({
    enableExif: true,
    viewport: {
      width:300,
      height:300,
      type:'square' //circle
    },
    boundary:{
      width:'300',
      height:'300'
    }    
  });

  $('#upload_fotoprofil').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $profil_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#fotoprofil_modal').modal('show');
  });

  $('.crop_image').click(function(event){
    $profil_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:'profil_back_proses.php',
        type:'POST',
        data:{"profil":response},
        success:function(data){
          $('#fotoprofil_modal').modal('hide');
          view_profil();
        }
      })
    });
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