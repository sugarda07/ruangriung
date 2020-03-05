<?php


function listNotifchat($user_id, $connect)
  {
  try
    {
      $query = "
      SELECT * FROM chat_message
      JOIN user ON user.user_id = chat_message.from_user_id
      WHERE to_user_id = :user_id
      AND notif_chat > 0
      ";  
      $statement = $connect->prepare($query);
      $statement->bindParam("user_id", $user_id);
      $statement->execute();
      $result[0] = true;
      $result[1] = $statement->fetchAll(PDO::FETCH_ASSOC);
      $result[2] = $statement->rowCount();
      return $result;
    }
    catch(PDOException $ex)
    {
      $result[0] = false;
      $result[1] = $ex->getMessage();
      return $result;
    }
  }

  function updateNotifchat($chat_message_id, $connect)
  {
    try
    {
      $query = "
      UPDATE chat_message set notif_chat = notif_chat-1 where chat_message_id=:chat_message_id ";
      $statement = $connect->prepare($query);
      $statement->bindParam("chat_message_id", $chat_message_id);
      $statement->execute();
      $result[0] = true;
      $result[1] = 'sukses';
      return $result;
    }
    catch(PDOException $ex)
    {
      $result[0] = false;
      $result[1] = $ex->getMessage();
      return $result;
    }
  }


function listNotifUser($user_id, $connect)
  {
  try
    {
      $query = "
      SELECT * FROM pemberitahuan
      JOIN user ON user.user_id = pemberitahuan.notif_sender_id
      INNER JOIN postingan ON postingan.post_id = pemberitahuan.notif_post_id
      WHERE notification_receiver_id = :user_id
      AND notif_loop > 0
      AND notif_update <=CURRENT_TIMESTAMP()
      ";  
      $statement = $connect->prepare($query);
      $statement->bindParam("user_id", $user_id);
      $statement->execute();
      $result[0] = true;
      $result[1] = $statement->fetchAll(PDO::FETCH_ASSOC);
      $result[2] = $statement->rowCount();
      return $result;
    }
    catch(PDOException $ex)
    {
      $result[0] = false;
      $result[1] = $ex->getMessage();
      return $result;
    }
  }

  function updateNotif($notification_id, $nextime, $connect)
  {
    try
    {
      $query = "
      UPDATE pemberitahuan set notif_update = :nextime, notif_publis = CURRENT_TIMESTAMP(), notif_loop = notif_loop-1 where notification_id=:notification_id ";
      $statement = $connect->prepare($query);
      $statement->bindParam("notification_id", $notification_id);
      $statement->bindParam("nextime", $nextime);
      $statement->execute();
      $result[0] = true;
      $result[1] = 'sukses';
      return $result;
    }
    catch(PDOException $ex)
    {
      $result[0] = false;
      $result[1] = $ex->getMessage();
      return $result;
    }
  }



function convertToLink($string)  
 {    
    $string = preg_replace("/#+([a-zA-Z0-9_]+)/", '<a href="hashtag.php?tag=$1">$0</a>', $string); 
    $string = preg_replace("/@+([a-zA-Z0-9_]+)/", '<a href="#" class="hover" id="$1">$0</a>', $string); 
    return $string;  
 }

 function convertToLinkpesan($string)  
 {    
    $string = preg_replace("/#+([a-zA-Z0-9_]+)/", '<a href="../hashtag.php?tag=$1" style="color:blue;">$0</a>', $string); 
    $string = preg_replace("/@+([a-zA-Z0-9_]+)/", '<a href="#" class="hover" id="$1" style="color:blue;">$0</a>', $string); 
    return $string;  
 }

function Get_post_id($connect, $post_id)
{
  $query = "
  SELECT post_id FROM postingan 
  WHERE post_id = '".$post_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
  return $row["post_id"];
  }
}

