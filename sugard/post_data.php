<?php

include('../inc/koneksi.php');

session_start();

$query = "
SELECT * FROM postingan JOIN user
WHERE postingan.user_id = user.user_id
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table id="post_datatabel" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="">Username</td>
			<th width="">Konten</td>
			<th width="">Tanggal</td>
			<th width="">Action</td>
		</tr>
	</thead> 
';

foreach($result as $row)
{
	$output .= '
	<tr>
		<td><img src="../images/profile_image/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br>'.$row['email'].'</td>
		<td><img src="../images/post/'.$row['post_gambar'].'" style="float:left; margin-right:10px;" height="40" width="40"> '.$row['post_konten'].'</td>
		<td>'.$row['post_tgl'].'</td>
		<td><button type="button" name="delete" id="'.$row["post_id"].'" class="btn btn-xs btn-danger btn-flat delete"><i class="fa fa-trash"></i></button></td>
	</tr>
	';
}

$output .= '</table>
<script>
  $(function () {
    $("#post_datatabel").DataTable();
  });
</script>';

echo $output;

?>