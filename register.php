<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_public();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/R16.png">
    <title>RuangDIGITAL</title>
    <link href="assets/dist/css/pages/login-register-lock.css" rel="stylesheet">
    <link href="assets/dist/css/style.min.css" rel="stylesheet">
    <link href="assets/dist/parsley.css" rel="stylesheet">
</head>
<body style="background-color: #4028d8;">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">RuangDIGITAL</p>
        </div>
    </div>
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(assets/images/login-register.jpg);">
        <div class="login-box card" style="border-radius: 0px;">
            <div class="card-body">
            <span id="message"></span>
                <form method="post" class="form-horizontal form-material" id="user_register_form">
                    <h3 class="box-title m-t-40 m-b-0">Registrasi</h3><small> </small>
                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="user_nama_depan" id="user_nama_depan" placeholder="Nama Depan">
                        </div>
                    </div>
                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="user_nama_belakang" id="user_nama_belakang" placeholder="Nama Belakang">
                        </div>
                    </div>
                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <select name="user_kelas_id" id="user_kelas_id" class="form-control input-lg">
                                <option value="">Pilih Kelas</option>
                                <?php

                                echo $exam->kelasujian_list();

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="user_email" id="user_email" placeholder="Email"  data-parsley-checkemail data-parsley-checkemail-message='Email Address already Exists'>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="user_password" id="user_password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="check_rules" name="check_rules" required>
                                <label class="custom-control-label" for="check_rules">I agree to all <a href="javascript:void(0)">Terms & Conditions</a></label> 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                        	<input type="hidden" name='page' value='register' />
                    		<input type="hidden" name="action" value="register" />
                            <input class="btn btn-info btn-lg btn-block btn-rounded waves-effect waves-light" type="submit" id="user_register" name="user_register" value="Registrasi">
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Already have an account? <a href="login.php" class="text-info m-l-5"><b>LogIn</b></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <script src="assets/dist/js/custom.min.js"></script>
    <script src="assets/dist/parsley.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
</body>
</html>
<script>

$(document).ready(function(){

	window.ParsleyValidator.addValidator('checkemail', {
		validateString: function(value){
			return $.ajax({
				url:'user_ajax_proses.php',
				method:'post',
				data:{page:'register', action:'check_email', user_email:value},
				dataType:"json",
				async: false,
				success:function(data)
				{
				return true;
				}
			});
		}
	});

	$('#user_register_form').parsley();

	$('#user_register_form').on('submit', function(event){
		event.preventDefault();

		$('#user_email').attr('required', 'required');

		$('#user_email').attr('data-parsley-type', 'email');

		$('#user_password').attr('required', 'required');

		$('#confirm_password').attr('required', 'required');

		$('#confirm_password').attr('data-parsley-equalto', '#user_password');

		$('#user_nama_depan').attr('required', 'required');

		$('#user_nama_depan').attr('data-parsley-pattern', '^[a-zA-Z]+$');

		$('#user_nama_belakang').attr('required', 'required');

		$('#user_nama_belakang').attr('data-parsley-pattern', '^[a-zA-Z]+$');

        $('#user_kelas_id').attr('required', 'required');

		if($('#user_register_form').parsley().validate())
		{
			$.ajax({
				url:'user_ajax_proses.php',
				method:"POST",
				data:new FormData(this),
				dataType:"json",
				contentType:false,
				cache:false,
				processData:false,
				beforeSend:function()
				{
					$('#user_register').attr('disabled', 'disabled');
					$('#user_register').val('please wait...');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#message').html('<div class="alert alert-success">Registrasi Berhasil...</div>');
						$('#user_register_form')[0].reset();
						$('#user_register_form').parsley().reset();
					}
					$('#user_register').attr('disabled', false);
					$('#user_register').val('Register');
				}
			})
		}

	});
	
});

</script>