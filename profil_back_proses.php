<?php
include ('koneksi.php');
session_start();

if(isset($_POST["image"]))
{
	$image = $_POST['image'];

	list($type, $image) = explode(';',$image);
	list(, $image) = explode(',',$image);

	$image = base64_decode($image);
	$image_name = time().'.jpg';
	file_put_contents('data/akun/background/'.$image_name, $image);

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

	$query_cari = "SELECT profile_image FROM user WHERE user_id = '".$_SESSION["user_id"]."' ";
	$statement = $connect->prepare($query_cari);
	$statement->execute();
	$query_result = $statement->fetchAll();
	foreach($query_result as $row)
	{
		$nama_foto = $row["profile_image"];
	}

	if($nama_foto != 'user.png')
	{
		unlink("data/akun/profil/".$nama_foto);

		list($type, $image) = explode(';',$image);
		list(, $image) = explode(',',$image);

		$image = base64_decode($image);
		$image_name = time().'.jpg';
		file_put_contents('data/akun/profil/'.$image_name, $image);

		$query = "UPDATE user SET  profile_image = '".$image_name."' WHERE user_id = '".$_SESSION["user_id"]."' ";

		$statement = $connect->prepare($query);

		$statement->execute();
	}
	else
	{
		list($type, $image) = explode(';',$image);
		list(, $image) = explode(',',$image);

		$image = base64_decode($image);
		$image_name = time().'.jpg';
		file_put_contents('data/akun/profil/'.$image_name, $image);

		$query = "UPDATE user SET  profile_image = '".$image_name."' WHERE user_id = '".$_SESSION["user_id"]."' ";

		$statement = $connect->prepare($query);

		$statement->execute();
	}	
}

?>