<?php

include('koneksi.php');

session_start();

$query = "
SELECT * FROM postingan
INNER JOIN user ON user.user_id = postingan.user_id
INNER JOIN rating ON rating.rating_post_id = postingan.post_id
WHERE postingan.post_gambar != '' AND postingan.user_id = '".$_SESSION['user_id']."' AND rating.rating_post_id=postingan.post_id
ORDER BY postingan.post_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '';

foreach($result as $row)
{
  $rating = count_rating($row['post_id'], $connect);
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
    $bintang .= '<li title="'.$count.'" id="'.$row['post_id'].'-'.$count.'" data-index="'.$count.'"  data-post_id="'.$row['post_id'].'" data-rating="'.$rating.'" data-user_id="'.$_SESSION['user_id'].'" class="rating" style="cursor:pointer; '.$color.' font-size:25px;">&#9733;</li>';
  }

  $output .= '
  <div class="row m-b-20">
      <div class="col-4">
        <a href="javascript:void()"><img src="data/posting/images/'.$row['post_gambar'].'" class="img-fluid" alt="alb" /></a>
      </div>
      <div class="col-8">
          <h5 class="card-title m-b-5">
            <ul class="list-inline" data-rating="'.$rating.'" title="Average Rating - '.$rating.'" style="margin-bottom: 0px;"> '.$bintang.' </ul>
          </h5>
          <span class="text-muted">votes record: ( '.$rata2.' )</span>
          <h6 class="card-title m-b-5"> '.strip_tags(substr($row['post_konten'], 0, 25)).'</h6>
      </div>
  </div>
  ';  
}

$output .= '';

echo $output;

function count_rating($post_id, $connect)
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