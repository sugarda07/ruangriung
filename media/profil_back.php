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
		if($row['back_profile'] != '')
		{
			$back_profile = '<div class="widget-user-header bg-black" style="background: url(images/back/'.$row['back_profile'].') round; height: 140px;">';
		}
		else
		{
			$back_profile = '<div class="widget-user-header bg-black" style="background: url(images/back/background.jpg) round; height: 140px;">';
		}
		$output .= '
		'.$back_profile.'
        	<a href="#">
        		<h5 class="widget-user-desc">
          		<label for="upload_backround" ><i class="fa fa-image"></i></label>
          		</h5>
          	</a>
        </div>
		';
	}
}
$output .= '';
echo $output;
?>