<?php

include('../master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

$exam->query = "
UPDATE login_details 
SET is_type = '".$_POST["is_type"]."' 
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";
$exam->execute_query();

?>