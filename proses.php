<?php
include ('koneksi.php');
include ('function.php');
session_start();

if(isset($_POST['proses']))
{
	$output = '';
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
				$konten_konten = $row["post_konten"];
				$string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
				$string = convertToLink($string); 
				if($row['profile_image'] != 'user.png')
				{
					if($row['post_gambar'] !='')
					{				
						$post_gambar = '
                        <div class="col-md-5 col-xs-12">
			              <a href="view_posting.php?data='.$row['post_id'].'">
			                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
			              </a>
			            </div>
			            <div class="col-md-7 col-xs-12">
			            	<p style="margin-bottom: 5px;"> 
			            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
			            	</p>
			            </div>
			        	';
					}
					else if($row['post_video'] !='')
					{
						$post_gambar = '
						<div class="col-md-5 col-xs-12">
							<video width="100%" height="100%" poster="" controls autoplay;>
						  		<source src="data/posting/video/'.$row["post_video"].'" type="video/mp4">
								Your browser does not support the video tag.
							</video>
						</div>
						<div class="col-md-7 col-xs-12">
			            	<p style="margin-bottom: 5px; color: black;"> 
			            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
			            	</p>
			            </div>
						';
					}
					else
					{						
						$post_gambar = '
						<div class="col-md-7 col-xs-12">
			            	<p style="margin-bottom: 5px; color: black;"> 
			            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
			            	</p>
			            </div>
						';
					}

					$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
				    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
				    $user_last_activity = fetch_user_last_activity($row["user_id"], $connect);
				    if($user_last_activity > $current_timestamp)
				    {
				        $profile_image = '
				        <img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle" />
				        <span class="profile-status online pull-right"></span>';
				    }
				    else
				    {
				        $profile_image = '
				        <img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle" />';
				    }

					$profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
				}
				else
				{
					if($row['post_gambar'] !='')
					{				
						$post_gambar = '
						<div class="col-md-5 col-xs-12">
			              <a href="view_posting.php?data='.$row['post_id'].'">
			                <img src="data/posting/images/'.$row["post_gambar"].'" alt="image" class="img-responsive radius" />
			              </a>
			            </div>
			            <div class="col-md-7 col-xs-12">
			            	<p style="margin-bottom: 5px; color: black;"> 
			            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
			            	</p>
			            </div>                      
			        ';
					}
					else if($row['post_video'] !='')
					{
						$post_gambar = '>
						<div class="col-md-5 col-xs-12">
							<video width="100%" height="100%" poster="" controls autoplay;>
						  		<source src="data/posting/video/'.$row["post_video"].'" type="video/mp4">
								Your browser does not support the video tag.
							</video>
						</div>
						<div class="col-md-7 col-xs-12">
			            	<p style="margin-bottom: 5px; color: black;"> 
			            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,160).'</a>
			            	</p>
			            </div>
						';
					}
					else
					{						
						$post_gambar = '
						<div class="col-md-7 col-xs-12">
			            	<p style="margin-bottom: 5px; color: black;"> 
			            		<a href="view_posting.php?data='.$row['post_id'].'" style=" color: black;">'.substr($string, 0,255).'</a>
			            	</p>
			            </div>
						';
					}

					$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
				    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
				    $user_last_activity = fetch_user_last_activity($row["user_id"], $connect);
				    if($user_last_activity > $current_timestamp)
				    {
				        $profile_image = '
				        <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>
				        <span class="profile-status online pull-right"></span>';
				    }
				    else
				    {
				        $profile_image = '
				        <span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
				    }
				    
					$profile_image2 = Get_profile_komen($connect, $_SESSION["user_id"]);
				}

				$like_button = '';
				if(!is_user_has_already_like_content($connect, $_SESSION["user_id"], $row["post_id"]))
			   	{
			    	$like_button = '
			    	<button type="button" class="btn btn-secondary like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart-o" style="font-size: 15px;"></i> '.count_total_post_like($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
			    	';
			   	}
			   	else
			   	{
			   		$like_button = '
			   		<button type="button" class="btn btn-secondary like_button" data-post_id="'.$row["post_id"].'"><i class="fa fa-heart text-danger" style="font-size: 15px;"></i> '.count_total_post_like($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
			   		';
			   	}

				$output .= '
                        <div class="sl-item">
                            <div class="sl-left"> '.$profile_image.' </div>
                            <div class="sl-right">
                                <div> <a href="view_posting.php?data='.$row['post_id'].'" class="link">'.$row["nama_depan"].'</a>
                                	<p style="margin-bottom: 5px;"><span class="sl-date">'.tgl_ago($row["post_tgl"]).'</span></p>
                                    <div class="m-t-20 row" style="margin-top: 5px;">
                                    	'.$post_gambar.'
                                    </div>
                                    <div class="like-comm m-t-20" style="margin-top: 5px;">
                                    	'.$like_button.'
                                    	<button type="button" class="btn btn-secondary post_comment" id="'.$row["post_id"].'" data-user_id="'.$row["user_id"].'"> <i class="ti-comments" style="font-size: 15px;"></i> '.count_comment($connect, $row["post_id"]).'</button>&nbsp;&nbsp;
                                    	<button type="button" class="btn btn-secondary"> <i class="fa fa-retweet" style="font-size: 15px;"></i> </button>
                                    	<!-- /.<p><span class="sl-date">suka</span></p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
