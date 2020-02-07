<?php

include('../inc/koneksi.php');

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
			<th width="">Username</td>
			<th width="">email</td>
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
	$output .= '
	<tr>
		<td>'.$row['username'].'</td>
		<td>'.$row['email'].'</td>
		<td>'.$row['sekolah'].'</td>
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