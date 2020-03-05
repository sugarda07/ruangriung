<?php


include('../koneksi.php');
include('../function.php');

session_start();

echo Get_foto($_SESSION['user_id'], $_POST['to_user_id'], $connect);

?>