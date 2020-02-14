<?php
include('inc/koneksi.php');
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
  $sekolah = trim($_POST["sekolah"]);
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
      if(empty($sekolah))
      {
        $message .= 'Nama Sekolah belum di isi';
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
          ':email'      =>  $email,
          ':sekolah'    =>  $sekolah
        );

        $query = "
        INSERT INTO user 
        (username, password, nama_depan, email, sekolah, profile_image) 
        VALUES (:username, :password, :nama_depan, :email, :sekolah, 'user.png')
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
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registrasi</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/plugins/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
</head>
<body class="hold-transition register-page" style="background-color: #2c2c9e;">
<div class="register-box" style="margin-top: 60px">
  <div class="register-logo">
    <a href="" style="color: aqua;"><b>Ruang</b>DIGITAL</a>
  </div>

  <div class="register-box-body" style="border-radius: 9px;">
    <p class="login-box-msg"><?php echo $message; ?></p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="text" name="nama_depan" class="form-control" placeholder="Nama Depan">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username">
        <span class="fa fa-user-secret form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <select class="form-control" name="sekolah" placeholder="Nama Sekolah">
          <option>Pilih Nama Sekolah</option>
          <option>SMK AL-HIKMAH TAROGONG KALER</option>
          <option>SMK ASSHIDDIQIYAH GARUT</option>
          <option>SMK IKA KARTIKA GARUT</option>
        </select>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="confirm_password" class="form-control" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" name="register" class="btn btn-primary btn-block btn-flat">Registrasi</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <br>
    <a href="login.php" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>