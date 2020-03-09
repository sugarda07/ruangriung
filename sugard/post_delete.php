<?php

include('../koneksi.php');

if(isset($_POST["post_id"]))
{
	$image = get_image_post($connect, $_POST["post_id"]);
	if($image != '')
	{
		unlink("../data/posting/images/".$image);
	}
	$statement = $connect->prepare(
		"DELETE FROM postingan WHERE post_id = :post_id"
	);
	$result = $statement->execute(
		array(
			':post_id'	=>	$_POST["post_id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Data telah dihapus';
	}
}



?>