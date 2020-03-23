<?php 

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

$user_data = array();

$exam->query = "SELECT * FROM user";

$result = $exam->query_result();

foreach($result as $key => $val)
{
	$user_data[$key]['id'] = $val['user_id'];
	$user_data[$key]['name'] = $val['user_nama_depan'];
	$user_data[$key]['avatar'] = "data/akun/profil/".$val['user_foto']."";
	$user_data[$key]['type'] = 'user';
}
header('Content-Type: application/json');
echo json_encode($user_data);
?>