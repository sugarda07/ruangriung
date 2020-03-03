<?php
include('koneksi.php');
session_start();
$message = '';
if(isset($_SESSION['user_id']))
{
  header('location:index.php');
}

if(isset($_POST["register"]))
{
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);
  $nama_depan = trim($_POST["nama_depan"]);
  $email = trim($_POST["email"]);
  $check_query = "
  SELECT * FROM user 
  WHERE email = :email
  ";
  $statement = $connect->prepare($check_query);
  $check_data = array(
    ':email'   =>  $email
  );
  if($statement->execute($check_data))  
  {
    if($statement->rowCount() > 0)
    {
      $message .= 'Email sudah Terdaftar atau Terpakai';
    }
    else
    {
      if(empty($username))
      {
        $message .= 'Username belum di isi';
      }
      if(empty($nama_depan))
      {
        $message .= 'Tulis Nama Lengkap';
      }
      if(empty($email))
      {
        $message .= 'email belum di isi';
      }
      if(empty($password))
      {
        $message .= 'Password belum di isi';
      }
      else
      {
        if($password != $_POST['confirm_password'])
        {
          $message .= 'Password tidak sama';
        }
      }
      if($message == '')
      {
        $data = array(
          ':username'   =>  $username,
          ':password'   =>  password_hash($password, PASSWORD_DEFAULT),
          ':nama_depan' =>  $nama_depan,
          ':email'      =>  $email
        );

        $query = "
        INSERT INTO user 
        (username, password, nama_depan, email, profile_image) 
        VALUES (:username, :password, :nama_depan, :email, 'user.png')
        ";
        $statement = $connect->prepare($query);
        if($statement->execute($data))
        {
          $message = "Registrasi Berhasil <br> <a href='login.php'>Login disini</a>";
        }
      }
    }
  }
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
        <div class="login-box card">
            <div class="card-body">
                <form method="post" class="form-horizontal form-material" id="loginform">
                    <a href="javascript:void(0)" class="text-center db"><br/><img src="assets/images/Rtext.png" alt="Home" /></a>
                    <h3 class="box-title m-t-40 m-b-0">Registrasi</h3><small><?php echo $message; ?></small>
                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="nama_depan" placeholder="Nama">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="username" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">I agree to all <a href="javascript:void(0)">Terms</a></label> 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" name="register">Registrasi</button>
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
</body>

</html>