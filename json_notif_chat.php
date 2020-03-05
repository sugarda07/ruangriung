<?php

include "koneksi.php";
include "function.php";
session_start();

$array=array();
$rows=array();
$listnotifchat = listNotifchat($_SESSION['user_id'], $connect);

foreach ($listnotifchat[1] as $key) {
	$data['title'] = strip_tags($key['nama_depan']);
	$data['msg'] = strip_tags($key['chat_konten']);
	$data['icon'] = "data/akun/profil/".$key['profile_image']."";
	$data['url'] = '';
	$rows[] = $data;
	// update notification database
	updateNotifchat($key['chat_message_id'], $connect);
}
$array['notif'] = $rows;
$array['count'] = $listnotifchat[2];
$array['result'] = $listnotifchat[0];
echo json_encode($array);

?>