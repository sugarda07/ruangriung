<?php
include ('koneksi.php');
session_start();

if(isset($_POST['proses']))
{
	$output = '';

	if($_POST['proses'] == 'insert_video')
	{
		$file_extension = strtolower(pathinfo($_FILES["fileupload_video"]["name"], PATHINFO_EXTENSION));

		$new_file_name = rand() . '.' . $file_extension;

		$source_path = $_FILES["fileupload_video"]["tmp_name"];

		$target_path = '../images/post/' .$new_file_name;

		move_uploaded_file($source_path, $target_path);


		$data = array(
			':user_id'				=>	$_SESSION["user_id"],
			':post_video'			=>	$new_file_name,
			':post_konten_video'	=>	$_POST["post_konten_video"],
			':post_tgl'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
		);
		$query_video = "
		INSERT INTO postingan 
		(user_id, post_konten, post_video, post_tgl) 
		VALUES (:user_id, :post_konten_video, :post_video, :post_tgl)
		";
		$statement = $connect->prepare($query_video);
		$statement->execute($data);

		$notification_query = "
		SELECT receiver_id FROM follow 
		WHERE sender_id = '".$_SESSION["user_id"]."'
		";
		$statement = $connect->prepare($notification_query);
		$statement->execute();
		$notification_result = $statement->fetchAll();
		foreach($notification_result as $notification_row)
		{
			$query_gambar2 = "
			SELECT post_id FROM postingan
			WHERE user_id = '".$_SESSION["user_id"]."'
			";
			$statement = $connect->prepare($query_gambar2);
			$statement->execute();
			$gambar2_result = $statement->fetchAll();
			foreach($gambar2_result as $gambar2_row)
			{

			}

			$post_id = Get_post_id($connect, $gambar2_row["post_id"]);
	        $notification_text= 'membuat postingan baru';
			$notif_sender_id = Get_user_id($connect, $_SESSION["user_id"]);
			$insert_query = "
			INSERT INTO pemberitahuan 
			(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification) 
			VALUES ('".$notification_row['receiver_id']."', '".$notif_sender_id."', '".$post_id."', '".$notification_text."', 'no')
			";
			$statement = $connect->prepare($insert_query);
			$statement->execute();
		}

		echo json_encode($statement);
	}


	if($_POST['proses'] == 'insert_postingan1')
	{
		$data = array(
			':user_id'			=>	$_SESSION["user_id"],
			':post_konten'		=>	$_POST["postingan1"],
			':post_tgl'	=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
		);
		$query = "
		INSERT INTO postingan 
		(user_id, post_konten,  post_tgl) 
		VALUES (:user_id, :post_konten, :post_tgl)
		";
		$statement = $connect->prepare($query);
		$statement->execute($data);

		$notification_query = "
		SELECT receiver_id FROM follow 
		WHERE sender_id = '".$_SESSION["user_id"]."'
		";
		$statement = $connect->prepare($notification_query);
		$statement->execute();
		$notification_result = $statement->fetchAll();
		foreach($notification_result as $notification_row)
		{
			$query_gambar2 = "
			SELECT post_id FROM postingan
			WHERE user_id = '".$_SESSION["user_id"]."'
			";
			$statement = $connect->prepare($query_gambar2);
			$statement->execute();
			$gambar2_result = $statement->fetchAll();
			foreach($gambar2_result as $gambar2_row)
			{

			}

			$post_id = Get_post_id($connect, $gambar2_row["post_id"]);
	        $notification_text= 'membuat postingan baru';
			$notif_sender_id = Get_user_id($connect, $_SESSION["user_id"]);
			$insert_query = "
			INSERT INTO pemberitahuan 
			(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification) 
			VALUES ('".$notification_row['receiver_id']."', '".$notif_sender_id."', '".$post_id."', '".$notification_text."', 'no')
			";
			$statement = $connect->prepare($insert_query);
			$statement->execute();
		}
	}


	if($_POST['proses'] == 'embed_video')
	{
		$data = array(
			':user_id'			=>	$_SESSION["user_id"],
			':post_konten'		=>	$_POST["post_konten_embed"],
			':post_embed'		=>	$_POST["post_embed_video"],
			':post_tgl'	=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
		);
		$query = "
		INSERT INTO postingan 
		(user_id, post_konten, post_embed, post_tgl) 
		VALUES (:user_id, :post_konten, :post_embed, :post_tgl)
		";
		$statement = $connect->prepare($query);
		$statement->execute($data);

		$notification_query = "
		SELECT receiver_id FROM follow 
		WHERE sender_id = '".$_SESSION["user_id"]."'
		";
		$statement = $connect->prepare($notification_query);
		$statement->execute();
		$notification_result = $statement->fetchAll();
		foreach($notification_result as $notification_row)
		{
			$query_gambar2 = "
			SELECT post_id FROM postingan
			WHERE user_id = '".$_SESSION["user_id"]."'
			";
			$statement = $connect->prepare($query_gambar2);
			$statement->execute();
			$gambar2_result = $statement->fetchAll();
			foreach($gambar2_result as $gambar2_row)
			{

			}

			$post_id = Get_post_id($connect, $gambar2_row["post_id"]);
	        $notification_text= 'membuat postingan baru';
			$notif_sender_id = Get_user_id($connect, $_SESSION["user_id"]);
			$insert_query = "
			INSERT INTO pemberitahuan 
			(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification) 
			VALUES ('".$notification_row['receiver_id']."', '".$notif_sender_id."', '".$post_id."', '".$notification_text."', 'no')
			";
			$statement = $connect->prepare($insert_query);
			$statement->execute();
		}
	}


	if($_POST['proses'] == 'postingan_post')
	{
		$query = "
		SELECT * FROM postingan 
		INNER JOIN user ON user.user_id = postingan.user_id 
		LEFT JOIN follow ON follow.sender_id = postingan.user_id 
		WHERE follow.receiver_id = '".$_SESSION["user_id"]."' OR postingan.user_id = '".$_SESSION["user_id"]."' 
		GROUP BY postingan.post_id 
		ORDER BY postingan.post_id DESC
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$total_row = $statement->rowCount();
		if($total_row > 0)
		{
			foreach($result as $row)
			{
				$profile_image = '';
				$post_gambar ='';
				$post_video ='';
				if($row['profile_image'] != '')
				{
					if($row['post_gambar'] !='')
					{				
						$post_gambar = '
						<div class="box-body" align="center" style="padding: unset;">
				          <a href="images/post/'.$row["post_gambar"].'" class="image-popup-vertical-fit" title="'.$row["post_konten"].'">
				          <img class="img-responsive pad" src="images/post/'.$row["post_gambar"].'" alt="Photo" style="padding: unset;">
				          </a>
				        </div>
				        <div class="box-body" style="padding-bottom: 0px;">
				          <p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
				        </div>
			        ';
					}
					else if($row['post_video'] !='')
					{
						$post_gambar = '
						<div class="box-body" align="center" style="padding: unset;">
				          <video class="img-responsive" controls src="images/post/'.$row["post_video"].'" type="video/mp4" style="padding: unset;"></video>
				        </div>
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}
					else if($row['post_embed'] !='')
					{
						$post_gambar = '
						<div class="box-body" align="center" style="padding: unset;">
							<div class="embed-responsive embed-responsive-16by9">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$row["post_embed"].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}
					else
					{						
						$post_gambar = '
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}

					$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
				    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
				    $user_last_activity = fetch_user_last_activity($row["user_id"], $connect);
				    if($user_last_activity > $current_timestamp)
				    {
				        $profile_image = '<a href="images/profile_image/'.$row["profile_image"].'" class="image-popup-no-margins" title="'.$row["nama_depan"].'">
				        <img class="img-circle img-bordered-sm" src="images/profile_image/'.$row["profile_image"].'" alt="User Image" style="width: 35px; height: 35px;"></a>';
				    }
				    else
				    {
				        $profile_image = '<a href="images/profile_image/'.$row["profile_image"].'" class="image-popup-no-margins" title="'.$row["nama_depan"].'">
				        <img class="img-circle" src="images/profile_image/'.$row["profile_image"].'" alt="User Image" style="width: 35px;height: 35px;"></a>';
				    }

					$profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
				}
				else
				{
					if($row['post_gambar'] !='')
					{				
						$post_gambar = '
						<div class="box-body" align="center" style="padding: unset;">
						<a href="images/post/'.$row["post_gambar"].'" class="image-popup-vertical-fit" title="'.$row["post_konten"].'">
				          <img class="img-responsive pad" src="images/post/'.$row["post_gambar"].'" alt="Photo" style="padding: unset;">
				          </a>
				        </div>
				        <div class="box-body" style="padding-bottom: 0px;">
				          <p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
				        </div>
			        ';
					}
					else if($row['post_video'] !='')
					{
						$post_gambar = '
						<div class="box-body" align="center" style="padding: unset;">
				          <video class="img-responsive pad" controls src="images/post/'.$row["post_video"].'" type="video/mp4" style="padding: unset;"></video>
				        </div>
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}
					else if($row['post_embed'] !='')
					{
						$post_gambar = '
						<div class="box-body" align="center" style="padding: unset;">
							<div class="embed-responsive embed-responsive-16by9">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$row["post_embed"].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}
					else
					{						
						$post_gambar = '
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}

					$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
				    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
				    $user_last_activity = fetch_user_last_activity($row["user_id"], $connect);
				    if($user_last_activity > $current_timestamp)
				    {
				        $profile_image = '<a href="images/profile_image/user.png" class="image-popup-no-margins" title="Belum Upload Foto">
				        <img class="img-circle img-bordered-sm" src="images/profile_image/user.png" alt="User Image" style="width: 35px; height: 35px;"></a>';
				    }
				    else
				    {
				        $profile_image = '<a href="images/profile_image/user.png" class="image-popup-no-margins" title="Belum Upload Foto">
				        <img class="img-circle" src="images/profile_image/user.png" alt="User Image" style="width: 35px;height: 35px;"></a>';
				    }
				    
					$profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
				}

				$like_button = '';
				if(!is_user_has_already_like_content($connect, $_SESSION["user_id"], $row["post_id"]))
			   	{
			    	$like_button = '
			    	<button type="button" class="btn btn-block btn-sm like_button" style="background-color: #ffffff;color: #444;border-color: #ffffff;" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart-o" style="font-size: 18px;"></i>  '.count_total_post_like($connect, $row["post_id"]).' Suka</button>
			    	';
			   	}
			   	else
			   	{
			   		$like_button = '
			   		<button type="button" class="btn btn-block btn-sm like_button" style="background-color: #ffffff;color: #444;border-color: #ffffff;" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart text-danger" style="font-size: 18px;"></i>  '.count_total_post_like($connect, $row["post_id"]).' Anda</button>
			   		';
			   	}

				$output .= '
				<div class="box box-widget" style="margin-bottom: 10px;">
			        <div class="box-header with-border">
			          <div class="user-block">
			            '.$profile_image.'
			            <span class="username"><a href="media/profil_cari.php?data='.$row["user_id"].'">'.$row["nama_depan"].'</a></span>
			            <span class="description">'.tgl_ago($row["post_tgl"]).'</span>
			          </div>
			          <!-- /.user-block -->
			          <div class="box-tools pull-right">
			            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			            </button>
			          </div>
			          <!-- /.box-tools -->
			        </div>
			        <!-- /.box-header -->
			        '.$post_gambar.'
			        <div class="box-body" style="padding-bottom: 5px;">
						<div class="row" style="border-top: 1px solid #f4f4f4">
				          <div class="col-xs-6 text-center" style="border-right: 1px solid #f4f4f4; padding-top: 3px;">
				          	'.$like_button.'
				          </div>
				          <div class="col-xs-6 text-center" style="padding-top: 3px;">
				          	<button type="button" class="btn btn-block btn-sm post_comment" style="background-color: #ffffff;color: #444;border-color: #ffffff;" id="'.$row["post_id"].'" data-user_id="'.$row["user_id"].'"><i class="fa fa-comment-o" style="font-size: 18px;"></i>  '.count_comment($connect, $row["post_id"]).' komentar</button>
				          </div>
				        </div>
					</div>
			        <!-- /.box-body -->
			        <div class="box-footer box-comments" id="comment_form'.$row["post_id"].'" style="display:none;">
			          <div class="box-comment" style="padding-bottom: 5px;" id="old_comment'.$row["post_id"].'">
			            
			          </div>
			          <!-- /.box-comment -->
			          	<form action="#" method="post">
			            '.$profile_image2.'
			            <!-- .img-push is used to add margin to elements next to floating images -->
			            <div class="img-push">
			            	<div class="input-group input-group-sm">
			              		<textarea class="form-control form-control-sm" data-emojiable="true" data-emoji-input="unicode" type="text" name="comment" id="comment'.$row["post_id"].'" rows="1" placeholder="Tuliskan komentar Anda..."></textarea>
			              		<span class="input-group-btn">
			                    	<button type="button" name="submit_comment" class="btn btn-primary btn-flat submit_comment">Komen</button>
			                  </span>
			              	</div>
			            </div>
			          </form>
			        </div>
			      </div>
				';
			}
		}
		else
		{
			$output = '
			<div class="box-body">
				<div class="callout callout-info">
                	<h4>Selamat Datang!</h4>
                	<p>Gunakan sosial media dengan Bijak</p>
              	</div>
             </div>';
		}
		echo $output; 
	}


	if($_POST["proses"] == 'submit_comment')
	{
		$data = array(
			':post_id'		=>	$_POST["post_id"],
			':user_id'		=>	$_SESSION["user_id"],
			':comment'		=>	$_POST["comment"],
			':timestamp'	=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
		);
		$query = "
		INSERT INTO komentar 
		(post_id, user_id, comment, timestamp) 
		VALUES (:post_id, :user_id, :comment, :timestamp)
		";
		$statement = $connect->prepare($query);
		$statement->execute($data);

		$notification_query = "
		SELECT user_id, post_konten FROM postingan 
		WHERE post_id = '".$_POST["post_id"]."'
		";

		$statement = $connect->prepare($notification_query);

		$statement->execute();

		$notification_result = $statement->fetchAll();

		foreach($notification_result as $notification_row)
		{
			$notification_text = 'mengomentari "'.strip_tags(substr($_POST["comment"], 0, 20)).'"';
			
			$insert_query = "
			INSERT INTO pemberitahuan 
			(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification) 
			VALUES ('".$notification_row['user_id']."', '".$_SESSION["user_id"]."', '".$_POST["post_id"]."', '".$notification_text."', 'no')
			";

			$statement = $connect->prepare($insert_query);
			$statement->execute();
		}
	}

	if($_POST["proses"] == "fetch_comment")
	{
		$query = "
		SELECT * FROM komentar 
		INNER JOIN user 
		ON user.user_id = komentar.user_id 
		WHERE post_id = '".$_POST["post_id"]."' 
		ORDER BY comment_id ASC
		";
		$statement = $connect->prepare($query);
		$output = '';
		if($statement->execute())
		{
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				$profile_image = '';
				if($row['profile_image'] != '')
				{
					$profile_image = '<img class="img-circle img-sm" src="images/profile_image/'.$row["profile_image"].'" alt="User Image">';
				}
				else
				{
					$profile_image = '<img class="img-circle img-sm" src="images/profile_image/user.png" alt="User Image">';
				}
				$output .= '
				'.$profile_image.'	
	              <div class="comment-text" style="padding-bottom: 0px;margin-top: 0px;margin-bottom: 2px;">
	                <span class="username">
	                  '.$row["nama_depan"].'
	                  <span class="text-muted pull-right">'.tgl_ago($row["timestamp"]).'</span>
	                </span>
	                '.$row["comment"].'
	              </div>
				';
			}
		}
		echo $output;
	}


	if($_POST['proses'] == 'saran_teman')
	{
		$query = "
		SELECT * FROM user 
		WHERE user_id != '".$_SESSION["user_id"]."' 
		ORDER BY RAND() 
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$profile_image = '';
			if($row['profile_image'] != '')
			{
				$profile_image = '<img class="img-circle" src="images/profile_image/'.$row["profile_image"].'" alt="User Image">';
			}
			else
			{
				$profile_image = '<img class="img-circle" src="images/profile_image/user.png" alt="User Image">';
			}
			$output .= '
			<div class="box-header with-border">
				<div class="row">
					<div class="col-xs-9">
						<div class="user-block">
							'.$profile_image.'
							<span class="username"><a href="media/profil_cari.php?data='.$row["user_id"].'">'.$row["nama_depan"].'</a></span>
				            <span class="description">'.$row["follower_number"].' Pengikut</span>
				        </div>
				    </div>
				    <div class="col-xs-3 text-center" style="vertical-align: middle;padding-bottom: 10px;padding-top: 10px;">
				    	'.make_follow_button($connect, $row["user_id"], $_SESSION["user_id"]).'
				    </div>
			    </div>
		    </div>
			';
		}
		echo $output;
	}


	if($_POST['proses'] == 'load_notif')
	{
		$query = "
		SELECT * FROM pemberitahuan 
		JOIN user ON user.user_id = pemberitahuan.notif_sender_id
		WHERE notification_receiver_id = '".$_SESSION['user_id']."' 
		ORDER BY notification_id DESC
		";
		$statement = $connect->prepare($query);

		$statement->execute(); 

		$result = $statement->fetchAll();

		$total_row = $statement->rowCount();

		$output = '';

		if($total_row > 0)
		  {
		    foreach($result as $row)
		    {
			    $profile_image = '';
			    if($row['profile_image'] != '')
			    {
			        $profile_image = '<img class="contacts-list-img" src="images/profile_image/'.$row["profile_image"].'" alt="User Image">';
			    }
			    else
			    {
			        $profile_image = '<img class="contacts-list-img" src="images/profile_image/user.png" alt="User Image">';
			    }
			    if($row['user_id'] != $_SESSION["user_id"])
			    {
			    	$tombol = make_follow_button($connect, $row["user_id"], $_SESSION["user_id"]);
			    	$nama = $row["nama_depan"];
			    }
			    else
			    {
			    	$tombol ='';
			    	$nama = 'Anda';
			    }
			    $output .= '
			    <li>
			    	<a href="media/view_posting.php?data='.$row["notif_post_id"].'">
			          '.$profile_image.'
			          <div class="contacts-list-info">
			                <span class="contacts-list-name" style="color: #230069;">
			                  '.$nama.'
			                  <small class="contacts-list-date pull-right" style="color: #687b8e;">'.tgl_ago($row["notif_time"]).'</small>
			                </span>
			            <span class="contacts-list-msg" style="color: #818c97;">'.$row["notification_text"].'
			            <small class="contacts-list-date pull-right" style="color: #42ef0a;"><span>'.$tombol.'</span></small>
			            </span>
			          </div>
			          <!-- /.contacts-list-info -->
			        </a>
			      </li>
			    ';
		    }
		}
		echo $output;
	}



	if($_POST['proses'] == 'load_total_notif')
	{
		$query = "
		  SELECT COUNT(notification_id) as total 
		  FROM pemberitahuan 
		  WHERE notification_receiver_id = '".$_SESSION["user_id"]."' 
		  AND read_notification = 'no'
		  ";

		  $statement = $connect->prepare($query);

		  $statement->execute();

		  $result = $statement->fetchAll();
		  $output ='';

		  foreach($result as $row)
		  {
		    if($row["total"] > 0)
		    {
		      $output = '
		      <i class="fa fa-heart-o" style="font-size: 20px;"></i>
		      <span class="label label-danger" style="position: absolute;top: 9px;font-size: 8px;padding: 2px 3px;margin-left: -7px;">'.$row["total"].'</span>';
		    }
		    else
		    {
		      $output = '
		      <i class="fa fa-heart-o" style="font-size: 20px;"></i>
		      <span class="label label-danger" style="position: absolute;top: 9px;font-size: 8px;padding: 2px 3px;margin-left: -7px;"></span>';
		    }
		    echo $output;
		  }
	}


	if($_POST['proses'] == 'total_notif_chat')
	{
		$query = "
		  SELECT COUNT(chat_message_id) as total_chat
		  FROM 	chat_message 
		  WHERE from_user_id = from_user_id
		  AND to_user_id = '".$_SESSION["user_id"]."'
		  AND status = '1'
		  ";

		  $statement = $connect->prepare($query);

		  $statement->execute();

		  $result = $statement->fetchAll();
		  $output ='';

		  foreach($result as $row)
		  {
		    if($row["total_chat"] > 0)
		    {
		      $output = '
		      <i class="fa fa-comments-o"></i>
                <span class="label label-success">'.$row["total_chat"].'</span>
				';
		    }
		    else
		    {
		      $output = '
		      <i class="fa fa-comments-o"></i>
                <span class="label label-success"></span>';
		    }
		    echo $output;
		  }
	}


	if($_POST['proses'] == 'load_notif_chat')
	{
		 $output='';
		 $query = "
		    SELECT * FROM user
		    WHERE user_id != '".$_SESSION["user_id"]."'
		    LIMIT 8
		    ";
		    $statement = $connect->prepare($query);
		    $statement->execute();
		    $result = $statement->fetchAll();
		    $total_rows= $statement->rowCount();
		 if($total_rows > 0)
		 {
		  foreach($result as $row)
		    {
		      $profile_image = '';
		      if($row['profile_image'] != '')
		      {
		        $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
		        $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
		        $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
		        if($user_last_activity > $current_timestamp)
		        {
		          $profile_image = '<img class="contacts-list-img img-bordered-sm" src="images/profile_image/'.$row["profile_image"].'" alt="User Image">';
		        }
		        else
		        {
		          $profile_image = '<img class="contacts-list-img" src="images/profile_image/'.$row['profile_image'].'" alt="User Image">';
		        }        
		      }
		      else
		      {
		        $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
		        $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
		        $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
		        if($user_last_activity > $current_timestamp)
		        {
		          $profile_image = '<img class="contacts-list-img img-bordered-sm" src="images/profile_image/user.png" alt="User Image">';
		        }
		        else
		        {
		          $profile_image = '<img class="contacts-list-img" src="images/profile_image/user.png" alt="User Image">';
		        }
		      }
		 
		      $sub_query = "
		      SELECT * FROM chat_message
		      WHERE (from_user_id = '".$_SESSION["user_id"]."' 
		      AND to_user_id = '".$row['user_id']."') 
		      OR (from_user_id = '".$row['user_id']."' 
		      AND to_user_id = '".$_SESSION["user_id"]."') 
		      ORDER BY timestamp DESC
		      LIMIT 1
		      ";
		      $statement = $connect->prepare($sub_query);
		      $statement->execute();
		      $result_chat = $statement->fetchAll();
		      foreach($result_chat as $data)
		      {
		        if($data["from_user_id"] == $row['user_id'] )
		        { 
		          $status_pesan = '';
		          if($data["status"] == '0')
		          {          
		            $status_pesan = ''.strip_tags(substr($data['chat_konten'], 0, 12)).'';
		          }
		          if($data["status"] == '1')
		          {          
		            $status_pesan = ''.strip_tags(substr($data['chat_konten'], 0, 12)).'';
		          }
		          if($data["status"] == '2')
		          {          
		            $status_pesan = '<small><span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em></small>';
		          }    
		        }
		        else
		        {
		          $status_pesan = '';
		          if($data["status"] == '0')
		          {          
		            $status_pesan = '<small><span class="fa fa-check-square-o text-primary"></span></small> '.strip_tags(substr($data['chat_konten'], 0, 12)).'';
		          }
		          if($data["status"] == '1')
		          {          
		            $status_pesan = '<small><span class="fa fa-check"></span></small> '.strip_tags(substr($data['chat_konten'], 0, 12)).'';
		          }
		          if($data["status"] == '2')
		          {          
		            $status_pesan = '<small><span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em></small>';
		          }
		        }

		      $output .= '

                  <ul class="menu">
                    <li>
                      <a href="pesan/chat.php">
                        <div class="pull-left">
                          '.$profile_image.'
                        </div>
                        <h4>
                          '.$row["nama_depan"].'
                          <small><i class="fa fa-clock-o"></i> '.tgl_ago2($data["timestamp"]).'</small>
                        </h4>
                        <p>'.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.$status_pesan.' '.fetch_is_type_status($row['user_id'], $connect).'</p>
                      </a>
                    </li>
                  </ul>
		      ';    
		    }
		  }
		    echo $output;
		 }
		 else
		 {
		  $output = 'Nobody has share nothing';
		 }
	}



	if($_POST["proses"] == "like")
	{
		$query = "
		SELECT * FROM like_post 
		WHERE post_id = '".$_POST["post_id"]."' 
		AND user_id = '".$_SESSION["user_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();

		$total_row = $statement->rowCount();

		if($total_row > 0)
		{
			$insert_query = "
			DELETE FROM like_post 
			WHERE user_id=".$_SESSION["user_id"]." AND post_id=".$_POST["post_id"]."
			";

			$statement = $connect->prepare($insert_query);

			$statement->execute();

			echo 'Unlike';
		}
		else
		{
			$insert_query = "
			INSERT INTO like_post 
			(user_id, post_id) 
			VALUES ('".$_SESSION["user_id"]."', '".$_POST["post_id"]."')
			";

			$statement = $connect->prepare($insert_query);

			$statement->execute();

			$notification_query = "
			SELECT user_id, post_konten FROM postingan 
			WHERE post_id = '".$_POST["post_id"]."'
			";

			$statement = $connect->prepare($notification_query);

			$statement->execute();

			$notification_result = $statement->fetchAll();

			foreach($notification_result as $notification_row)
			{
				$notification_text = 'menyukai "'.strip_tags(substr($notification_row["post_konten"], 0, 20)).'"';

				$insert_query = "
				INSERT INTO pemberitahuan 
					(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification) 
					VALUES ('".$notification_row['user_id']."', '".$_SESSION["user_id"]."', '".$_POST["post_id"]."', '".$notification_text."', 'no')
				";

				$statement = $connect->prepare($insert_query);
				$statement->execute();
			}

			echo 'Like';
		}
	}


	if($_POST['proses'] == 'follow')
	{
		$query = "
		INSERT INTO follow 
		(sender_id, receiver_id) 
		VALUES ('".$_POST["sender_id"]."', '".$_SESSION["user_id"]."')
		";
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			$sub_query = "
			UPDATE user SET follower_number = follower_number + 1 WHERE user_id = '".$_POST["sender_id"]."'
			";
			$statement = $connect->prepare($sub_query);
			$statement->execute();	

			$sub_query2 = "
			UPDATE user SET following_number = following_number + 1 WHERE user_id = '".$_SESSION["user_id"]."'
			";
			$statement = $connect->prepare($sub_query2);
			$statement->execute();

			$notification_text = 'mulai mengikuti Anda.';
			$insert_query = "
			INSERT INTO pemberitahuan 
			(notification_receiver_id, notif_sender_id, notification_text, read_notification) 
			VALUES ('".$_POST["sender_id"]."', '".$_SESSION["user_id"]."', '".$notification_text."', 'no')
			";

			$statement = $connect->prepare($insert_query);
			$statement->execute();		
		}
	}

	if($_POST['proses'] == 'unfollow')
	{
		$query = "
		DELETE FROM follow 
		WHERE sender_id = '".$_POST["sender_id"]."' 
		AND receiver_id = '".$_SESSION["user_id"]."'
		";
		$statement = $connect->prepare($query);
		if($statement->execute())
		{
			$sub_query = "
			UPDATE user 
			SET follower_number = follower_number - 1 
			WHERE user_id = '".$_POST["sender_id"]."'
			";
			$statement = $connect->prepare($sub_query);
			$statement->execute();

			$sub_query2 = "
			UPDATE user SET following_number = following_number - 1 WHERE user_id = '".$_SESSION["user_id"]."'
			";
			$statement = $connect->prepare($sub_query2);
			$statement->execute();

			$notification_text = 'telah meninggalkanmu...';
			$insert_query = "
			INSERT INTO pemberitahuan 
			(notification_receiver_id, notif_sender_id, notification_text, read_notification) 
			VALUES ('".$_POST["sender_id"]."', '".$_SESSION["user_id"]."', '".$notification_text."', 'no')
			";
			$statement = $connect->prepare($insert_query);

			$statement->execute();
		}
	}


	if($_POST['proses'] == 'pengikut')
	{
		$user_id = Get_user_id($connect, $_SESSION["user_id"]);
        $query = "
        SELECT * FROM user 
        INNER JOIN follow 
        ON follow.receiver_id = user.user_id 
        WHERE follow.sender_id = '".$user_id."'
        ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
          $profile_image = '';
          if($row['profile_image'] != '')
          {
            $profile_image = '<img class="img-circle" src="images/profile_image/'.$row["profile_image"].'" alt="User Image">';
          }
          else
          {
            $profile_image = '<img class="img-circle" src="images/profile_image/user.png" alt="User Image">';
          }
          $output .= '
          <div class="box-header" >
          <div class="row">
            <div class="col-xs-9">
              <div class="user-block">
                '.$profile_image.'
                <span class="username"><a href="media/profil_cari.php?data='.$row["user_id"].'">'.$row["nama_depan"].'</a></span>
                      <span class="description">'.$row["follower_number"].' Pengikut</span>
                  </div>
              </div>
              <div class="col-xs-3 text-center">
                '.make_follow_button($connect, $row["user_id"], $_SESSION["user_id"]).'
              </div>
            </div>
            </div>
          ';
        }
        echo $output;
	}


	if($_POST['proses'] == 'mengikuti')
	{
		$user_id = Get_user_id($connect, $_SESSION["user_id"]);
        $query = "
        SELECT * FROM user 
        INNER JOIN follow 
        ON follow.sender_id = user.user_id 
        WHERE follow.receiver_id = '".$user_id."'
        ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
          $profile_image = '';
          if($row['profile_image'] != '')
          {
            $profile_image = '<img class="img-circle" src="images/profile_image/'.$row["profile_image"].'" alt="User Image">';
          }
          else
          {
            $profile_image = '<img class="img-circle" src="images/profile_image/user.png" alt="User Image">';
          }
          $output .= '
          <div class="box-header" >
          <div class="row">
            <div class="col-xs-9">
              <div class="user-block">
                '.$profile_image.'
                <span class="username"><a href="media/profil_cari.php?data='.$row["user_id"].'">'.$row["nama_depan"].'</a></span>
                      <span class="description">'.$row["follower_number"].' Pengikut</span>
                  </div>
              </div>
              <div class="col-xs-3 text-center">
                '.make_follow_button($connect, $row["user_id"], $_SESSION["user_id"]).'
              </div>
            </div>
            </div>
          ';
        }
        echo $output;
	}


	if($_POST['proses'] == 'view_posting_profil')
	{
		$query = "
		SELECT * FROM postingan
        JOIN user ON postingan.post_id = '".$_POST["post_id"]."'
          WHERE postingan.user_id = user.user_id
          ORDER BY postingan.post_id DESC
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$total_row = $statement->rowCount();
		if($total_row > 0)
		{
			foreach($result as $row)
			{
				$profile_image = '';
				$post_gambar ='';
				$post_video ='';
				if($row['profile_image'] != '')
				{
					if($row['post_gambar'] !='')
					{				
						$post_gambar = '
						<div class="box-body popup-gallery" style="padding: unset;">
				          <a href="images/post/'.$row["post_gambar"].'" class="image-popup-vertical-fit" title="'.$row["post_konten"].'">
				          <img class="img-responsive pad" src="images/post/'.$row["post_gambar"].'" alt="Photo" style="padding: unset;">
				          </a>
				        </div>
				        <div class="box-body" style="padding-bottom: 0px;">
				          <p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
				        </div>
			        ';
					}
					else if($row['post_video'] !='')
					{
						$post_gambar = '<video class="img-responsive pad" controls src="images/post/'.$row["post_video"].'" type="video/mp4"></video>
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}
					else
					{						
						$post_gambar = '
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}
					
					$profile_image = '
					<a href="images/profile_image/'.$row["profile_image"].'" class="image-popup-no-margins" title="'.$row["nama_depan"].'">
					<img class="img-circle" src="images/profile_image/'.$row["profile_image"].'" alt="User Image"></a>
					';

					$profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
				}
				else
				{
					if($row['post_gambar'] !='')
					{				
						$post_gambar = '
						<div class="box-body popup-gallery" style="padding: unset;">
						<a href="images/post/'.$row["post_gambar"].'" class="image-popup-vertical-fit" title="'.$row["post_konten"].'">
				          <img class="img-responsive pad" src="images/post/'.$row["post_gambar"].'" alt="Photo" style="padding: unset;">
				          </a>
				        </div>
				        <div class="box-body" style="padding-bottom: 0px;">
				          <p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
				        </div>
			        ';
					}
					else if($row['post_video'] !='')
					{
						$post_gambar = '<video class="img-responsive pad" controls src="images/post/'.$row["post_video"].'" type="video/mp4"></video>
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}
					else
					{						
						$post_gambar = '
						<div class="box-body" style="padding-bottom: 0px;">
							<p style="margin-bottom: 0px;">'.$row["post_konten"].'</p>
						</div>
						';
					}
					$profile_image = '
					<a href="#" class="image-popup-no-margins" title="Belum Upload Foto">
					<img class="img-circle" src="images/profile_image/user.png" alt="User Image"></a>
					';
					$profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
				}

				$like_button = '';
				if(!is_user_has_already_like_content($connect, $_SESSION["user_id"], $row["post_id"]))
			   	{
			    	$like_button = '
			    	<button type="button" class="btn btn-block btn-sm like_button" style="background-color: #ffffff;color: #444;border-color: #ffffff;" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart-o" style="font-size: 18px;"></i>  '.count_total_post_like($connect, $row["post_id"]).' Suka</button>
			    	';
			   	}
			   	else
			   	{
			   		$like_button = '
			   		<button type="button" class="btn btn-block btn-sm like_button" style="background-color: #ffffff;color: #444;border-color: #ffffff;" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart text-danger" style="font-size: 18px;"></i>  '.count_total_post_like($connect, $row["post_id"]).' Anda</button>
			   		';
			   	}

				$output .= '
				<div class="box box-widget" style="margin-bottom: 10px;">
			        <div class="box-header with-border">
			          <div class="user-block">
			            '.$profile_image.'
			            <span class="username"><a href="media/profil_cari.php?data='.$row["user_id"].'">'.$row["nama_depan"].'</a></span>
			            <span class="description">'.tgl_ago($row["post_tgl"]).'</span>
			          </div>
			          <!-- /.user-block -->
			          <div class="box-tools pull-right">
			            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			            </button>
			          </div>
			          <!-- /.box-tools -->
			        </div>
			        <!-- /.box-header -->
			        '.$post_gambar.'
			        <div class="box-body" style="padding-bottom: 5px;">
						<div class="row" style="border-top: 1px solid #f4f4f4">
				          <div class="col-xs-6 text-center" style="border-right: 1px solid #f4f4f4; padding-top: 3px;">
				          	'.$like_button.'
				          </div>
				          <div class="col-xs-6 text-center" style="padding-top: 3px;">
				          	<button type="button" class="btn btn-block btn-sm post_comment" style="background-color: #ffffff;color: #444;border-color: #ffffff;" id="'.$row["post_id"].'" data-user_id="'.$row["user_id"].'"><i class="fa fa-comment-o" style="font-size: 18px;"></i>  '.count_comment($connect, $row["post_id"]).' komentar</button>
				          </div>
				        </div>
					</div>
			        <!-- /.box-body -->
			        <div class="box-footer box-comments" id="comment_form'.$row["post_id"].'" style="display:none;">
			          <div class="box-comment" style="padding-bottom: 5px;" id="old_comment'.$row["post_id"].'">
			            
			          </div>
			          <!-- /.box-comment -->
			          	<form action="#" method="post">
			            '.$profile_image2.'
			            <!-- .img-push is used to add margin to elements next to floating images -->
			            <div class="img-push">
			            	<div class="input-group input-group-sm">
			              		<textarea class="form-control form-control-sm" data-emojiable="true" data-emoji-input="unicode" type="text" name="comment" id="comment'.$row["post_id"].'" rows="1" placeholder="Tuliskan komentar Anda..."></textarea>
			              		<span class="input-group-btn">
			                    	<button type="button" name="submit_comment" class="btn btn-primary btn-flat submit_comment">Komen</button>
			                  </span>
			              	</div>
			            </div>
			          </form>
			        </div>
			      </div>
				';
			}
		}
		else
		{
			$output = '';
		}
		echo $output; 
	}


	if($_POST["proses"] == "update_notification_status")
	{
		$query = "
		UPDATE pemberitahuan 
		SET read_notification = 'yes' 
		WHERE notification_receiver_id = '".$_SESSION["user_id"]."'
		";

		$statement = $connect->prepare($query);

		$statement->execute();
	}

	if($_POST["proses"] == "hapus_postingan")
	{
		$image = get_image_post($connect, $_POST["post_id"]);
		if($image != '')
		{
			unlink("images/post/".$image);
		}
		$statement = $connect->prepare(
			"DELETE FROM postingan WHERE post_id = :post_id"
		);
		$result = $statement->execute(
			array(
				':post_id'	=>	$_POST["post_id"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Data telah dihapus';
		}
	}




}


?>