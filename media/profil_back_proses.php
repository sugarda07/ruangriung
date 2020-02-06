<?php
include ('../inc/koneksi.php');
session_start();

if(isset($_POST["image"]))
{
	$image = $_POST['image'];

	list($type, $image) = explode(';',$image);
	list(, $image) = explode(',',$image);

	$image = base64_decode($image);
	$image_name = time().'.jpg';
	file_put_contents('../images/back/'.$image_name, $image);

	$query = "UPDATE user SET  back_profile = '".$image_name."' WHERE user_id = '".$_SESSION["user_id"]."' ";

	$statement = $connect->prepare($query);

	if($statement->execute())
	{
		unlink($image_name);
	}
}

if(isset($_POST["profil"]))
{
	$image = $_POST['profil'];

	list($type, $image) = explode(';',$image);
	list(, $image) = explode(',',$image);

	$image = base64_decode($image);
	$image_name = time().'.jpg';
	file_put_contents('../images/profile_image/'.$image_name, $image);

	$query = "UPDATE user SET  profile_image = '".$image_name."' WHERE user_id = '".$_SESSION["user_id"]."' ";

	$statement = $connect->prepare($query);

	if($statement->execute())
	{
		unlink($image_name);
	}
}

?>