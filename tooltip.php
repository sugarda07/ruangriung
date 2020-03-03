<?php

include ('koneksi.php');

session_start();

if(isset($_POST["id"]))
{
 $query = "SELECT * FROM user WHERE username = '".$_POST["id"]."'";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 $output = '';

 foreach($result as $row)
 {
  $output .= '
  <img src="data/akun/profil/'.$row["profile_image"].'" class="img-thumbnail" />
  <h4>'.$row["nama_depan"].'</h4>
  <h4>'.$row["sekolah"].'</h4>
  ';
 }
 echo $output;
}

?>