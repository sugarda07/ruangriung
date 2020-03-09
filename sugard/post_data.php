<?php

include('../koneksi.php');

session_start();

$query = "
SELECT * FROM postingan JOIN user
WHERE postingan.user_id = user.user_id
ORDER BY postingan.post_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table id="post_datatabel" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="30%">Username</td>
			<th width="40%">Konten</td>
			<th width="20%">Tanggal</td>
			<th width="10%">Action</td>
		</tr>
	</thead> 
';

foreach($result as $row)
{
	if($row['post_gambar'] !='')
	{				
		$output .= '
		<tr>
			<td><img src="../data/akun/profil/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br>'.$row['email'].'</td>
			<td><img src="../data/posting/images/'.$row['post_gambar'].'" style="float:left; margin-right:10px;" height="40" width="40"> '.strip_tags($row['post_konten']).'</td>
			<td>'.$row['post_tgl'].'</td>
			<td><button type="button" name="delete" id="'.$row["post_id"].'" class="btn btn-xs btn-danger btn-flat delete"><i class="fa fa-trash"></i></button></td>
		</tr>
		';
	}
	else
	{
		$output .= '
		<tr>
			<td><img src="../data/akun/profil/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br>'.$row['email'].'</td>
			<td>'.strip_tags($row["post_konten"]).'</td>
			<td>'.$row['post_tgl'].'</td>
			<td><button type="button" name="delete" id="'.$row["post_id"].'" class="btn btn-xs btn-danger btn-flat delete"><i class="fa fa-trash"></i></button></td>
		</tr>
		';
	}
	
}

$output .= '</table>
<script>
  $(function () {
    $("#post_datatabel").DataTable();
  });
</script>';

echo $output;

?>