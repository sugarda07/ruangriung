<?php 
include('../koneksi.php');
session_start();

$user_data = array();
$users = $connect->query("select * from user");
foreach($users as $key => $val)
{
$user_data[$key]['id'] = $val['user_id'];
$user_data[$key]['name'] = $val['username'];
$user_data[$key]['avatar'] = "../data/akun/profil/".$val['profile_image']."";
$user_data[$key]['type'] = 'user';
}
header('Content-Type: application/json');
echo json_encode($user_data);
?>