function make_follow_button_profil($connect, $sender_id, $receiver_id)
{
  $query = "
  SELECT * FROM follow 
  WHERE sender_id = '".$sender_id."' 
  AND receiver_id = '".$receiver_id."'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $total_row = $statement->rowCount();
  $output = '';
  if($total_row > 0)
  {
    $output = '<button type="button" name="follow_button" class="btn btn-secondary btn-block waves-effect waves-light action_button" data-proses="unfollow" data-sender_id="'.$sender_id.'"> Diikuti</button>';
  }
  else
  {
    $output = '<button type="button" name="follow_button" class="btn btn-info btn-block waves-effect waves-light action_button" data-proses="follow" data-sender_id="'.$sender_id.'"> Ikuti</button>';
  }
  return $output;
}

function count_mengikuti($connect, $user_id)
{
  $following_query = "
  SELECT * FROM user 
  INNER JOIN follow 
  ON follow.sender_id = user.user_id 
  WHERE follow.receiver_id = '".$user_id."'
  ";
  $statement = $connect->prepare($following_query);
  $statement->execute();
  return $statement->rowCount();
}

function count_pengikut($connect, $user_id)
{
  $following_query = "
  SELECT * FROM user 
  INNER JOIN follow 
  ON follow.receiver_id = user.user_id 
  WHERE follow.sender_id = '".$user_id."'
  ";
  $statement = $connect->prepare($following_query);
  $statement->execute();
  return $statement->rowCount();
}

function count_postingan($connect, $user_id)
{
  $query = "
  SELECT * FROM postingan
  WHERE user_id = '".$user_id."'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  return $statement->rowCount();
}

function Get_user_id($connect, $user_id)
{
  $query = "
  SELECT user_id FROM user 
  WHERE user_id = '".$user_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
  return $row["user_id"];
  }
}

function make_follow_button($connect, $sender_id, $receiver_id)
{
  $query = "
  SELECT * FROM follow 
  WHERE sender_id = '".$sender_id."' 
  AND receiver_id = '".$receiver_id."'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $total_row = $statement->rowCount();
  $output = '';
  if($total_row > 0)
  {
    $output = '<a href="javascript:void(0)" class="action_button text-info"  name="follow_button" type="button" data-proses="unfollow" data-sender_id="'.$sender_id.'">Diikuti</a>';
  }
  else
  {
    $output = '<a href="javascript:void(0)" class="action_button text-info"  name="follow_button" type="button" data-proses="follow" data-sender_id="'.$sender_id.'">Ikuti</a>';

  }
  return $output;
}

function make_follow_button_list($connect, $sender_id, $receiver_id)
{
  $query = "
  SELECT * FROM follow 
  WHERE sender_id = '".$sender_id."' 
  AND receiver_id = '".$receiver_id."'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $total_row = $statement->rowCount();
  $output = '';
  if($total_row > 0)
  {
    $output = '<button type="button" class="btn btn-link action_button" name="follow_button" type="button" data-proses="unfollow" data-sender_id="'.$sender_id.'">Diikuti</button>';
  }
  else
  {
    $output = '<button type="button" class="btn btn-info action_button" name="follow_button" type="button" data-proses="follow" data-sender_id="'.$sender_id.'">Ikuti</button>';

  }
  return $output;
}

function Get_nama_user($connect, $user_id)
{
  $query = "
  SELECT nama_depan FROM user 
  WHERE user_id = '".$user_id."'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
  return $row["nama_depan"];
  }
}

function Get_profile_image($connect, $user_id)
{
  $query = "
  SELECT profile_image, nama_depan FROM user 
  WHERE user_id = '".$user_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $foto_profil = '';
  foreach($result as $row)
  {
    if($row["profile_image"] == 'user.png')
    {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($user_id, $connect);
      if($user_last_activity > $current_timestamp)
      {
        $foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>
        <span class="profile-status online pull-right"></span>';
      }
      else
      {
        $foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
      }
    }
    else
    {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($user_id, $connect);
      if($user_last_activity > $current_timestamp)
      {
        $foto_profil = '<img src="data/akun/profil/'.$row['profile_image'].'" alt="user" class="img-circle"/>
        <span class="profile-status online pull-right"></span>';
      }
      else
      {
        $foto_profil = '<img src="data/akun/profil/'.$row['profile_image'].'" alt="user" class="img-circle"/>';
      }
    }
    return $foto_profil;
  }
}

