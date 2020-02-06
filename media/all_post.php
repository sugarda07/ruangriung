<div class="content-wrapper" style="padding-top: 58px; padding-bottom: 58px;">
    <div class="container">
      	<div class="row">
      		<div class="gallery-section">
      			<div class="inner-width">
		      		<div class="gallery">

		      		<?php 
			            $query = "
			            SELECT * FROM postingan
			            JOIN user ON postingan.user_id = user.user_id
			              WHERE postingan.user_id != '".$_SESSION["user_id"]."'
			              ORDER BY RAND()
			            ";
			            $statement = $connect->prepare($query);
			            $statement->execute();
			            $result = $statement->fetchAll();
			            $total_row = $statement->rowCount();

			            foreach($result as $row)
			            {
			                if($row['post_gambar'] != '')
			                {
			                    echo '
			                <a class="image" href="media/view_posting.php?data='.$row['post_id'].'" title="'.$row['nama_depan'].' - '.$row['post_konten'].'">
			                    <img class="img-responsive" alt="image" src="images/post/'.$row['post_gambar'].'">
			                </a>
			                ';
			                }
			                else
			                {
			                    echo ' ';
			                }                
			            }
			        ?>

			        </div>
			    </div>
	        </div>
      	</div>
    </div>
</div>

<div id="post_allmodal" class="modal fade vn-modal-slide-left" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa fa-arrow-left" style="margin-left: 20px;"></i></span></button>
        <h4 class="modal-title" style="margin-left: 40px; margin-bottom: 25px;"><small></small></h4>
      </div>
      <div class="modal-body" id="posting_all_list" style="background: #eeebef;">

      </div>
    </div>
  </div>
</div>