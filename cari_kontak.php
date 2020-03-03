<?php

include('koneksi.php');
include('function.php');
session_start();
/*function get_total_row($connect)
{
  $query = "
  SELECT * FROM tbl_webslesson_post
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  return $statement->rowCount();
}

$total_record = get_total_row($connect);*/

$limit = '10';
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

$query = "
SELECT * FROM user
";

if($_POST['query'] != '')
{
  $query .= '
  WHERE nama_depan LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" OR email LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
  AND user_id != '.$_SESSION['user_id'].'
  ';
}
else
{
  $query .= '
  WHERE nama_depan LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
  AND user_id != '.$_SESSION['user_id'].'
  ';
}

$query .= 'ORDER BY user_id ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '
<div class="card-body" style="padding-top: 5px;padding-bottom: 5px;">
  <h5 class="card-title">Hasil pencarian "'.$_POST['query'].'"</h5>
      <div class="message-box">
        <div class="message-widget message-scroll">
';
if($total_data > 0)
{
  foreach($result as $row)
  {
    if($row['profile_image'] != 'user.png')
    {
        $profile_image = '<img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle">';
    }
    else
    {
        $profile_image = '<span class="round" style="width: 45px; height: 45px; line-height: 45px;">'.substr($row["nama_depan"], 0,1).'</span>';
    }
    if($row['user_id'] != $_SESSION["user_id"])
    {
    $output .= '

            <a href="view_profil.php?data='.$row['user_id'].'">
              <div class="user-img" style="margin-bottom: 0px;"> '.$profile_image.' </div>
              <div class="mail-contnet" style="width: 80%;">
                <h5>'.$row["nama_depan"].' <span class="time pull-right">'.make_follow_button_list($connect, $row["user_id"], $_SESSION["user_id"]).'</span></h5>
                <span class="mail-desc">
                '.$row["email"].'
                </span>                 
              </div>
            </a>
    ';
    }
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
</div>
</div>
<nav aria-label="Page navigation example" class="m-t-20">
    <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

//echo $total_links;

if($total_links > 2)
{
  if($page < 3)
  {
    for($count = 1; $count <= 3; $count++)
    {
      $page_array[] = $count;
    }
    $page_array[] = '...';
    $page_array[] = $total_links;
  }
  else
  {
    $end_limit = $total_links - 3;
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
      $previous_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Previous</a>
      </li>
      ';
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
      $page_link .= '
      <li class="page-item disabled">
          <a class="page-link" href="#">...</a>
      </li>
      ';
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
';

echo $output;

?>