function Get_profile_image_pesan($connect, $user_id)
{
  $query = "
  SELECT profile_image, nama_depan FROM user 
  WHERE user_id = '".$user_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $foto_profil = '';
  foreach($result as $row)
  {
    if($row["profile_image"] == 'user.png')
    {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($user_id, $connect);
      if($user_last_activity > $current_timestamp)
      {
        $foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>
        <span class="profile-status online pull-right"></span>';
      }
      else
      {
        $foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
      }
    }
    else
    {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($user_id, $connect);
      if($user_last_activity > $current_timestamp)
      {
        $foto_profil = '<img src="../data/akun/profil/'.$row['profile_image'].'" alt="user" class="img-circle"/>
        <span class="profile-status online pull-right"></span>';
      }
      else
      {
        $foto_profil = '<img src="../data/akun/profil/'.$row['profile_image'].'" alt="user" class="img-circle"/>';
      }
    }
    return $foto_profil;
  }
}

function count_comment($connect, $post_id)
{
	$query = "
	SELECT * FROM komentar 
	WHERE post_id = '".$post_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function is_user_has_already_like_content($connect, $user_id, $post_id)
{
	$query = "
	SELECT * FROM like_post 
	WHERE post_id = :post_id
	AND user_id = :user_id
	";
	$statement = $connect->prepare($query);
	$statement->execute(
	array(
		':post_id' =>  $post_id,
		':user_id'  =>  $user_id
		)
	);
	$total_rows = $statement->rowCount();
	if($total_rows > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function count_total_post_like($connect, $post_id)
{
	$query = "
	SELECT * FROM like_post
	WHERE post_id = '".$post_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function Get_profile_komen($connect, $user_id)
{
	$query = "
	SELECT profile_image, nama_depan FROM user 
	WHERE user_id = '".$user_id."'
	";  
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
	if($row["profile_image"] == 'user.png')
    {
     	$foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>';
    }
    else
    {
    	$foto_profil = '<img src="images/profile_image/'.$row["profile_image"].'" class="img-responsive img-circle img-sm" alt="Alt Text">';
    }
    return $foto_profil;
	}
}

function tgl_ago($timestamp)  
 {  
      $time_ago = strtotime($timestamp);  
      $current_time = time();  
      $time_difference = $current_time - $time_ago;  
      $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );           // value 60 is seconds  
      $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
      $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
      $weeks          = round($seconds / 604800);          // 7*24*60*60;  
      $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
      $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
      if($seconds <= 60)  
      {  
     return "Baru saja";  
   }  
      else if($minutes <=60)  
      {  
     if($minutes==1)  
           {  
       return "1 menit yang lalu";  
     }  
     else  
           {  
       return "$minutes menit yang lalu";  
     }  
   }  
      else if($hours <=24)  
      {  
     if($hours==1)  
           {  
       return "1 jam yang lalu";  
     }  
           else  
           {  
       return "$hours jam yang lalu";  
     }  
   }  
      else if($days <= 7)  
      {  
     if($days==1)  
           {  
       return "kemarin";  
     }  
           else  
           {  
       return "$days hari yang lalu";  
     }  
   }  
     
    else  
    {
      return date('d F Y', strtotime($timestamp));
   }  
 }

 function tgl_indo($tgl) {
  $tanggal = substr($tgl,8,2);
  $bulan = getBulan(substr($tgl,5,2));
  $tahun = substr($tgl,0,4);
  return $tanggal.' '.$bulan.' '.$tahun;     
}

function getBulan($bln){
  switch ($bln){
    case 1: 
      return "Januari";
      break;
    case 2:
      return "Februari";
      break;
    case 3:
      return "Maret";
      break;
    case 4:
      return "April";
      break;
    case 5:
      return "Mei";
      break;
    case 6:
      return "Juni";
      break;
    case 7:
      return "Juli";
      break;
    case 8:
      return "Agustus";
      break;
    case 9:
      return "September";
      break;
    case 10:
      return "Oktober";
      break;
    case 11:
      return "November";
      break;
    case 12:
      return "Desember";
      break;
  }
}


function tgl_ago2($timestamp)  
 {  
      $time_ago = strtotime($timestamp);  
      $current_time = time();  
      $time_difference = $current_time - $time_ago;  
      $seconds = $time_difference;  
      $minutes      = round($seconds / 60 );           // value 60 is seconds  
      $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
      $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
      $weeks          = round($seconds / 604800);          // 7*24*60*60;  
      $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
      $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
      if($seconds <= 60)  
      {  
     return "Baru";  
   }  
      else if($minutes <=60)  
      {  
     if($minutes==1)  
           {  
       return "1 mnt";  
     }  
     else  
           {  
       return "$minutes mnt";  
     }  
   }  
      else if($hours <=24)  
      {  
     if($hours==1)  
           {  
       return "1 jam";  
     }  
           else  
           {  
       return "$hours jam";  
     }  
   }  
      else if($days <= 7)  
      {  
     if($days==1)  
           {  
       return "kemarin";  
     }  
           else  
           {  
       return "$days hari";  
     }  
   }  
      else if($weeks <= 4.3) //4.3 == 52/12  
      {  
     if($weeks==1)  
           {  
       return "1 ming";  
     }  
           else  
           {  
       return "$weeks ming";  
     }  
   }  
       else if($months <=12)  
      {  
     if($months==1)  
           {  
       return "1 bln";  
     }  
           else  
           {  
       return "$months bln";  
     }  
   }  
      else  
      {  
     if($years==1)  
           {  
       return "1 thn";  
     }  
           else  
           {  
       return "$years thn";  
     }  
   }  
 }










function Get_user_name2($connect, $user_id)
{
  $query = "
  SELECT nama_depan FROM user 
  WHERE user_id = '".$user_id."'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
  return $row["nama_depan"];
  }
}

function Get_profile_image_chat($connect, $user_id)
{
  $query = "
  SELECT profile_image FROM user 
  WHERE user_id = '".$user_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
    return $row["profile_image"];
  }
}

