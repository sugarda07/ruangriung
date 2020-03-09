<?php

//fetch.php

include "../koneksi.php";

if(isset($_POST["index"], $_POST["post_id"], $_POST["id_admin"]))
{
	$query = "
	SELECT * FROM rating 
	WHERE rating_post_id = '".$_POST["post_id"]."' 
	AND rating_user_id = '".$_POST["id_admin"]."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();

	$total_row = $statement->rowCount();

	if($total_row > 0)
	{
		$query = "
		UPDATE rating 
		SET rating = '".$_POST["index"]."' 
		WHERE rating_post_id = '".$_POST["post_id"]."' AND rating_user_id = '".$_POST["id_admin"]."'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		echo 'update';
	}
	else
	{
		$query = "
		INSERT INTO rating(rating_post_id, rating, rating_user_id) 
		VALUES (:rating_post_id, :rating, :rating_user_id)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
			':rating_post_id'	=> $_POST["post_id"],
			':rating'   		=> $_POST["index"],
			':rating_user_id'	=> $_POST["id_admin"]
			)
		);
		
		$notification_query = "
		SELECT user_id, post_konten FROM postingan 
		WHERE post_id = '".$_POST["post_id"]."'
		";
		$statement = $connect->prepare($notification_query);

		$statement->execute();

		$notification_result = $statement->fetchAll();

		foreach($notification_result as $notification_row)
		{
			
			$notification_text = 'Postingan Anda mendapat "'.$_POST["index"].'" Bintang';
			$data = array(
				':notification_receiver_id'	=>	$notification_row['user_id'],
				':notif_sender_id'			=>	$_POST["id_admin"],
				':notif_post_id'			=>	$_POST["post_id"],
				':notification_text'		=>	$notification_text,
				':read_notification'		=>	'no',
				':notif_time'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
				':notif_update'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
			);

			$insert_query = "
			INSERT INTO pemberitahuan 
				(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
				VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
			";
			$statement = $connect->prepare($insert_query);
			$statement->execute($data);			
		}
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'done';
		}
	}

	
}


?>
