<?php

include('../koneksi.php');
include('../function.php');

session_start();

$query = "
SELECT * FROM user
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table id="user_datatabel" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="">Nama</td>
			<th width="">Email</td>
			<th width="">Password</td>
			<th width="">Sekolah</td>
			<th width="">Status</td>
			<th width="">Action</td>
		</tr>
	</thead> 
';

foreach($result as $row)
{
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
	if($user_last_activity > $current_timestamp)
	{
		$status = '<span class="label label-success">Online</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Offline</span>';
	}
		$sekolah_nama = '';
	 if($row['kelas'] == '')
        {
          $sekolah_nama = '<em style="color: #d1d6da;">Nama Sekolah belum diatur</em>';
        }
        else
        {
          $sekolah_nama = ''.get_sekolah($connect, $row["user_id"]).'';
        }
	$output .= '
	<tr>
		<td>'.$row['nama_depan'].'</td>
		<td>'.$row['email'].'</td>
		<td>'.$row['password'].'</td>
		<td>'.$sekolah_nama.'</td>
		<td>'.$status.'</td>
		<td>Aksi</td>
	</tr>
	';
}

$output .= '</table>
<script>
  $(function () {
    $("#user_datatabel").DataTable();
  });
</script>';

echo $output;

?>