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
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/R16.png">
    <title>RuangDIGITAL</title>
    <link href="assets/dist/css/pages/login-register-lock.css" rel="stylesheet">
    <link href="assets/dist/css/style.css" rel="stylesheet">
</head>
<body style="background-color: #4028d8;">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">RuangDIGITAL</p>
        </div>
    </div>
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(assets/images/login-register.jpg);">
        <div class="login-box card" style="border-radius: 20px;">
            <div class="card-body">
            <span id="message"></span>
                <form method="post" class="form-horizontal form-material" id="user_login_form">
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" name="user_email" id="user_email" type="text" placeholder="Email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" name="user_password" id="user_password" type="password" placeholder="Password" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Ingatkan</label>
                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Lupa pwd?</a> 
                            </div>     
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                        	<input type="hidden" name="page" value="login" />
                    		<input type="hidden" name="action" value="login" />
                            <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded waves-effect waves-light" name="user_login" id="user_login" type="submit">LogIn</button>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            Buat akun baru? <a href="register.php" class="text-primary m-l-5"><b>Registrasi</b></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/dist/parsley.js"></script>
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
    </script>

    <script>  
    $(document).ready(function(){  

		$('#user_login_form').parsley();

		$('#user_login_form').on('submit', function(event){
			event.preventDefault();

			$('#user_email').attr('required', 'required');

			$('#user_email').attr('data-parsley-type', 'email');

			$('#user_password').attr('required', 'required');

			if($('#user_login_form').parsley().validate())
			{
				$.ajax({
				url:"user_ajax_proses.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function()
				{
					$('#user_login').attr('disabled', 'disabled');
					$('#user_login').val('please wait...');
				},	success:function(data)
					{
						if(data.success)
						{
							location.href='index.php';
						}
						else
						{
							$('#message').html('<div class="alert alert-danger" align="center">'+data.error+'</div>');
						}
						$('#user_login').attr('disabled', false);
						$('#user_login').val('Login');
					}
				})
			}
		});      
    });  
    </script>
    
</body>

</html>