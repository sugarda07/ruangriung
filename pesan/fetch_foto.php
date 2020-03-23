<?php

include('../master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

echo $exam->Get_foto($_SESSION['user_id'], $_POST['to_user_id']);

?>