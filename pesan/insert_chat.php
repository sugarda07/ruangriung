<?php

include('../master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

$exam->data = array(
	':to_user_id'		=>	$_POST['to_user_id'],
	':from_user_id'		=>	$_SESSION['user_id'],
	':chat_konten'		=>	nl2br($_POST['chat_message']),
	':time_chat'		=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
	':status'			=>	'1'
);

$exam->query = "
INSERT INTO chat_message 
(to_user_id, from_user_id, chat_konten, time_chat, status) 
VALUES (:to_user_id, :from_user_id, :chat_konten, :time_chat, :status)
";


if($exam->execute_query())
{
	echo $exam->fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id']);
}

?>