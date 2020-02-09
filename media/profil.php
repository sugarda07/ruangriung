<div class="content-wrapper" style="padding-top: 58px; padding-bottom: 58px;">
    <div class="container">
      	<div class="row">
      		<div class="col-md-4" style="padding-left: 0px; padding-right: 0px;">
	          <!-- Widget: user widget style 1 -->
	          <div class="box box-widget widget-user" style="margin-bottom: 10px;">
	            <!-- Add the bg color to the header using any of the bg-* classes -->
	            <div id="backround_tampil">
	            	
	            </div>
	            <div class="widget-user-image" id="load_fotoprofil"  style="top:88px;">
	            
	            </div>
	            <div class="box-footer">
	            	<div class="col-xs-12">
			            <div class="description-block" style="margin-top: 20px;">
			              <h5 class="description-header"><a href="#" data-toggle="modal" data-target="#edit_profilModal" title="Klik untuk edit data"><?php echo $log['nama_depan']; ?></a></h5>
			              <span class="description"><?php echo $log['email']; ?></span>
			            </div>
			          </div>
	              <div class="row">
	                <div class="col-xs-4 border-right">
	                  <div class="description-block">
	                    <h5 class="description-header"><a href="#" data-toggle="modal" data-target="#pengikut_modal"><?php echo $log["follower_number"];?></a></h5>
	                    <span class="description">Pengikut</span>
	                  </div>
	                  <!-- /.description-block -->
	                </div>
	                <!-- /.col -->
	                <div class="col-xs-4 border-right">
	                  <div class="description-block">
	                    <h5 class="description-header"><a href="#" class="view_post_profil" data-user_id="<?php echo $log["user_id"]; ?>"><?php echo count_postingan($connect, $log["user_id"]); ?></a></h5>
	                    <span class="description">Post</span>
	                  </div>
	                  <!-- /.description-block -->
	                </div>
	                <!-- /.col -->
	                <div class="col-xs-4">
	                  <div class="description-block">
	                    <h5 class="description-header"><a href="#" data-toggle="modal" data-target="#mengikuti_modal"><?php echo count_mengikuti($connect, $log["user_id"]); ?></a></h5>
	                    <span class="description">Mengikuti</span>
	                  </div>
	                  <!-- /.description-block -->
	                </div>
	                <!-- /.col -->
	              </div>
	              <!-- /.row -->
	            </div>
              <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                  <li><a href="#"><i class="fa fa-graduation-cap"></i>&nbsp;&nbsp;<?php echo $log["sekolah"]; ?> <span class="pull-right badge bg-green"></span></a></li>
                  <li><a href="#"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo $log["kelas"]; ?> <span class="pull-right badge bg-green"></span></a></li>
                </ul>
              </div>
	          </div>
	          <!-- /.widget-user -->
	        </div>

	        <div class="col-md-8" style="padding-left: 10px; padding-right: 10px;">
	        	<div class="gallery-section">
	      			<div class="inner-width">
			      		<div class="gallery">

			      		<?php 
				            $query = "
				            SELECT * FROM postingan
				            JOIN user ON postingan.user_id = user.user_id
				              WHERE postingan.user_id = '".$_SESSION["user_id"]."'
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
				                if($row['post_video'] != '')
				                {
				                    echo ' 
                            <a class="image" href="media/view_posting.php?data='.$row['post_id'].'" title="'.$row['nama_depan'].' - '.$row['post_konten'].'">
                              <video class="img-responsive" src="images/post/'.$row["post_video"].'" type="video/mp4"></video>
                          </a>';
				                }                
				            }
				        ?>

				        </div>
				    </div>
		        </div>
	        </div>
      	</div>
    </div>
</div>

<div id="fotoprofil_modal" class="modal fade vn-modal-slide-left" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa fa-arrow-left" style="margin-left: 15px;"></i></span></button>
        <h4 class="modal-title" style="margin-left: 40px;">Foto Profil</h4>
      </div>
      <div class="modal-body">
        <div id="tampil_gambar" align="center" style="position: absolute; top: -55px;"></div>        
	        <input type="file" name="upload_fotoprofil" id="upload_fotoprofil" accept=".jpg, .png"  style="display: none;"/>        
      </div>
      <div class="modal-footer">
            <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-info btn-flat btn-block crop_image">Simpan</button>
                  </span>
            </div>
        </div>
    </div>
  </div>
</div>

<div id="backround_modal" class="modal fade vn-modal-slide-left" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa fa-arrow-left" style="margin-left: 15px;"></i></span></button>
        <h4 class="modal-title" style="margin-left: 40px;">Background</h4>
      </div>
      <div class="modal-body">
        <div id="tampil_gambar_back" align="center" style="position: absolute; top: -55px;"></div>
        <input type="file" name="upload_backround" id="upload_backround" accept=".jpg, .png"  style="display: none;"/>
      </div>
        <div class="modal-footer">
            <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-info btn-flat btn-block crop_backround">Simpan</button>
                  </span>
            </div>
        </div>
    </div>
  </div>
