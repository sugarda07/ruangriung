<?php
include ('../inc/koneksi.php');
session_start();

//insert.php


	$image = $_POST['image'];
	$posting_upload = $_POST['konten'];

	list($type, $image) = explode(';',$image);
	list(, $image) = explode(',',$image);

	$image = base64_decode($image);
	$image_name = time().'.jpg';
	file_put_contents('../images/post/'.$image_name, $image);
	$data = array(
			':user_id'				=>	$_SESSION["user_id"],
			':post_konten'			=>	$posting_upload,
			':post_gambar'			=>	$image_name,
			':post_tgl'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
		);
	$query_gambar = "
	INSERT INTO postingan 
	(post_id, user_id, post_konten, post_gambar, post_tgl) 
	VALUES ('', :user_id, :post_konten, :post_gambar, :post_tgl)
	";
	$statement = $connect->prepare($query_gambar);
	$statement->execute($data);


	$notification_query = "
	SELECT receiver_id FROM follow 
	WHERE sender_id = '".$_SESSION["user_id"]."'
	";
	$statement = $connect->prepare($notification_query);
	$statement->execute();
	$notification_result = $statement->fetchAll();
	foreach($notification_result as $notification_row)
	{
		$query_gambar2 = "
		SELECT post_id FROM postingan
		WHERE user_id = '".$_SESSION["user_id"]."'
		";
		$statement = $connect->prepare($query_gambar2);
		$statement->execute();
		$gambar2_result = $statement->fetchAll();
		foreach($gambar2_result as $gambar2_row)
		{

		}

		$post_id = Get_post_id($connect, $gambar2_row["post_id"]);
        $notification_text= 'membuat postingan baru';
		$notif_sender_id = Get_user_id($connect, $_SESSION["user_id"]);
		$insert_query = "
		INSERT INTO pemberitahuan 
		(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification) 
		VALUES ('".$notification_row['receiver_id']."', '".$notif_sender_id."', '".$post_id."', '".$notification_text."', 'no')
		";
		$statement = $connect->prepare($insert_query);
		$statement->execute();
	}
?>