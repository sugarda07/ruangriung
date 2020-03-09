<?php

//fetch.php

include "koneksi.php";

if(isset($_POST["index"], $_POST["post_id"], $_POST["user_id"]))
{
	$query = "
	SELECT * FROM rating 
	WHERE rating_post_id = '".$_POST["post_id"]."' 
	AND rating_user_id = '".$_POST["user_id"]."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();

	$total_row = $statement->rowCount();

	if($total_row > 0)
	{
		$query = "
		UPDATE rating 
		SET rating = '".$_POST["index"]."' 
		WHERE rating_post_id = '".$_POST["post_id"]."' AND rating_user_id = '".$_POST["user_id"]."'
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
			':rating_post_id'  => $_POST["post_id"],
			':rating'   => $_POST["index"],
			':rating_user_id' => $_POST["user_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'done';
		}
	}

	
}


?>
