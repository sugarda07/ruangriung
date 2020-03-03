<?php

include('../koneksi.php');
session_start();

if(isset($_GET["term"]))
{

 $query = "
 SELECT * FROM user 
 WHERE nama_depan LIKE '%".$_GET["term"]."%'
 AND user_id != '".$_SESSION["user_id"]."'
 ORDER BY nama_depan ASC
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 $total_row = $statement->rowCount();

 $output = array();
 if($total_row > 0)
 {
  foreach($result as $row)
  {
   $temp_array = array();
   $temp_array['value'] = $row['username'];
   if($row['profile_image'] != '')
   {
      $temp_array['label'] = '
          <a href="#" class="start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'" data-foto="../data/akun/profil/'.$row["profile_image"].'">
              <img src="../data/akun/profil/'.$row["profile_image"].'" class="img-circle sm" alt="User Image" width="40">
              &nbsp;&nbsp;&nbsp;'.$row['nama_depan'].' &nbsp;<small><span class="text-muted"> </small></span>
          </a>
          ';
   }
   else
   {
      $temp_array['label'] = '
          <a href="#" class="start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'" data-foto="../data/akun/profil/'.$row["profile_image"].'">
              <img src="../data/akun/profil/user.png" class="img-circle" alt="User Image" width="40">
              &nbsp;&nbsp;&nbsp;'.$row['nama_depan'].' &nbsp;<small><span class="text-muted"> </small></span>
          </a>
          ';
   }   
   $output[] = $temp_array;
  }
 }
 else
 {
  $output['value'] = '';
  $output['label'] = '<span class="text-muted">Data tidak ditemukan</span>';
 }
 echo json_encode($output);
}

?>