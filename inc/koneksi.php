<?php

//$connect = new PDO("mysql:host=localhost;dbname=ruang_riung;charset=utf8mb4", "root", "");
$connect = new PDO("mysql:host=localhost;dbname=smkikaka_ruangriung;charset=utf8mb4", "smkikaka_ruangriung", "123ruangriung456");

date_default_timezone_set('Asia/Jakarta');

function count_postinganAll($connect)
{
  $query = "
  SELECT * FROM postingan
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  return $statement->rowCount();
}

function count_pengguna($connect)
{
  $query = "
  SELECT * FROM user
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  return $statement->rowCount();
}

function get_image_post($connect, $post_id)
{
  $query_delete = "SELECT post_gambar FROM postingan WHERE post_id = '$post_id'";
  $statement = $connect->prepare($query_delete);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
    return $row["post_gambar"];
  }
}

function Count_notification($connect, $receiver_id)
{
  $query = "
  SELECT COUNT(notification_id) as total 
  FROM pemberitahuan 
  WHERE notification_receiver_id = '".$receiver_id."' 
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
      $output = '<span class="label label-danger" style="position: absolute;top: 9px;font-size: 8px;padding: 2px 3px;margin-left: -7px;">'.$row["total"].'</span>';
    }
    else
    {
      $output = '';
    }
    echo $output;
  }
}

function Load_notification($connect, $receiver_id)
{
  $query = "
  SELECT * FROM pemberitahuan 
  JOIN user ON user.user_id = pemberitahuan.notif_sender_id
  WHERE notification_receiver_id = '".$receiver_id."' 
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
      $output .= '
      <li>
        <a href="#">
          '.$profile_image.'
          <div class="contacts-list-info">
                <span class="contacts-list-name" style="color: #230069;">
                  '.$row["nama_depan"].'
                  <small class="contacts-list-date pull-right" style="color: #687b8e;">'.tgl_indo($row["notif_time"]).'</small>
                </span>
            <span class="contacts-list-msg" style="color: #818c97;">'.$row["notification_text"].'
            <small class="contacts-list-date pull-right" style="color: #42ef0a;"><span>'.make_follow_button($connect, $row["user_id"], $_SESSION["user_id"]).'</span></small>
            </span>
          </div>
          <!-- /.contacts-list-info -->
        </a>
      </li>
      ';
    }
  }
  return $output;
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
    $output = '<button type="button" class="btn btn-link btn-flat btn-xs action_button" name="follow_button" style="border-top-left-radius: 3px;border-bottom-left-radius: 3px;border-bottom-right-radius: 3px;border-top-right-radius: 3px;" data-proses="unfollow" data-sender_id="'.$sender_id.'"> Diikuti</button>';
  }
  else
  {
    $output = '<button type="button" class="btn btn-info btn-flat btn-xs action_button" name="follow_button" style="border-top-left-radius: 3px;border-bottom-left-radius: 3px;border-bottom-right-radius: 3px;border-top-right-radius: 3px;" data-proses="follow" data-sender_id="'.$sender_id.'"> Ikuti</button>';

  }
  return $output;
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
    $output = '<button type="button" name="follow_button" class="btn btn-link btn-flat btn-block action_button" data-proses="unfollow" data-sender_id="'.$sender_id.'"> Diikuti</button>';
  }
  else
  {
    $output = '<button type="button" name="follow_button" class="btn btn-info btn-flat btn-block action_button" data-proses="follow" data-sender_id="'.$sender_id.'"> Ikuti</button>';

  }
  return $output;
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

function count_mengikuti($connect, $user_id)
{
	$following_query = "
	SELECT * FROM user 
	INNER JOIN follow 
	ON follow.sender_id = user.user_id 
	WHERE follow.receiver_id = '".$user_id."'
	ORDER BY RAND() LIMIT 5
	";
	$statement = $connect->prepare($following_query);
	$statement->execute();
	return $statement->rowCount();
}

function Get_user_name($connect, $user_id)
{
	$query = "
	SELECT username FROM user 
	WHERE user_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
	return $row["username"];
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

function Get_profile_komen($connect, $user_id)
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
	if($row["profile_image"] == '')
    {
     	$foto_profil = ' <img src="images/profile_image/user.png" class="img-responsive img-circle img-sm" alt="Alt Text">';
    }
    else
    {
    	$foto_profil = '<img src="images/profile_image/'.$row["profile_image"].'" class="img-responsive img-circle img-sm" alt="Alt Text">';
    }
    return $foto_profil;
	}
}

function Get_profile_komen2($connect, $user_id)
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
  if($row["profile_image"] == '')
    {
      $foto_profil = ' <img src="../images/profile_image/user.png" class="img-responsive img-circle img-sm" alt="Alt Text">';
    }
    else
    {
      $foto_profil = '<img src="../images/profile_image/'.$row["profile_image"].'" class="img-responsive img-circle img-sm" alt="Alt Text">';
    }
    return $foto_profil;
  }
}

