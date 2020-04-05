<?php

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

$array=array();
$rows=array();
$listnotif = $exam->listNotifUser($_SESSION['user_id']);

foreach ($listnotif[1] as $key) {
	$data['title'] = $key['user_nama_depan'];
	$data['msg'] = $key['notification_text'];
	$data['icon'] = "data/akun/profil/".$key['user_foto']."";
	$data['url'] = 'view_posting.php?data='.$key["notif_post_id"].'';
	$rows[] = $data;
	// update notification database
}
$array['notif'] = $rows;
$array['count'] = $listnotif[2];
$array['result'] = $listnotif[0];
echo json_encode($array);

?>