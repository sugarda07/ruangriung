<?php
include('koneksi.php');
session_start();
$message = '';
if(isset($_SESSION['user_id']))
{
  header('location:index.php');
}

if(isset($_POST['login']))
{
    if(empty($_POST["email"]) || empty($_POST["password"]))  
    {  
        $message = '<label>All fields are required</label>';  
    }
    else
    {
        $query = "
        SELECT * FROM user 
        WHERE email = :email
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
              ':email' => $_POST["email"]
            )
        );  
        $count = $statement->rowCount();
        if($count > 0)
        {
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                if(password_verify($_POST["password"], $row["password"]))
                {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['email'] = $row['email'];
                    $sub_query = "
                    INSERT INTO login_details 
                    (user_id) 
                    VALUES ('".$row['user_id']."')
                    ";
                    $statement = $connect->prepare($sub_query);
                    $statement->execute();
                    $_SESSION['login_details_id'] = $connect->lastInsertId();
                    header('location:index.php');
                }
                else
                {
                    $message = 'Password Salah, silahkan coba kembali';
                }
            }
        }
        else
        {
            $message = 'Email Salah, silahkan coba kembali';
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
    <link href="assets/dist/css/style.css" rel="stylesheet">
    
    
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
        <div class="login-box card" style="border-radius: 20px;">
            <div class="card-body">
                <form method="post" class="form-horizontal form-material" id="validate_form">
                    <p><?php echo $message; ?></p>
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" name="email" id="email" type="text" placeholder="Email" required data-parsley-type="email" data-parsley-trigger="focusout" data-parsley-checkemail data-parsley-checkemail-message="email sudah terdaftar">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" name="password" id="password" type="password" placeholder="Password" required data-parsley-length="[4, 16]" data-parsley-trigger="keyup">
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
                            <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded waves-effect waves-light" name="login" type="submit">LogIn</button>
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
    <!--Custom JavaScript -->
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
      
      });  
    </script>
    
</body>

</html>