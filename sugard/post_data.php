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
			<td><img src="../images/profile_image/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br>'.$row['email'].'</td>
			<td><img src="../images/post/'.$row['post_gambar'].'" style="float:left; margin-right:10px;" height="40" width="40"> '.$row['post_konten'].'</td>
			<td>'.$row['post_tgl'].'</td>
			<td><button type="button" name="delete" id="'.$row["post_id"].'" class="btn btn-xs btn-danger btn-flat delete"><i class="fa fa-trash"></i></button></td>
		</tr>
		';
	}
	else if($row['post_video'] !='')
	{				
		$output .= '
		<tr>
			<td><img src="../images/profile_image/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br>'.$row['email'].'</td>
			<td><video class="img-responsive" controls src="images/post/'.$row["post_video"].'" type="video/mp4" style="padding: unset; float:left; margin-right:10px;" height="40" width="40"></video> '.$row['post_konten'].'</td>
			<td>'.$row['post_tgl'].'</td>
			<td><button type="button" name="delete" id="'.$row["post_id"].'" class="btn btn-xs btn-danger btn-flat delete"><i class="fa fa-trash"></i></button></td>
		</tr>
		';
	}
	else if($row['post_embed'] !='')
	{
		$output .= '
		<tr>
			<td><img src="../images/profile_image/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br>'.$row['email'].'</td>
			<td><iframe width="40" height="40" src="https://www.youtube.com/embed/'.$row["post_embed"].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="float:left; margin-right:10px;" height="40" width="40"></iframe> '.$row['post_konten'].'</td>
			<td>'.$row['post_tgl'].'</td>
			<td><button type="button" name="delete" id="'.$row["post_id"].'" class="btn btn-xs btn-danger btn-flat delete"><i class="fa fa-trash"></i></button></td>
		</tr>
		';
	}
	else if($row['post_ebook'] !='')
	{
		$output .= '
		<tr>
			<td><img src="../images/profile_image/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br>'.$row['email'].'</td>
			<td><a href="dokumen/'.$row["post_ebook"].'">'.$row["post_konten"].'</a></td>
			<td>'.$row['post_tgl'].'</td>
			<td><button type="button" name="delete" id="'.$row["post_id"].'" class="btn btn-xs btn-danger btn-flat delete"><i class="fa fa-trash"></i></button></td>
		</tr>
		';
	}
	else
	{
		$output .= '
		<tr>
			<td><img src="../images/profile_image/'.$row['profile_image'].'" style="float:left; margin-right:10px;" height="40" width="40"> <b>'.$row['username'].'</b><br>'.$row['email'].'</td>
			<td>'.$row["post_konten"].'</td>
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