<?php
include('koneksi.php');
session_start();
if(isset($_SESSION['user_id']))
{
  header('location:index.php');
}

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
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/R16.png">
    <title>RuangDIGITAL</title>
    
    <!-- page css -->
    <link href="assets/dist/css/pages/login-register-lock.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/dist/css/style.min.css" rel="stylesheet">
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<style>
  .box
  {
    width:100%;
    max-width:600px;
    background-color:#f9f9f9;
    border:1px solid #ccc;
    border-radius:5px;
    padding:16px;
    margin:0 auto;
  }
  input.parsley-success,
  select.parsley-success,
  textarea.parsley-success {
    color: #468847;
    background-color: #DFF0D8;
    border: 1px solid #D6E9C6;
  }
  input.parsley-error,
  select.parsley-error,
  textarea.parsley-error {
    color: #B94A48;
    background-color: #F2DEDE;
    border: 1px solid #EED3D7;
  }
  .parsley-errors-list {
     margin: 2px 0 3px;
     padding: 0;
     list-style-type: none;
     font-size: 0.9em;
     line-height: 0.9em;
     opacity: 0;

     transition: all .3s ease-in;
     -o-transition: all .3s ease-in;
     -moz-transition: all .3s ease-in;
     -webkit-transition: all .3s ease-in;
  }
  .parsley-errors-list.filled {
    opacity: 1;
  }
  .parsley-type, .parsley-required, .parsley-equalto{
    color:#ff0000;
  } 
 </style>
<body style="background-color: #4028d8;">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">RuangDIGITAL</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(assets/images/login-register.jpg);">
        <div class="login-box card" style="border-radius: 0px;">
            <div class="card-body">
                <form method="post" class="form-horizontal form-material" id="validate_form">
                    <h3 class="box-title m-t-40 m-b-0">Registrasi</h3><small> </small>
                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="nama_depan" id="nama_depan" required data-parsley-pattern="^[a-zA-Z]+$" data-parsley-trigger="keyup" placeholder="Nama Depan">
                        </div>
                    </div>
                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="nama_belakang" id="nama_belakang" required data-parsley-pattern="^[a-zA-Z ]+$" data-parsley-trigger="keyup" placeholder="Nama Belakang">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="email" id="email" required data-parsley-type="email" data-parsley-trigger="focusout" data-parsley-checkemail data-parsley-checkemail-message="Email sudah terdaftar" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required data-parsley-length="[6, 16]" data-parsley-trigger="keyup">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" data-parsley-equalto="#password" data-parsley-trigger="keyup" required>
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
                            <input class="btn btn-info btn-lg btn-block btn-rounded waves-effect waves-light" type="submit" id="submit" name="submit" value="Registrasi">
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
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/dist/parsley.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>

    <script>  
      $(document).ready(function(){  

      $('#validate_form').parsley();
      $('#validate_form').on('submit', function(event){
        event.preventDefault();
        if($('#validate_form').parsley().isValid())
        {
          $.ajax({
          url:"proses_registrasi.php",
          method:"POST",
          data:$(this).serialize(),
          beforeSend:function(){
          $('#submit').attr('disabled','disabled');
          $('#submit').val('Submitting...');
        },
          success:function(data)
          {
            $('#validate_form')[0].reset();
            $('#validate_form').parsley().reset();
            $('#submit').attr('disabled',false);
            $('#submit').val('Submit');
            alert(data);
          }
          });
        }
        });
      });  
    </script>
</body>

</html>