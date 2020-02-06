<?php
include('../inc/koneksi.php');
session_start();

$query = "SELECT * FROM user WHERE user_id = ".$_SESSION['user_id']." ";

$statement = $connect->prepare($query);

$output = '';

if($statement->execute())
{
 $result = $statement->fetchAll();

 foreach($result as $row)
 {
 	if($row['profile_image'] != '')
		{
			$foto_profile = '<img class="img-circle" src="images/profile_image/'.$row["profile_image"].'" alt="User Avatar">';
		}
		else
		{
			$foto_profile = '<img class="img-circle" src="images/profile_image/user.png" alt="User Avatar">';
		}
		$output .= '
		'.$foto_profile.'
		<a href="#"><span class="widget-user-image label label-info" style="top: 10px; margin-left: 25px;"><label for="upload_fotoprofil" style="margin-bottom: 0px;"><i class="fa fa-camera"></i></label></span></a>
		';
	}
}
$output .= '';
echo $output;

?>