<?php

include('../master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

if(isset($_POST["chat_message_id"]))
{
	$exam->query = "
	UPDATE chat_message 
	SET status = '2' 
	WHERE chat_message_id = '".$_POST["chat_message_id"]."'
	";

	$exam->execute_query();
}

?>