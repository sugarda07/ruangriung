<?php

//fetch_is_type_history.php
include('../koneksi.php');
include('../function.php');

session_start();

echo fetch_is_type_status($_SESSION['user_id'], $_POST['to_user_id'], $connect);

?>