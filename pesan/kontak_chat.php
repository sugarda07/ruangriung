<?php

include('../master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

if(isset($_GET["term"]))
{
	$exam->query = "
	SELECT * FROM user 
	WHERE user_nama_depan LIKE '%".$_GET["term"]."%'
	AND user_id != '".$_SESSION["user_id"]."'
	ORDER BY user_nama_depan ASC
	";

	$result = $exam->query_result();

	$total_row = $exam->total_row();

	$output = array();
	if($total_row > 0)
	{
  		foreach($result as $row)
  		{
			$temp_array = array();
			$temp_array['value'] = $row['user_username'];
			if($row['user_foto'] != 'user.png')
			{
				$temp_array['label'] = '
				  <a href="#" class="start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['user_username'].'" data-foto="../data/akun/profil/'.$row["user_foto"].'">
				      <img src="../data/akun/profil/'.$row["user_foto"].'" class="img-circle sm" alt="User Image" width="40">
				      &nbsp;&nbsp;&nbsp;'.$row['user_nama_depan'].' &nbsp;<small><span class="text-muted"> </small></span>
				  </a>
				';
			}
			else
			{
			  $temp_array['label'] = '
			      <a href="#" class="start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['user_username'].'" data-foto="../data/akun/profil/'.$row["user_foto"].'">
			          <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["user_nama_depan"], 0,1).'</span>
			          &nbsp;&nbsp;&nbsp;'.$row['user_nama_depan'].' &nbsp;<small><span class="text-muted"> </small></span>
			      </a>
			    ';
			}   
   			$output[] = $temp_array;
  		}
 	}
	else
	{
		$output['value'] = '';
		$output['label'] = '<span class="text-muted">Data tidak ditemukan</span>';
	}
	echo json_encode($output);
}

?>