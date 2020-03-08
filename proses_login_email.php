<?php
include('koneksi.php');

if(isset($_POST["email"]))
{

 $query = "
 SELECT * FROM user 
 WHERE email = '".trim($_POST["email"])."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $total_row = $statement->rowCount();

 if($total_row == 0)
 {
  $output = array(
   'success' => true
  );

  echo json_encode($output);
 }
}

?>