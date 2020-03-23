<?php

//fetch_user_chat_history.php
include('../master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

echo $exam->fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id']);

?>