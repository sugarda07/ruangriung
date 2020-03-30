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
        
<?php
if(isset($_SESSION['user_id']))
{
    $foto_status = $exam->Get_foto_status($_SESSION["user_id"]);
    $nama_user = $exam->Get_nama_lengkap($_SESSION["user_id"]);
    $code_user = $exam->Get_code_user($_SESSION["user_id"]);
?>
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
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="icon-grid"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-grid"></i></a> </li>
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
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $foto_status; ?> <span class="hidden-md-down"><?php echo $nama_user; ?> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <a href="view_profil.php?data=<?php echo $code_user; ?>" class="dropdown-item"><i class="fa fa-user-circle-o"></i>&nbsp;  My Profil</a>
                                <a href="javascript:void(0)" class="dropdown-item edit_profilModal"><i class="fa fa-cogs"></i>&nbsp;  Setting Profil</a>
                                <a href="javascript:void(0)" class="dropdown-item"><i class="fa fa-camera-retro"></i><label for="upload_fotoprofil" style="margin-bottom: 0px;">&nbsp; Ganti Foto Profil </label></a>
                                <a href="javascript:void(0)" class="dropdown-item gantipasswordModal"><i class="mdi mdi-account-key"></i>&nbsp; Ganti Password</a>
                                <div class="dropdown-divider"></div>
                                <a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i>&nbsp; Logout</a>
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
                        <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><?php echo $foto_status; ?> <span class="hide-menu"><?php echo $nama_user; ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="view_profil.php?data=<?php echo $code_user; ?>"><i class="fa fa-user-circle-o"></i>&nbsp; My Profile</a></li>
                                <li><a href="javascript:void(0)" class="edit_profilModal"><i class="fa fa-cogs"></i>&nbsp; Setting Profil</a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-camera-retro"></i><label for="upload_fotoprofil" style="margin-bottom: 0px;">&nbsp; Ganti Foto Profil </label></a></li>
                                <li><a href="javascript:void(0)" class="gantipasswordModal"><i class="fa fa-camera-retro"></i>&nbsp; Ganti Password</a></li>
                                <li><a href="logout.php"><i class="fa fa-power-off"></i>&nbsp; Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">--- MENU</li>
                        <li> <a class="waves-effect waves-dark" href="index.php" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Home</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="post_all.php" aria-expanded="false"><i class="fa fa-search"></i><span class="hide-menu">Cari</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="cari_postingan.php" aria-expanded="false"><i class="fa fa-hashtag"></i><span class="hide-menu">Cari Postingan</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="materi.php" aria-expanded="false"><i class="fa fa-file-text-o"></i><span class="hide-menu">Materi</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="ujian_user.php" aria-expanded="false"><i class="fa fa-edge"></i><span class="hide-menu">Tugas/Quiz</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="pesan/index.php" aria-expanded="false"><i class="ti-comments"></i><span class="hide-menu">Pesan</span></a></li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">


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


<div id="edit_profilModal" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin:0px; position: absolute; top: 0; bottom: 0; right: 0; width: 100%; height: 100%; margin: 0;
    opacity: 1; box-shadow: 7px 0 16px 15px rgba(0, 0, 0, 0.6);">
        <div class="modal-content" style="position: relative; height: 100%; border-radius: 0; border: 0; background-clip: initial;">
            <div class="modal-header">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" style="padding-left: 25px;">Edit Profil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
                      
            <div class="modal-body" style="position: relative; overflow-y: scroll; height: 100%;">
                <form id="form_view_edit_profil" method="post" class="form-material m-t-10" enctype="multipart/form-data"> 
                    <div class="form-group" style="margin-bottom: 15px;">
                        <input type="text" name="user_nama_depan" id="user_nama_depan" class="form-control" placeholder="Nama Depan" />
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <input type="text" name="user_nama_belakang" id="user_nama_belakang" class="form-control" placeholder="Nama Belakang" />
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                      <select class="form-control" name="user_jk" id="user_jk"/>
                            <option label="-- Pilih Jenis Kelamin --"></option>                   
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <input type="text" name="user_tmp_lahir" id="user_tmp_lahir" class="form-control" placeholder="Tempat Lahir"/>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <input type="text" name="user_tgl_lahir" id="user_tgl_lahir" class="form-control" placeholder="Tanggal Lahir"  />
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <input type="text" name="user_hp" id="user_hp" class="form-control" placeholder="Nomor Handphone" />
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                      <select class="form-control" name="user_kelas_id" id="user_kelas_id"> 
                        <option label="-- Pilih Sekolah, Jurusan, Kelas --"></option>
                          <?php echo $exam->get_kelas();?>
                      </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <textarea name="user_alamat" id="user_alamat" row="5" class="form-control" placeholder="Alamat Copy lokasi dari Google Map"> </textarea>
                    </div>
                    <br><br><br>           
                    <div class="modal-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; background-color: #ffffff; text-align: left;">
                        <input type="hidden" name="page" value="profile" />
                        <input type="hidden" name="action" value="edit_profil"/>
                        <button type="submit" id="tombol_edit_profil" name="tombol_edit_profil" class="btn btn-info btn-block waves-effect waves-light">Simpan</button>
                    </div>
                </form>           
            </div>               
        </div>
    </div>
</div>

<div id="gantiPasswordModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ganti Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <form method="post" id="form_ganti_password" enctype="multipart/form-data" class="form-material m-t-10">
                <div class="form-group" style="margin-bottom: 15px;">
                  <label style="margin-bottom: 0px;">Email</label>
                  <input type="email" name="user_email" id="user_email" readonly class="form-control" placeholder="ataya1st@gmail.com">
                </div>
                <hr>
                <div class="form-group" style="margin-bottom: 15px;">
                  <label style="margin-bottom: 0px;">Password Baru</label>
                  <input type="password" name="user_password_baru" id="user_password_baru" class="form-control">
                </div>        
                <div class="form-group" style="margin-bottom: 15px;">
                  <label style="margin-bottom: 0px;">Konfirmasi Password Baru</label>
                  <input type="password" name="konfirmasi_password_baru" id="konfirmasi_password_baru" class="form-control">
                </div>       
                <div class="modal-footer">
                <input type="hidden" name="page" value="profile"/>
                <input type="hidden" name="action" value="ganti_password"/>
                    <button type="submit" id="tombol_ganti_password" name="tombol_ganti_password" class="btn btn-info waves-effect">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#user_tgl_lahir').bootstrapMaterialDatePicker({ weekStart: 0, time: false });    
</script>

<script>
$(document).ready(function(){
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
            url:'user_ajax_proses.php',
            type:'POST',
            data:{'profil':response, action:'gantifoto', page:'pengaturan'},
                success:function(data){
                    $('#fotoprofil_modal').modal('hide');
                }
            })
        });
    });

    $(document).on('click', '.gantipasswordModal', function(){
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'ambil_password', page:'profile'},
            dataType:"json",
            success:function(data)
            {
                $('#user_email').val(data.user_email);

                $('#user_password_baru').val(data.user_password_baru);

                $('#modal_title').text('Ganti Password');

                $('#tombol_ganti_password').val('Simpan');

                $('#action').val('ganti_password');

                $('#gantiPasswordModal').modal('show');
            }
        })              
    });

    $('#form_ganti_password').parsley();
    
    $('#form_ganti_password').on('submit', function(event){

        event.preventDefault();
        
        $('#user_password_baru').attr('required', 'required');

        $('#konfirmasi_password_baru').attr('required', 'required');

        $('#konfirmasi_password_baru').attr('data-parsley-equalto', '#user_password_baru');

        if($('#form_ganti_password').parsley().validate())
        {
            $.ajax({
                url:"user_ajax_proses.php",
                method:"POST",
                data: new FormData(this),
                dataType:"json",
                contentType: false,
                cache: false,
                processData:false,              
                beforeSend:function()
                {
                    $('#tombol_ganti_password').attr('disabled', 'disabled');
                    $('#tombol_ganti_password').val('please wait...');
                },
                success:function(data)
                {
                    location.reload(true);
                    $('#edit_profilModal').modal('hide');                        
                    $('#tombol_ganti_password').attr('disabled', false);
                    $('#tombol_ganti_password').val('Simpan');
                }
            });
        }
    });


    $(document).on('click', '.edit_profilModal', function(){
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'edit_ambil', page:'profile'},
            dataType:"json",
            success:function(data)
            {
                $('#user_nama_depan').val(data.user_nama_depan);

                $('#user_nama_belakang').val(data.user_nama_belakang);

                $('#user_jk').val(data.user_jk);

                $('#user_tmp_lahir').val(data.user_tmp_lahir);

                $('#user_tgl_lahir').val(data.user_tgl_lahir);

                $('#user_hp').val(data.user_hp);

                $('#user_kelas_id').val(data.user_kelas_id);

                $('#user_alamat').val(data.user_alamat);

                $('#modal_title').text('Edit Profil');

                $('#tombol_edit_profil').val('Simpan');

                $('#action').val('edit_profil');

                $('#edit_profilModal').modal('show');
            }
        })              
    });

    $('#form_view_edit_profil').parsley();
    
        $('#form_view_edit_profil').on('submit', function(event){

        event.preventDefault();

        $('#user_nama_depan').attr('required', 'required');

        $('#user_nama_depan').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

        $('#user_nama_belakang').attr('required', 'required');
        $('#user_nama_belakang').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

        $('#user_kelas_id').attr('required', 'required');

        $('#user_hp').attr('data-parsley-pattern', '^[0-9]+$');

        if($('#form_view_edit_profil').parsley().validate())
        {
            $.ajax({
                url:"user_ajax_proses.php",
                method:"POST",
                data: new FormData(this),
                dataType:"json",
                contentType: false,
                cache: false,
                processData:false,              
                beforeSend:function()
                {
                    $('#tombol_edit_profil').attr('disabled', 'disabled');
                    $('#tombol_edit_profil').val('please wait...');
                },
                success:function(data)
                {
                    if(data.success)
                    {
                        location.reload(true);
                        $('#edit_profilModal').modal('hide');
                    }
                    else
                    {
                        $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
                    }
                    $('#tombol_edit_profil').attr('disabled', false);
                    $('#tombol_edit_profil').val('Simpan');
                }
            });
        }
    });            

    load_total_notif();

    function load_total_notif()
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'load_total_notif', page:'pengaturan'},
            success:function(data)
            {
              $('#total_notif').html(data);
            }
        });
    }

    $('#total_notif').click(function(){
        $.ajax({
            url:"user_ajax_proses.php",
            method:"post",
            data:{action:'update_notification_status', page:'pengaturan'},
            success:function(data)
            {
                $('#total_notifikasi').remove();
            }
        })
    });

    $('#show_load_pemberitahuan').click(function()
    {
        $.ajax({
            url:"user_ajax_proses.php",
            method:"POST",
            data:{action:'load_pemberitahuan', page:'pengaturan'},
            success:function(data)
            {
                $('#load_pemberitahuan').html(data);
            }
        });
    });
        

    });
</script>



<?php
}
?>