function Get_profile_image($connect, $user_id)
{
  $query = "
  SELECT profile_image FROM user 
  WHERE user_id = '".$user_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $foto_profil = '';
  foreach($result as $row)
  {
  	if($row["profile_image"] == '')
    {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($user_id, $connect);
      if($user_last_activity > $current_timestamp)
      {
        $foto_profil = '<img class="user-image img-bordered-sm" src="images/profile_image/user.png" alt="User Image" style="width: 35px; height: 35px;">';
      }
      else
      {
        $foto_profil = '<img class="user-image" src="images/profile_image/user.png" alt="User Image" style="width: 35px;height: 35px;">';
      }
    }
    else
    {
      $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
      $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
      $user_last_activity = fetch_user_last_activity($user_id, $connect);
      if($user_last_activity > $current_timestamp)
      {
        $foto_profil = '<img class="user-image img-bordered-sm" src="images/profile_image/'.$row["profile_image"].'" alt="User Image" style="width: 35px;height: 35px;">';
      }
      else
      {
        $foto_profil = '<img class="user-image" src="images/profile_image/'.$row['profile_image'].'" alt="User Image" style="width: 35px;height: 35px;">';
      }
    }
    return $foto_profil;
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

function Get_profile_image2($connect, $user_id)
{
  $query = "
  SELECT profile_image FROM user 
  WHERE user_id = '".$user_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $foto_profil = '';
  foreach($result as $row)
  {
  	if($row["profile_image"] == '')
    {
     	$foto_profil = ' <img src="images/profile_image/user.png" class="img-circle" alt="User Image">';
    }
    else
    {
    	$foto_profil = '<img src="images/profile_image/'.$row["profile_image"].'" class="img-circle" alt="User Image">';
    }
    return $foto_profil;
  }
}

function Get_profile_mini($connect, $user_id)
{
  $query = "
  SELECT profile_image FROM user 
  WHERE user_id = '".$user_id."'
  ";  
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $foto_profil = '';
  foreach($result as $row)
  {
    if($row["profile_image"] == '')
    {
      $foto_profil = ' <img src="images/profile_image/user.png" class="img-circle" alt="User Image" style="width:20px; font-size: 20px;">';
    }
    else
    {
      $foto_profil = '<img src="images/profile_image/'.$row["profile_image"].'" class="img-circle" alt="User Image" style="width:20px; font-size: 20px;">';
    }
    return $foto_profil;
  }
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

function is_user_already_content($connect, $user_id, $post_id)
{
 $query = "
 SELECT * FROM postingan 
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
 $total_row = $statement->rowCount();
 $tombol_tool = '';
 if($total_row > 0)
 {
  $tombol_tool = '
      <li><a href="#">Edit</a></li>
      <li><a href="#">Share</a></li>
      <li class="divider"></li>
      <li><a href="#">Hapus</a></li>
  ';
 }
 else
 {
    $tombol_tool = '
      <li><a href="#">Sembunyikan</a></li>
  ';
 }
 return $tombol_tool;
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
      $output = ' <small><em><span class="text-muted"> sedang mengetik...</span></em></small>';
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
  $output = '<div class="box box-primary direct-chat direct-chat-primary" style="border-top: none; box-shadow: unset;">';
  foreach($result as $row)
  {
    $user_name = '';
    $profile_image = '';
    $dynamic_background = '';
    $chat_message = '';
    $atas = '';
    $tanggal = '';
    $gaya = '';
    $tengah = '';
    $status_pesan = '';
    if($row["from_user_id"] == $from_user_id)
    {
      if($row["status"] == '2')
      {
        $chat_message = '<small><span class="fa fa-ban"></span><em>  Pesan ini telah dihapus</em></small>';
        $user_name = 'Anda';
        if($row["status"] == '0')
        {          
          $status_pesan = '<small><span class="fa fa-check-square-o text-primary"></span></small>';
        }
        if($row["status"] == '1')
        {          
          $status_pesan = '<small><span class="fa fa-check"></span></small>';
        }
      }
      else
      {
        $chat_message = ''.$row['chat_konten'].'';
        $user_name = 'Anda';
        if($row["status"] == '0')
        {          
          $status_pesan = '<small>
          <span class="button remove_chat text-muted" id="'.$row['chat_message_id'].'"><span class="fa fa-times"></span></span>
          &nbsp;
          <span class="fa fa-check-square-o text-primary"></span>
          </small>';
        }
        if($row["status"] == '1')
        {          
          $status_pesan = '<small>
          <span class="button remove_chat text-muted" id="'.$row['chat_message_id'].'"><span class="fa fa-times"></span></span>
          &nbsp;
          <span class="fa fa-check"></span>';
        }
      }
      $profile_image = Get_profile_image_chat($connect, $row['from_user_id']);
      if($profile_image == '')
      {
        $profile_image = '<img class="direct-chat-img" src="../images/profile_image/user.png" alt="Message User Image">';
      }
      else
      {
        $profile_image = '<img class="direct-chat-img" src="../images/profile_image/'.$profile_image.'" alt="Message User Image">';
      }
      $atas = 'direct-chat-msg right';
      $tengah = 'pull-right';
      $tanggal = 'pull-left';
    }
    else
    {
      if($row["status"] == '2')
      {
        $chat_message = '<small><span class="fa fa-ban text-muted"></span><em>  Pesan ini telah dihapus</em></small>';
      }
      else
      {
        $chat_message = $row['chat_konten'];
      }
      $tengah = 'pull-left';
      $atas = 'direct-chat-msg';
      $user_name = Get_user_name2($connect, $row['from_user_id']);
      $profile_image = Get_profile_image_chat($connect, $row['from_user_id']);
      if($profile_image == '')
      {
        $profile_image = '<img class="direct-chat-img" src="../images/profile_image/user.png" alt="Message User Image">';
      }
      else
      {
        $profile_image = '<img class="direct-chat-img" src="../images/profile_image/'.$profile_image.'" alt="Message User Image">';
      }
      $tanggal = 'pull-right';
    }
    $output .= '


                <div class="'.$atas.'">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name '.$tengah.'">'.$user_name.'</span>
                    <span class="direct-chat-timestamp '.$tanggal.'"><small>'.tgl_indo($row['timestamp']).'</small> '.$status_pesan.'</span>
                  </div>
                  '.$profile_image.'
                  <div class="direct-chat-text">
                    '.$chat_message.'
                  </div>
                </div>
    ';
  }
  $output .= '</div>';
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