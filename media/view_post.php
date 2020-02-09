<?php
include ('../inc/koneksi.php');
session_start();

if(isset($_POST['proses']))
{
	$output = '';
	if($_POST['proses'] == 'posting_profil')
	{
		$query = "
		SELECT * FROM postingan 
	    INNER JOIN user ON user.user_id = postingan.user_id 
	    WHERE user.user_id = '".$_POST["user_id"]."' 
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
				          <a href="../images/post/'.$row["post_gambar"].'" class="image-popup-vertical-fit" title="'.$row["post_konten"].'">
				          <img class="img-responsive pad" src="../images/post/'.$row["post_gambar"].'" alt="Photo" style="padding: unset;">
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
				          <video class="img-responsive" controls src="../images/post/'.$row["post_video"].'" type="video/mp4" style="padding: unset;"></video>
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
					
					$profile_image = '
					<a href="../images/profile_image/'.$row["profile_image"].'" class="image-popup-no-margins" title="'.$row["nama_depan"].'">
					<img class="img-circle" src="../images/profile_image/'.$row["profile_image"].'" alt="User Image"></a>
					';

					$profile_image2 = Get_profile_komen2($connect, $_SESSION["user_id"]);
				}
				else
				{
					if($row['post_gambar'] !='')
					{				
						$post_gambar = '
						<div class="box-body" align="center" style="padding: unset;">
						<a href="../images/post/'.$row["post_gambar"].'" class="image-popup-vertical-fit" title="'.$row["post_konten"].'">
				          <img class="img-responsive" src="../images/post/'.$row["post_gambar"].'" alt="Photo" style="padding: unset;">
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
				          <video class="img-responsive" controls src="../images/post/'.$row["post_video"].'" type="video/mp4" style="padding: unset;"></video>
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

					$profile_image = '
					<a href="#" class="image-popup-no-margins" title="Belum Upload Foto">
					<img class="img-circle" src="../images/profile_image/user.png" alt="User Image"></a>
					';
					$profile_image2 = Get_profile_komen2($connect, $_SESSION["user_id"]);
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
			            <span class="username"><a href="#">'.$row["nama_depan"].'</a></span>
			            <span class="description">'.tgl_ago($row["post_tgl"]).'</span>
			          </div>
			          <!-- /.user-block -->
			          <div class="box-tools pull-right">
			            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			            </button>
			            <div class="btn-group">
		                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                    <i class="fa fa-ellipsis-v"></i></button><div class="dropdown-backdrop"></div>
		                  <ul class="dropdown-menu" role="menu">
		                    '.is_user_already_content($connect, $_SESSION["user_id"], $row["post_id"]).'	
		                  </ul>
		                </div>
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
					$profile_image = '<img class="img-circle img-sm" src="../images/profile_image/'.$row["profile_image"].'" alt="User Image">';
				}
				else
				{
					$profile_image = '<img class="img-circle img-sm" src="../images/profile_image/user.png" alt="User Image">';
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
}
?>