<div id="comment_form'.$row["post_id"].'" class="modal" role="dialog">
    <div class="modal-dialog modal-lg" style="margin:0px; position: absolute; top: 0; bottom: 0; right: 0; width: 100%; height: 100%; margin: 0;
    opacity: 1; box-shadow: 7px 0 16px 15px rgba(0, 0, 0, 0.6);">
        <div class="modal-content" style="position: relative; height: 100%; border-radius: 0; border: 0; background-clip: initial;">
            <div class="modal-header" style="padding-bottom: 5px;">
                <h4 class="modal-title"><a href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-arrow-left"></i></a></h4>
                <h4 class="modal-title" style="padding-left: 25px; line-height: 1;">'.$row["nama_depan"].' <small class="m-b-10 text-muted">'.count_comment($connect, $row["post_id"]).' komentar</small> <p style="margin-bottom: 0px;"><small class="m-b-10 text-muted">'.strip_tags(substr($row["post_konten"], 0, 40)).'</small></p></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> </button>
            </div>
            
            <div class="modal-body" style="position: relative; padding: 0px; overflow-y: scroll; height: 100%; background-color: aliceblue;">
            	<div class="comment-widgets" id="old_comment'.$row["post_id"].'" style="margin-bottom: 100px;">

                </div>
            </div>
            <form action="javascript:void(0)" method="post">
                <div class="modal-footer" style="bottom: 0; left: 0; position: fixed; right: 0; z-index: 1032; background-color: #ffffff; text-align: left;">
                    <textarea class="form-control" type="text" name="comment" id="comment'.$row["post_id"].'" rows="2" placeholder="Tulis komentarmu ..."  style="border-radius: 9px;"></textarea>
                    <button type="submit" name="submit_comment" class="btn btn-info waves-effect waves-light submit_comment"><i class="mdi mdi-send"> </i></button>
                </div>
            </form>
        </div>
    </div>
