<?php

include "../koneksi.php";
include "../function.php";
session_start();

$array=array();
$rows=array();
$listnotif = listNotifUser($_SESSION['user_id'], $connect);

foreach ($listnotif[1] as $key) {
	$data['title'] = $key['nama_depan'];
	$data['msg'] = $key['notification_text'];
	$data['icon'] = "../data/akun/profil/".$key['profile_image']."";
	$data['url'] = '../view_posting.php?data='.$key["notif_post_id"].'';
	$rows[] = $data;
	// update notification database
	$nextime = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s'))+($key['notif_repeat']*60));
	updateNotif($key['notification_id'], $nextime, $connect);
}
$array['notif'] = $rows;
$array['count'] = $listnotif[2];
$array['result'] = $listnotif[0];
echo json_encode($array);

?>