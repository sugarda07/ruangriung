<?php 

include('master/koneksi.php');

$exam = new Koneksi;

$exam->user_session_private();

$limit = '20';
$page = 1;
if($_POST['page'] > 1)
{
	$start = (($_POST['page'] - 1) * $limit);
	$page = $_POST['page'];
}
else
{
	$start = 0;
}

$exam->query = "
SELECT * FROM postingan 
JOIN user ON user.user_id = postingan.user_id
";

if($_POST['query'] != '')
{
	$exam->query .= '
	WHERE postingan.post_konten LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" 
	';
}

$exam->query .= 'ORDER BY postingan.post_id DESC ';

$filter_query = $exam->query . 'LIMIT '.$start.', '.$limit.'';

$result = $exam->query_result();
$total_data = $exam->total_row();

$output = '
<div class="card-body" style="padding: 10px;">
    <ul class="search-listing">
';
if($total_data > 0)
{
	foreach($result as $row)
	{
		$konten_konten = $row["post_konten"];
		$string = strip_tags($konten_konten, "<a><b><i><u><em><strong>");
		$string = $exam->convertToLink($string);
		$output .= '    
		    <li style="padding-top: 5px;padding-bottom: 5px;">
		        <h3><a href="view_posting.php?data='.$row['post_id'].'">'.$row["user_nama_depan"].' '.$row["user_nama_belakang"].'</a></h3>
		        <h6 class="search-links">'.$exam->tgl_ago($row["post_tgl"]).'</h6>
		        <p style="margin-bottom: 5px;">'.substr($string, 0,200).'</p>
		    </li>
		';
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="2" align="center">Data tidak ditemukan</td>
	</tr>
	';
}
$output .= '
	</ul>
<nav aria-label="Page navigation example" class="m-t-20" style="margin-top: 30px;">
<ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

//echo $total_links;

if($total_links > 19)
{
	if($page < 20)
	{
		for($count = 1; $count <= 20; $count++)
		{
			$page_array[] = $count;
		}
		$page_array[] = '...';
		$page_array[] = $total_links;
	}
	else
	{
		$end_limit = $total_links - 20;
		if($page > $end_limit)
		{
			$page_array[] = 1;
			$page_array[] = '...';
			for($count = $end_limit; $count <= $total_links; $count++)
			{
				$page_array[] = $count;
			}
    	}
    	else
    	{
			$page_array[] = 1;
			$page_array[] = '...';
			for($count = $page - 1; $count <= $page + 1; $count++)
			{
				$page_array[] = $count;
			}
			$page_array[] = '...';
			$page_array[] = $total_links;
		}
	}
}
else
{
	for($count = 1; $count <= $total_links; $count++)
	{
		$page_array[] = $count;
	}
}

for($count = 0; $count < count($page_array); $count++)
{
	if($page == $page_array[$count])
	{
		$page_link .= '
	    <li class="page-item active">
	      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
	    </li>
	    ';
	    $previous_id = $page_array[$count] - 1;
	    if($previous_id > 0)
	    {
	      $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
	    }
    	else
    	{
			$previous_link = '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
		}
    	$next_id = $page_array[$count] + 1;
    	if($next_id >= $total_links)
    	{
    		$next_link = '
			<li class="page-item disabled">
			<a class="page-link" href="#">Next</a>
			</li>
			';
    	}
    	else
		{
			$next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
		}
	}
	else
	{
	    if($page_array[$count] == '...')
	    {
			$page_link .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
	    }
	    else
	    {
			$page_link .= '
			<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
			';
	    }
	}
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
    </ul>
</nav>
</div>
';

echo $output;

?>