function Get_nama_depan($from_user_id, $to_user_id, $connect)
{
  $query = "
  SELECT nama_depan FROM user 
  WHERE user_id = '".$to_user_id."'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
  return $row["nama_depan"];
  }
}

function Get_foto($from_user_id, $to_user_id, $connect)
{
  $query = "
  SELECT profile_image, nama_depan FROM user 
  WHERE user_id = '".$to_user_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $foto_profil = '';
  foreach($result as $row)
  {
    if($row["profile_image"] == 'user.png')
    {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($to_user_id, $connect);
      if($user_last_activity > $current_timestamp)
      {
        $foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>
        <span class="profile-status online pull-right"></span>
        <span class="username" style="color: white;">
          '.$row["nama_depan"].'
        </span>&nbsp;
        ';
      }
      else
      {
        $foto_profil = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($row["nama_depan"], 0,1).'</span>
        <span class="username" style="color: white;">
          '.$row["nama_depan"].'
        </span>&nbsp;';
      }
    }
    else
    {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($to_user_id, $connect);
      if($user_last_activity > $current_timestamp)
      {
        $foto_profil = '<img src="../data/akun/profil/'.$row['profile_image'].'" alt="user" class="img-circle"/>
        <span class="profile-status online pull-right"></span>
        <span class="username"  style="color: white;">
          '.$row["nama_depan"].'
        </span>&nbsp;';
      }
      else
      {
        $foto_profil = '<img src="../data/akun/profil/'.$row['profile_image'].'" alt="user" class="img-circle"/>
        <span class="username"  style="color: white;">
          '.$row["nama_depan"].'
        </span>&nbsp;';
      }
    }
    return $foto_profil;
  }
}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
  $query = "
  SELECT * FROM chat_message 
  WHERE from_user_id = '$from_user_id' 
  AND to_user_id = '$to_user_id' 
  AND status = '1'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $count = $statement->rowCount();
  $output = '';
  if($count > 0)
  {
    $output = '<span class="label label-success">'.$count.'</span>';
  }
  return $output;
}