</div>
                    <hr>
				';
			}
		}
		else
		{
			$output = '
            <div class="sl-item">
                <div class="sl-left"> <img src="data/akun/profil/rdigital.png" alt="user" class="img-circle"> </div>
                <div class="sl-right">
                    <div><a href="javascript:void(0)" class="link">Selamat Datang di RuangDIGITAL</a> <span class="sl-date"></span>
                        <p class="m-t-10" style="margin-top: 0px; margin-bottom: 0px;"> Gunakan sosial media dengan Bijak </p>
                    </div>
                </div>
            </div>';
		}
		echo $output; 
	}

	if($_POST['proses'] == 'insert')
	{
		if($_FILES['uploadFile']['name'] != '')
		{
			$file_extension = strtolower(pathinfo($_FILES["uploadFile"]["name"], PATHINFO_EXTENSION));

			$new_file_name = rand() . '.' . $file_extension;

			$source_path = $_FILES["uploadFile"]["tmp_name"];
			$ukuran_file = $_FILES["uploadFile"]["size"];

			if($file_extension == 'jpg' || $file_extension == 'png')
			{
				$target_path = 'data/posting/images/' .$new_file_name;
			}
			if($file_extension == 'mp4')
			{
				$target_path = 'data/posting/video/' .$new_file_name;
			}
			
			move_uploaded_file($source_path, $target_path);
			$data_gambar = array(
				':user_id'			=>	$_SESSION["user_id"],
				':post_konten'		=>	nl2br($_POST["posting_konten"]),
				':post_gambar'		=>	$new_file_name,
				':post_tgl'			=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
			);
			$query_gambar = "
			INSERT INTO postingan 
			(user_id, post_konten, post_gambar, post_tgl) 
			VALUES (:user_id, :post_konten, :post_gambar, :post_tgl)
			";

			$statement = $connect->prepare($query_gambar);
			$statement->execute($data_gambar);

			$notification_query = "
			SELECT receiver_id FROM follow 
			WHERE sender_id = '".$_SESSION["user_id"]."'
			";
			$statement = $connect->prepare($notification_query);
			$statement->execute();
			$notification_result = $statement->fetchAll();
			foreach($notification_result as $notification_row)
			{
				$query_posting = "
				SELECT post_id FROM postingan
				WHERE user_id = '".$_SESSION["user_id"]."'
				";
				$statement = $connect->prepare($query_posting);
				$statement->execute();
				$posting_result = $statement->fetchAll();
				foreach($posting_result as $posting_row)
				{

				}

				$post_id = Get_post_id($connect, $posting_row["post_id"]);
		        $notification_text= 'membuat postingan baru';
				$notif_sender_id = Get_user_id($connect, $_SESSION["user_id"]);

				$data = array(
					':notification_receiver_id'	=>	$notification_row['receiver_id'],
					':notif_sender_id'			=>	$notif_sender_id,
					':notif_post_id'			=>	$post_id,
					':notification_text'		=>	$notification_text,
					':read_notification'		=>	'no',
					':notif_time'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
					':notif_update'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
				);

				$insert_query = "
				INSERT INTO pemberitahuan 
					(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
					VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
				";
				$statement = $connect->prepare($insert_query);
				$statement->execute($data);
			}
		}
		else
		{
			$data = array(
				':user_id'			=>	$_SESSION["user_id"],
				':post_konten'		=>	nl2br($_POST["posting_konten"]),
				':post_tgl'			=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
			);
			$query = "
			INSERT INTO postingan 
			(user_id, post_konten, post_tgl) 
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
				$query_posting = "
				SELECT post_id FROM postingan
				WHERE user_id = '".$_SESSION["user_id"]."'
				";
				$statement = $connect->prepare($query_posting);
				$statement->execute();
				$posting_result = $statement->fetchAll();
				foreach($posting_result as $posting_row)
				{

				}

				$post_id = Get_post_id($connect, $posting_row["post_id"]);
		        $notification_text= 'Membuat postingan baru';
				$notif_sender_id = Get_user_id($connect, $_SESSION["user_id"]);
				$data = array(
					':notification_receiver_id'	=>	$notification_row['receiver_id'],
					':notif_sender_id'			=>	$notif_sender_id,
					':notif_post_id'			=>	$post_id,
					':notification_text'		=>	$notification_text,
					':read_notification'		=>	'no',
					':notif_time'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
					':notif_update'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
				);

				$insert_query = "
				INSERT INTO pemberitahuan 
					(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
					VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
				";
				$statement = $connect->prepare($insert_query);
				$statement->execute($data);
			}
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
				
					$notification_text = 'Menyukai ';
					$data = array(
						':notification_receiver_id'	=>	$notification_row['user_id'],
						':notif_sender_id'			=>	$_SESSION["user_id"],
						':notif_post_id'			=>	$_POST["post_id"],
						':notification_text'		=>	$notification_text,
						':read_notification'		=>	'no',
						':notif_time'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
						':notif_update'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
					);

					$insert_query = "
					INSERT INTO pemberitahuan 
						(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
						VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
					";
					$statement = $connect->prepare($insert_query);
					$statement->execute($data);
				
			}
		}
	}


	if($_POST["proses"] == 'submit_comment')
	{
		$data = array(
			':post_id'		=>	$_POST["post_id"],
			':user_id'		=>	$_SESSION["user_id"],
			':comment'		=>	strip_tags($_POST["comment"]),
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
			
				$notification_text = 'Mengomentari ';
				$data = array(
					':notification_receiver_id'	=>	$notification_row['user_id'],
					':notif_sender_id'			=>	$_SESSION["user_id"],
					':notif_post_id'			=>	$_POST["post_id"],
					':notification_text'		=>	$notification_text,
					':read_notification'		=>	'no',
					':notif_time'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
					':notif_update'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
				);

				$insert_query = "
				INSERT INTO pemberitahuan 
					(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
					VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
				";
				$statement = $connect->prepare($insert_query);
				$statement->execute($data);
			
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
				$konten_konten = $row["comment"];
		        $string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
		        $string = convertToLink($string);
				$profile_image = '';
				if($row['profile_image'] != 'user.png')
				{
					$profile_image = '<img src="data/akun/profil/'.$row["profile_image"].'" alt="user" width="50">';
				}
				else
				{
					$profile_image = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
				}
				$output .= '

				    <div class="d-flex no-block comment-row border-top" style="padding-top: 5px; padding-bottom: 0px;">
                        <div class="p-2"><span class="round">'.$profile_image.'</span></div>
                        <div class="comment-text active w-100" style="padding-left: 15px; padding-bottom: 8px; line-height: 1;">
                            <h5 class="font-medium" style="margin-bottom: 0px;">'.$string.'</h5>
                            <p class="m-b-10 text-muted" style="margin-bottom: 2px;">'.$row["nama_depan"].'</p>
                            <div class="comment-footer">
                                <span class="text-muted pull-right"><small>'.tgl_ago($row["timestamp"]).'</small></span>
                            </div>
                        </div>
                    </div>
				';
			}
		}
		echo $output;
	}


	if($_POST["proses"] == "post_all_gallery")
	{
		$query = "
        SELECT * FROM postingan
        JOIN user ON postingan.user_id = user.user_id
          WHERE postingan.user_id != '".$_SESSION["user_id"]."'
          ORDER BY postingan.post_id DESC
          LIMIT ".$_POST["start"].", ".$_POST["limit"]."
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
            <a class="image" href="view_posting.php?data='.$row['post_id'].'">
                <img class="img-responsive" alt="image" src="data/posting/images/'.$row['post_gambar'].'">
            </a>
            ';
            }               
        }
	}


	if($_POST['proses'] == 'load_notif')
	{
		$query = "
		SELECT * FROM pemberitahuan 
		INNER JOIN user ON user.user_id = pemberitahuan.notif_sender_id
		LEFT JOIN postingan ON post_id = pemberitahuan.notif_post_id
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
		    	$konten_konten = $row["post_konten"];
		        $string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
			    $profile_image = '';
			    if($row['profile_image'] != 'user.png')
			    {
			        $profile_image = '<img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle" style="width:40px; height:40px;">';
			    }
			    else
			    {
			        $profile_image = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
			    }
			    if($row['notif_post_id'] != '0')
			    {
			    	$link = 'view_posting.php?data='.$row["notif_post_id"].'';
			    }
			    else
			    {
			    	$link = 'javascript:void(0)';
			    }

			    if($row['user_id'] != $_SESSION["user_id"])
			    {
			    $output	.= '
			    	<a href="'.$link.'">
						<div class="user-img" style="margin-bottom: 0px;"> '.$profile_image.' </div>
						<div class="mail-contnet" style="width: 80%;">
							<h5>'.$row["nama_depan"].' <span class="time pull-right">'.make_follow_button_list($connect, $row["user_id"], $_SESSION["user_id"]).'</span></h5>
							<span class="mail-desc">
							'.$row["notification_text"].' '.$string.' <span class="time">'.tgl_ago($row["notif_time"]).'</span>
							</span>                 
						</div>
					</a>
			      ';
			    }
			    else
			    {
			    	$output	.= '
			    	<a href="'.$link.'">
						<div class="user-img" style="margin-bottom: 0px;"> '.$profile_image.' </div>
						<div class="mail-contnet" style="width: 80%;">
							<h5>'.$row["nama_depan"].' <span class="time pull-right"></span></h5>
							<span class="mail-desc">
							'.$row["notification_text"].' '.$string.' <span class="time">'.tgl_ago($row["notif_time"]).'</span>
							</span>                 
						</div>
					</a>
			      ';
			    }
		    }
		}
		echo $output;
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

			$notification_text 	= 'Mulai mengikuti Anda.';
			$data = array(
				':notification_receiver_id'	=>	$notification_row['user_id'],
				':notif_sender_id'			=>	$_SESSION["user_id"],
				':notif_post_id'			=>	$_POST["post_id"],
				':notification_text'		=>	$notification_text,
				':read_notification'		=>	'no',
				':notif_time'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa'))),
				':notif_update'				=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
			);

			$insert_query = "
			INSERT INTO pemberitahuan 
				(notification_receiver_id, notif_sender_id, notif_post_id, notification_text, read_notification, notif_time, notif_update) 
				VALUES (:notification_receiver_id, :notif_sender_id, :notif_post_id, :notification_text, :read_notification, :notif_time, :notif_update)
			";

			$statement = $connect->prepare($insert_query);
			$statement->execute($data);
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

		}
	}


	if($_POST['proses'] == 'list_chat')
	{
		$output='';
	 	$query = "
	    SELECT * FROM user
	    WHERE user_id != '".$_SESSION["user_id"]."'
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
	      		if($row['profile_image'] != 'user.png')
	      		{
	        		$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	        		$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	        		$user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
	        		if($user_last_activity > $current_timestamp)
	        		{
	          			$profile_image = '
	          			<img src="../data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span>';
	        		}
	        		else
	        		{
	          			$profile_image = '<img src="../data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle">';
	       			}        
	     		}
	      		else
	      		{
	        		$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	        		$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	        		$user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
	        		if($user_last_activity > $current_timestamp)
	        		{
	          			$profile_image = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span> <span class="profile-status online pull-right"></span>';
	        		}
	        		else
	        		{
	          			$profile_image = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
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
        			$chat_konten = $data["chat_konten"];
			        $string = strip_tags($chat_konten, "<a><b><i><u><em><strong>");
	        		if($data["from_user_id"] == $row['user_id'] )
	        		{ 
	          			$status_pesan = '';
	          			if($data["status"] == '0')
	          			{          
	            			$status_pesan = ''.substr($string, 0, 18).'';
	          			}
	          			if($data["status"] == '1')
	          			{          
	            			$status_pesan = ''.substr($string, 0, 18).'';
	          			}
	          			if($data["status"] == '2')
	          			{          
	            			$status_pesan = '<span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em>';
	          			}    
	        		}
	        		else
	        		{
	          			$status_pesan = '';
	          			if($data["status"] == '0')
	          			{          
	            			$status_pesan = '<span class="mdi mdi-check-all text-primary"></span> '.substr($string, 0, 18).'';
	          			}
	          			if($data["status"] == '1')
	          			{          
	            			$status_pesan = '<span class="mdi mdi-check"></span> '.substr($string, 0, 18).'';
	          			}
	          			if($data["status"] == '2')
	          			{          
	            			$status_pesan = '<span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em>';
	          			}
	        		}
	      			$output .= '

	      			<a href="javascript:void(0)" class="start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'" data-foto="../data/akun/profil/'.$row['profile_image'].'" style="padding-bottom: 3px; padding-top: 10px;">
                        <div class="user-img"> '.$profile_image.' </div>
                        <div class="mail-contnet" style="width: 81%;">
                            <h5>'.$row["nama_depan"].' <span class="time pull-right">'.tgl_ago2($data["timestamp"]).'</span></h5>
                            <span class="mail-desc">
                            	'.$status_pesan.'  '.fetch_is_type_status($row['user_id'], $connect).'  <span class="time pull-right">'.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).'</span>
                            </span>
                           
                        </div>
                    </a>
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




	if($_POST['proses'] == 'load_pemberitahuan')
	{
		$query = "
		SELECT * FROM pemberitahuan 
		INNER JOIN user ON user.user_id = pemberitahuan.notif_sender_id
		LEFT JOIN postingan ON post_id = pemberitahuan.notif_post_id
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
		    	$konten_konten = $row["post_konten"];
			    $string = strip_tags($konten_konten, "<br><br/><br /><a><b><i><u><em><strong>");
			    $profile_image = '';
			    if($row['profile_image'] != 'user.png')
			    {
			        $profile_image = '<img src="data/akun/profil/'.$row["profile_image"].'" alt="user" class="img-circle">';
			    }
			    else
			    {
			        $profile_image = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
			    }

			    if($row['notif_post_id'] != '0')
			    {
			    	$link = 'view_posting.php?data='.$row["notif_post_id"].'';
			    }
			    else
			    {
			    	$link = 'javascript:void(0)';
			    }

			    	$output	.= '
			    	<a href="'.$link.'">
                        <div class="user-img"> '.$profile_image.'</div>
                        <div class="mail-contnet">
                            <h5>'.$row["nama_depan"].'</h5> <span class="mail-desc">'.$row["notification_text"].' <b>'.$string.'</b></span> <span class="time">'.tgl_ago($row["notif_time"]).'</span> </div>
                    </a>
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
		      <i class="mdi mdi-bell-outline"></i>
	            <div class="notify" id="total_notifikasi">
	                <span class="heartbit"></span> <span class="point"></span>
	            </div>';
		    }
		    else
		    {
		      $output = '
		      <i class="mdi mdi-bell-outline"></i>';
		    }
		    echo $output;
		  }
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
		      <i class="ti-comments" style="font-size: 20px; color: #03a9f3;"></i>
		       	<div class="notify" id="notifikasi_chat" style="right: 4px; top: -16px;">
		       		<span class="heartbit"></span> <span class="point"></span>
		       	</div>
				';
		    }
		    else
		    {
		      $output = '
		      <i class="ti-comments" style="font-size: 20px; color: #03a9f3;"></i>';
		    }
		    echo $output;
		  }
	}




}
?>