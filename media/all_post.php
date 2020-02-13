<div class="content-wrapper" style="padding-top: 58px; padding-bottom: 58px;">
    <div class="container">
      	<div class="row">
      		<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#foto" data-toggle="tab">Foto</a></li>
              <li><a href="#video" data-toggle="tab">Video</a></li>
              <li><a href="#ebook" data-toggle="tab">e-Book</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="foto">
                <!-- Post -->
                	<div class="box box-primary" style="margin-bottom: 0px;">
			            <div class="box-header with-border">
			              <div class="has-feedback">
			                  <input type="search" id="cari_foto" name="cari_foto" class="form-control input-sm" placeholder="Cari Foto" aria-label="Search" autocomplete="off">
			                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
			                </div>
			            </div>
			            <div class="box-body" style="margin-bottom: 0px;">
			                <div class="gallery-section">
				      			<div class="inner-width">
						      		<div class="gallery">

						      		<?php 
							            $query = "
							            SELECT * FROM postingan
							            JOIN user ON postingan.user_id = user.user_id
							              WHERE postingan.user_id != '".$_SESSION["user_id"]."'
							              ORDER BY RAND()
							              LIMIT 48
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
                <!-- /.post -->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="video">
                <!-- The timeline -->
                <div class="box-body" style="padding:0px;">
                	<!-- /.<img src="https://img.youtube.com/vi/Jk7rliZpuSs/hqdefault.jpg">-->
                	<div class="box box-primary" style="margin-bottom: 0px;">
			            <div class="box-header with-border">
			              <div class="has-feedback">
			                  <input type="search" id="cari_video" name="cari_video" class="form-control input-sm" placeholder="Cari Video" aria-label="Search" autocomplete="off">
			                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
			                </div>
			            </div>
			            <div class="box-body" style="margin-bottom: 0px;">


			      		<?php 
				            $query = "
				            SELECT * FROM postingan
				            JOIN user ON postingan.user_id = user.user_id
				              WHERE postingan.user_id != '".$_SESSION["user_id"]."'
				              ORDER BY RAND()
				              LIMIT 8
				            ";
				            $statement = $connect->prepare($query);
				            $statement->execute();
				            $result = $statement->fetchAll();
				            $total_row = $statement->rowCount();

				            foreach($result as $row)
				            {
				                if($row['post_video'] != '')
				                {
				                    echo '

				                    <ul class="products-list product-list-in-box">
						                <li class="item" style="padding-top: 5px; padding-bottom: 5px; border-bottom: 1px solid #f4f4f4;">
						                  <div class="product-img">
						                    <a class="image" href="media/view_posting.php?data='.$row['post_id'].'" title="'.$row['nama_depan'].' - '.$row['post_konten'].'">
					                			<video class="img-responsive" src="images/post/'.$row["post_video"].'" style="padding: unset; width: 120px; height:auto;"></video>
							                </a>
						                  </div>
						                  <div class="product-info" style="margin-left: 130px;">
						                    <a href="javascript:void(0)" class="product-title">'.$row['nama_depan'].'</a>
						                      <span class="product-description"><small>'.tgl_indo($row['post_tgl']).'</small></span>
						                        <span class="product-description">
						                          '.$row['post_konten'].'
						                        </span>
						                  </div>
						                </li>
						              </ul>
				                ';
				                }
				                if($row['post_embed'] != '')
				                {
				                    echo '
				                    <ul class="products-list product-list-in-box">
						                <li class="item" style="padding-top: 5px; padding-bottom: 5px; border-bottom: 1px solid #f4f4f4;">
						                  <div class="product-img">
						                    <a class="image" href="media/view_posting.php?data='.$row['post_id'].'" title="'.$row['nama_depan'].' - '.$row['post_konten'].'">
					                			<img src="https://img.youtube.com/vi/'.$row["post_embed"].'/hqdefault.jpg" alt="Product Image" style="width: 120px; height:auto;">
							                </a>
						                  </div>
						                  <div class="product-info" style="margin-left: 130px;">
						                    <a href="javascript:void(0)" class="product-title">'.$row['nama_depan'].'</a>
						                      <span class="product-description"><small>'.tgl_indo($row['post_tgl']).'</small></span>
						                        <span class="product-description">
						                          '.$row['post_konten'].'
						                        </span>
						                  </div>
						                </li>
						              </ul>
				                ';
				                }               
				            }
				        ?>
				        </div>
				    </div>
		        </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="ebook">
              	<div class="box box-primary" style="margin-bottom: 0px;">
	            <div class="box-header with-border">
	              <div class="has-feedback">
	                  <input type="search" id="cari_ebook" name="cari_ebook" class="form-control input-sm" placeholder="Cari e-Book" aria-label="Search" autocomplete="off">
	                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
	                </div>
	            </div>
	            <div class="box-body" style="margin-bottom: 0px;">
	              <ul class="contacts-list">
	              	<?php 
				            $query = "
				            SELECT * FROM postingan
				            JOIN user ON postingan.user_id = user.user_id
				            ORDER By post_id DESC
				            LIMIT 20
				            ";
				            $statement = $connect->prepare($query);
				            $statement->execute();
				            $result = $statement->fetchAll();
				            $total_row = $statement->rowCount();

				            foreach($result as $row)
				            {
				                if($row['post_ebook'] != '')
				                {
				                    echo '

				                    <li>
							          <a href="media/view_posting.php?data='.$row['post_id'].'">    	
							          <img class="contacts-list-img" src="images/profile_image/'.$row["profile_image"].'" alt="User Image" style="border-radius: 3%;">
							          <div class="contacts-list-info">
							                <span class="contacts-list-name" style="color: #230069;">
							                  '.$row['post_konten'].'
							                  <small class="contacts-list-date pull-right" style="color: #687b8e;">'.tgl_indo($row['post_tgl']).'</small>
							                </span>
							            		<span class="contacts-list-msg" style="color: ;">'.$row['nama_depan'].'

							            	<small class="contacts-list-date pull-right"><span></span></small>
							            </span>
							          </div>
							        </a>
							      </li>
				                ';
				                }				               
				            }
				        ?>
	              		
	              </ul>
	            </div>
	          </div>
	       <!-- /.<div class="embed-responsive embed-responsive-16by9">
	       <iframe src="dokumen/simulasidankomunikasidigital-2.pdf" width="640" height="480"></iframe>
	              	<embed src="dokumen/simulasidankomunikasidigital-2.pdf" type='application/pdf' width='100%'/>
	              </div>-->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
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
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/plugins/jquery-ui/jquery-ui.js"></script>

<script>
  $(document).ready(function(){
      
    $('#cari_foto').autocomplete({
      source: "media/cari_foto.php",
      minLength: 1,
      select: function(event, ui)
      {
        $('#cari_foto').val(ui.item.value);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

  });
</script>

<script>
  $(document).ready(function(){
      
    $('#cari_video').autocomplete({
      source: "media/cari_video.php",
      minLength: 1,
      select: function(event, ui)
      {
        $('#cari_video').val(ui.item.value);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

  });
</script>

<script>
  $(document).ready(function(){
      
    $('#cari_ebook').autocomplete({
      source: "media/cari_ebook.php",
      minLength: 1,
      select: function(event, ui)
      {
        $('#cari_ebook').val(ui.item.value);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.label)
        .appendTo(ul);
    };

  });
</script>