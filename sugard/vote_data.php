<?php

include('../koneksi.php');
include('../function.php');
session_start();

$query = "
SELECT * FROM postingan
INNER JOIN user ON user.user_id = postingan.user_id
WHERE postingan.post_gambar != ''
ORDER BY postingan.post_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table id="post_datatabel" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th width="5%">PostId</td>
			<th width="25%">Username</td>
			<th width="15%">Konten</td>
			<th width="20%">Vote</td>
			<th width="20%">Vote</td>
			<th width="15%">Tanggal</td>
		</tr>
	</thead> 
';

foreach($result as $row)
{
	$rating = count_rating($row['post_id'], $_SESSION['id_admin'], $connect);
	$ratingall = count_ratingAll($row['post_id'], $connect);
	$rata2 = count_vote($row['post_id'], $connect);
	$color = '';
	$bintang = '';

	for($count=1; $count<=5; $count++)
	{
	if($count <= $rating)
	{
		$color = 'color:#ffcc00;';
	}
	else
	{
		$color = 'color:#ccc;';
	}
		$bintang .= '<li title="'.$count.'" id="'.$row['post_id'].'-'.$count.'" data-index="'.$count.'"  data-post_id="'.$row['post_id'].'" data-rating="'.$rating.'" data-id_admin="'.$_SESSION['id_admin'].'" class="rating" style="cursor:pointer; '.$color.' font-size:16px;">&#9733;</li>';
	}

	$output .= '
	<tr>
		<td>'.$row['post_id'].'</td>
		<td><img src="../data/akun/profil/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br><small>'.$row['email'].'</small></td>
		<td><img src="../data/posting/images/'.$row['post_gambar'].'" style="float:left; margin-right:10px;" height="50" width="50"></td>
		<td><ul class="list-inline" data-rating="'.$rating.'" title="Average Rating - '.$rating.'"> '.$bintang.' </ul></td>
		<td><small>Votes record: '.$ratingall.' ('.$rata2.') </small></td>
		<td><small>'.tgl_indo($row['post_tgl']).'</small></td>
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

function count_rating($post_id, $id_admin, $connect)
{
 $output = 0;
 $query = "SELECT AVG(rating) as rating FROM rating WHERE rating_post_id = '".$post_id."' AND rating_user_id ='".$id_admin."' ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $total_row = $statement->rowCount();
 if($total_row > 0)
 {
  foreach($result as $row)
  {
   $output = round($row["rating"]);
  }
 }
 return $output;
}

function count_ratingAll($post_id, $connect)
{
 $output = 0;
 $query = "SELECT sum(rating) as rating FROM rating WHERE rating_post_id = '".$post_id."' ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $total_row = $statement->rowCount();
 if($total_row > 0)
 {
  foreach($result as $row)
  {
   $output = round($row["rating"]);
  }
 }
 return $output;
}

function count_vote($post_id, $connect)
{
 $output = 0;
 $query = "SELECT AVG(rating) as rating FROM rating WHERE rating_post_id = '".$post_id."' ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $total_row = $statement->rowCount();
 if($total_row > 0)
 {
  foreach($result as $row)
  {
   $output = round($row["rating"], 1);
  }
 }
 return $output;
}

?>