function fetch_is_type_status($user_id, $connect)
{
  $query = "
  SELECT is_type FROM login_details 
  WHERE user_id = '".$user_id."' 
  ORDER BY last_activity DESC 
  LIMIT 1
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  foreach($result as $row)
  {
    if($row["is_type"] == 'yes')
    {
      $output = '<span class="text-muted"><em> sedang mengetik...</em></span>';
    }
  }
  return $output;
}

function fetch_user_last_activity($user_id, $connect)
{
  $query = "
  SELECT * FROM login_details 
  WHERE user_id = '$user_id' 
  ORDER BY last_activity DESC 
  LIMIT 1
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
    return $row['last_activity'];
  }
}

function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
  $query = "
  SELECT * FROM chat_message
  WHERE (from_user_id = '".$from_user_id."' 
  AND to_user_id = '".$to_user_id."') 
  OR (from_user_id = '".$to_user_id."' 
  AND to_user_id = '".$from_user_id."') 
  ORDER BY timestamp ASC 
  ";

  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  foreach($result as $row)
  {
    $user_name = '';
    $profile_image = '';
    $chat_message = '';
    $status_pesan = '';
    $chat_message = $row['chat_konten'];
    $string = strip_tags($chat_message, "<br><br/><br /><a><b><i><u><em><strong>");
    $string = convertToLinkpesan($string);
    if($row["from_user_id"] == $from_user_id)
    {
      if($row["status"] == '2')
      {
        $chat_message = '<span class="fa fa-ban"></span><em>  Pesan ini telah dihapus</em>';
        $user_name = '';
        if($row["status"] == '0')
        {          
          $status_pesan = '<span class="mdi mdi-check-all"></span>';
        }
        if($row["status"] == '1')
        {          
          $status_pesan = '<span class="mdi mdi-check"></span>';
        }
      }
      else
      {
        $chat_message = '<a class="button remove_chat" id="'.$row['chat_message_id'].'">'.$string.'</a>';
        $user_name = '';
        if($row["status"] == '0')
        {          
          $status_pesan = '
          <span class="mdi mdi-check-all"></span>&nbsp;          
          ';
        }
        if($row["status"] == '1')
        {          
          $status_pesan = '
          <span class="mdi mdi-check"></span>&nbsp;';
        }
      }
      $li = 'class="odd"';
      $br = '<br>';
      $class = 'class="box bg-light-inverse"';
    }
    else
    {
      if($row["status"] == '2')
      {
        $chat_message = '<span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em>';
      }
      else
      {
        $chat_message = ''.$string.'';
      }
      $user_name = '<h5>'.Get_user_name2($connect, $row['from_user_id']).'</h5>';
      $profile_image = Get_profile_image_chat($connect, $row['from_user_id']);
      if($profile_image == 'user.png')
      {
        $profile_image = '<span class="round" style="width: 40px; height: 40px; line-height: 40px;">'.substr($user_name, 0,1).'</span>';
      }
      else
      {
        $profile_image = '<div class="chat-img"><img src="../data/akun/profil/'.$profile_image.'" alt="user"></div>';
      }     
      $li = '';
      $br = '';
      $class = 'class="box bg-light-info"';
    }
    $output .= '
                <li '.$li.' style="margin-top: 5px;">
                    <div class="chat-content" style="padding-left: 0px;">
                          <div '.$class.'> '.$chat_message.' &nbsp;&nbsp; '.$status_pesan.'</div>                          
                        '.$br.'
                    </div>
                    <div class="chat-time" style="margin-left: 0px; margin-bottom: 10px;">'.tgl_ago($row['timestamp']).'</div>
                </li>


    ';
  }
  $output .= '  <br>
                <br>';
  $query = "
  UPDATE chat_message 
  SET status = '0' 
  WHERE from_user_id = '".$to_user_id."' 
  AND to_user_id = '".$from_user_id."' 
  AND status = '1'
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  return $output;
}

?>