</div>


<div id="pengikut_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><small>Pengikut</small> <b><?php echo $log['nama_depan']; ?></b></h4>
      </div>
      <div class="modal-body">
        <div class="box box-widget" id="pengikut_list" style="margin-bottom: 0px; box-shadow: none;">
        
        </div>
      </div>
    </div>
  </div>
</div>


<div id="mengikuti_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><b><?php echo $log['nama_depan']; ?></b> <small>mengikuti</small></h4>
      </div>
      <div class="modal-body">
        <div class="box box-widget" id="mengikuti_list" style="margin-bottom: 0px; box-shadow: none;">
        
        </div>
      </div>
    </div>
  </div>
</div>

<div id="edit_profilModal" class="modal fade vn-modal-slide-left" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa fa-arrow-left" style="margin-left: 15px;"></i></span></button>
        <h4 class="modal-title" style="margin-left: 40px;"><b><?php echo $log['nama_depan']; ?></b> <small>Edit</small></h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body" style="padding: 15px;">
          <div class="form-group" style="margin-bottom: 8px;">
            <label>Nama Depan</label>
            <input type="text" class="form-control" name="nama_depan" id="nama_depan" placeholder="Nama Depan" value="<?php echo $log["nama_depan"];?>"/>
          </div>
          <div class="form-group" style="margin-bottom: 8px;">
            <label>Nama Belakang</label>
            <input type="text" class="form-control" name="nama_belakang" id="nama_belakang" placeholder="Nama Belakang" value="<?php echo $log["nama_belakang"];?>"/>
          </div>
          <div class="form-group" style="margin-bottom: 8px;">
            <label>Jenis Kelamin</label>
            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" placeholder="Jenis Kelamin" value="<?php echo $log["jenis_kelamin"];?>">
              <option label="Pilih Jenis Kelamin"></option>
              <option value="L" <?php if($log['jenis_kelamin'] == 'L') { echo "selected"; } ?>>Laki-Laki</option>
              <option value="P" <?php if($log['jenis_kelamin'] == 'P') { echo "selected"; } ?>>Perempuan</option>
            </select>
          </div>
          <div class="form-group" style="margin-bottom: 8px;">
            <label>Tempat Lahir</label>
            <input type="text" class="form-control" name="tmp_lahir" id="tmp_lahir" placeholder="Tempat Lahir" value="<?php echo $log["tmp_lahir"];?>">
          </div>
          <div class="form-group" style="margin-bottom: 8px;">
            <label>Tanggal Lahir</label>
            <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir" value="<?php echo $log["tgl_lahir"];?>">
          </div>
          <div class="form-group" style="margin-bottom: 8px;">
            <label>No. Handphone</label>
            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Handphone" value="<?php echo $log["no_hp"];?>">
          </div>
          <div class="form-group" style="margin-bottom: 8px;">
            <label>Nama Kelas</label>
            <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Nama Kelas" value="<?php echo $log["kelas"];?>">
          </div>
        </div>
        <!-- /.box-body -->

        <div class="modal-footer">
          <input type="submit" name="edit_profile" id="edit_profile" class="btn btn-primary pull-right" value="Simpan">
        </div>
      </form>
    </div>
  </div>
</div>

<?php

if(isset($_POST['edit_profile']))
{  
    $data = array(
      ':nama_depan'   	=>  trim($_POST["nama_depan"]),
      ':nama_belakang'  =>  trim($_POST["nama_belakang"]),
      ':jenis_kelamin'  =>  trim($_POST["jenis_kelamin"]),
      ':tmp_lahir'      =>  trim($_POST["tmp_lahir"]),
      ':tgl_lahir'      =>  trim($_POST["tgl_lahir"]),
      ':no_hp'          =>  trim($_POST["no_hp"]),
      ':kelas'          =>  trim($_POST["kelas"]),
      ':user_id'        =>  $_SESSION["user_id"]
    );

	$query = '
	UPDATE user SET nama_depan = :nama_depan, nama_belakang = :nama_belakang, jenis_kelamin = :jenis_kelamin, tmp_lahir = :tmp_lahir, tgl_lahir = :tgl_lahir, no_hp = :no_hp, kelas = :kelas WHERE user_id = :user_id
	';
   
    $statement = $connect->prepare($query);
    if($statement->execute($data))
    {
      echo 'Berhasil di perbaharui';
    }  
}
?>

<div id="view_post_profilmodal" class="modal fade vn-modal-slide-left" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa fa-arrow-left" style="margin-left: 15px;"></i></span></button>
        <h4 class="modal-title" style="margin-left: 40px;"><b><?php echo $log['nama_depan']; ?></b> <small></small></h4>
      </div>
      <div class="modal-body" id="view_posting_profil_list" style="background: #eeebef;">

      </div>
    </div>
  </div>
</div>