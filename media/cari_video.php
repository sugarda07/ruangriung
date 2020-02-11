<?php

include('../inc/koneksi.php');
session_start();

if(isset($_GET["term"]))
{

 $query = "
 SELECT * FROM postingan
 JOIN user ON postingan.user_id = user.user_id
 WHERE postingan.post_konten LIKE '%".$_GET["term"]."%'
 AND postingan.post_embed !=''
 ORDER BY postingan.post_konten ASC
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
   $temp_array['value'] = $row['post_embed'];
   if($row['profile_image'] != '')
   {
      $temp_array['label'] = '
          <a href="media/view_posting.php?data='.$row['post_id'].'">
              <img src="images/profile_image/'.$row["profile_image"].'" class="img-circle sm" alt="User Image" width="40">
              &nbsp;&nbsp;&nbsp;'.$row['post_konten'].' &nbsp;<span class="text-muted"><small> </small></span>
          </a>
          ';
   }
   else
   {
      $temp_array['label'] = '
          <a href="media/view_posting.php?data='.$row['post_id'].'">
              <img src="images/profile_image/user.png" class="img-circle" alt="User Image" width="40">
              &nbsp;&nbsp;&nbsp;'.$row['post_konten'].' &nbsp;<span class="text-muted"><small> </small></span>
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