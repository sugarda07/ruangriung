<?php

if(isset($_GET["tag"])) 
{
    $tag = preg_replace("#[^a-zA-Z0-9_]#", '', $_GET["tag"]);
    $output = '
    <div class="card-body">
        <h4 class="card-title">Hasil pencarian "'.$tag.'"</h4>
            <ul class="search-listing">
        ';
    $query = "
    SELECT * FROM postingan
    JOIN user ON user.user_id = postingan.user_id
    where post_konten LIKE '%".$tag."%'
    ORDER BY postingan.post_id DESC
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    foreach($result as $row)
    {
        $konten_konten = $row["post_konten"];
        $string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
        $string = convertToLink($string); 
        if($row['post_konten'] != '')
        {
        $output .= '
            <li>
                <h3><a href="view_posting.php?data='.$row['post_id'].'">'.$row["nama_depan"].'</a></h3>
                <h6 class="search-links">'.tgl_ago($row["post_tgl"]).'</h6>
                <p>'.substr($string, 0,160).'</p>
            </li>                                   
        ';
        }
        $output = '</ul></div>';
    echo $output;
    }
}

?>