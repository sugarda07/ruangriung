<?php


include('../inc/koneksi.php');

session_start();

echo Get_nama_depan($_SESSION['user_id'], $_POST['to_user_id'], $connect);

?>